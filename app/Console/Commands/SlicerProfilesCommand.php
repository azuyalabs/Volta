<?php
/**
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2019. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

declare(strict_types=1);

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use League\Fractal\Serializer\ArraySerializer;
use League\Plates\Engine;
use Money\Currency;
use Money\Money;
use OzdemirBurak\Iris\Color\Hex;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use PhpUnitsOfMeasure\PhysicalQuantity\Temperature;
use Spatie\Fractalistic\Fractal;
use Volta\Application\DataTransformer\FilamentSpool\SlicerTemplateTransformer;
use Volta\Domain\Calibration;
use Volta\Domain\CalibrationCollection;
use Volta\Domain\CalibrationParameters;
use Volta\Domain\FilamentSpool;
use Volta\Domain\Manufacturer;
use Volta\Domain\Temperatures;
use Volta\Domain\ValueObject\CalibrationName;
use Volta\Domain\ValueObject\FilamentSpool\Color;
use Volta\Domain\ValueObject\FilamentSpool\ColorName;
use Volta\Domain\ValueObject\FilamentSpool\FilamentSpoolId;
use Volta\Domain\ValueObject\FilamentSpool\MaterialType;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

/**
 * Class that handles generating Slicer profiles.
 */
class SlicerProfilesCommand extends Command
{
    /**
     * Name of the disk where the filament spool definitions are stored.
     */
    private const FILAMENTS_DISK = 'filaments';

    /**
     * Name of the disk where the (generated) slicer filament spool definitions are stored.
     */
    private const SLICER_FILAMENTS_DISK = 'slicer_filaments';

    /**
     * Name of the directory where the filament spool definitions are stored.
     */
    private const FILAMENTS_DIRECTORY = 'filaments';

    /**
     * Directory name where template files are stored.
     */
    private const TEMPLATES_DIR = 'filaments/_templates';

    /**
     * Directory name where profiles will be stored.
     */
    private const PROFILES_DIR = 'filaments/profiles';

    protected array $slicers = [
        'slic3rpe'    => 'Slic3rPE',
        'cura'        => 'Ultimaker Cura',
        'slic3r'      => 'Slic3r',
        'prusaslicer' => 'Prusa Slicer',
        'kisslicer'   => 'KISSlicer',
        'superslicer' => 'SuperSlicer',
    ];
    /**
     * Common settings for 'Fan Below Layer Time' (by filament type).
     */
    protected $signature = 'volta:profiles';

    protected $description = 'Generate slicer profiles';

    protected Engine $plates;

    protected Filesystem $filamentsDirectory;

    protected FileSystem $fila;

    /**
     * SlicerProfilesCommand constructor.
     */
    public function __construct()
    {
        $this->plates             = new Engine(storage_path('app/'.self::TEMPLATES_DIR), 'ini');
        $this->filamentsDirectory = Storage::disk(self::FILAMENTS_DISK);
        $this->fila               = Storage::disk(self::SLICER_FILAMENTS_DISK);

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(): void
    {
        $filamentFiles = $this->getFilamentFiles();

        $cura_material_settings = [];

        foreach ($filamentFiles as $filamentFile) {
            if ('file' !== $filamentFile['type']) {
                continue;
            }
            $f = $this->getFilamentSpoolData($filamentFile);

            if (!isset($f['product'], $f['id']) || null === $f) {
                $this->warn(sprintf(
                    '! `%s` is invalid (Perhaps empty or an older version?)',
                    $filamentFile['basename']
                ));

                continue;
            }

            $spool = new FilamentSpool(
                new FilamentSpoolId(),
                new Manufacturer(
                    new ManufacturerId(),
                    new ManufacturerName($f['product']['manufacturer']),
                ),
                $f['product']['name'],
                new Color(new ColorName($f['product']['color']['name']), new Hex($f['product']['color']['code'])),
                new Length($f['product']['diameter']['value'], 'millimeters')
            );
            $this->info($spool->getDisplayName()->getValue().' ('.$spool->getId().')');

            $spool->setPurchasePrice(new Money(
                $f['purchase_price']['value'],
                new Currency($f['purchase_price']['currency'])
            ))
                ->setWeight(new Mass($f['product']['spool_weight'], 'gram'))
                ->setMaterialType(new MaterialType($f['product']['type']))
            ;

            if (isset($f['product']['density'])) {
                $spool->setDensity($f['product']['density']);
            }

            if (isset($f['product']['diameter']['tolerance'])) {
                $spool->setDiameterTolerance(new Length($f['product']['diameter']['tolerance'], 'millimeters'));
            }

            if (isset($f['product']['ovality']['tolerance'])) {
                $spool->setOvalityTolerance(new Length($f['product']['ovality']['tolerance'], 'millimeters'));
            }

            if (isset($f['product']['temperatures']['print'])) {
                $spool->setPrintTemperatures(
                    new Temperatures(
                        new Temperature($f['product']['temperatures']['print']['min'], 'celsius'),
                        new Temperature($f['product']['temperatures']['print']['max'], 'celsius')
                    )
                );
            }

            if (isset($f['product']['temperatures']['heated_bed'])) {
                $spool->setBedTemperatures(
                    new Temperatures(
                        new Temperature(191, 'celsius'),new Temperature(230, 'celsius'),
                        new Temperature($f['product']['temperatures']['heated_bed']['min'], 'celsius'),
                        new Temperature($f['product']['temperatures']['heated_bed']['max'], 'celsius')
                    )
                );
            }

            if (isset($f['calibrations'])) {
                foreach ($f['calibrations'] as $name => $cals) {
                    foreach ($cals as $cal) {
                        $c = new Calibration(
                            new CalibrationName($name),
                            new \DateTimeImmutable($cal['date']),
                            $cal['measurements'] ?? [],
                            new CalibrationParameters($cal['parameters'] ?? [])
                        );
                        $spool->addCalibration($c);
                    }
                }

                // Notify if some calibrations are not performed yet
                $missed = array_diff([
                    CalibrationCollection::EXTRUSION_MULTIPLIER,
                    CalibrationCollection::FILAMENT_DIAMETER,
                    CalibrationCollection::K_VALUE,
                ], array_keys($f['calibrations']));
                foreach ($missed as $miss) {
                    $this->warn(sprintf(
                        '>> `%s` Calibration not performed yet.',
                        ucwords(str_replace('_', ' ', $miss))
                    ));
                }
            }

            // Transform into a flat array structure
            $f = Fractal::create()
                ->item($spool, new SlicerTemplateTransformer())
                ->serializeWith(new ArraySerializer())
                ->toArray()
            ;

//            $f['price_per_cm3'] = ($f['price'] * $f['density']) / $f['weight'];
//
//            // Store Cura Material Settings
//            $cura_material_settings[(string)$f['id']] = ['spool_weight' => $f['weight'], 'spool_cost' => $f['purchase_price']['value']];
//
//            # Info
//            $f['instructions_url'] = $f['info']['instructions_url']          ?? '';
//            $f['msds_url']         = $f['info']['msds_url']                  ?? '';
//            $f['tds_url']          = $f['info']['tds_url']                   ?? '';
//

            // Export profiles for each supported slicer
            foreach ($this->slicers as $slicer_id => $slicer_name) {
                $profileFilename = $spool->getDisplayName()->getValue().'.ini';

                if ('cura' === $slicer_id) {
                    $profileFilename = str_replace(' ', '_', $spool->getDisplayName()->getValue()).'.xml.fdm_material';
                }

                $contents = $this->plates->render($slicer_id, [
                    'generated_on' => (new \DateTimeImmutable())->format(DATE_ATOM),
                    'profile'      => $f,
                ]);

                $this->fila->put(
                    $slicer_id.DIRECTORY_SEPARATOR.'filament'.DIRECTORY_SEPARATOR.$profileFilename,
                    $contents
                );

                /*
                if ('cura' === $slicer_id) {
                    // Output Cura Material Settings (replace this in your cura.cfg file)
                    file_put_contents(
                        $outputDirectory.DIRECTORY_SEPARATOR.'cura_material_settings.txt',
                        'material_settings = '.json_encode($cura_material_settings, JSON_THROW_ON_ERROR, 512)
                    );
                }
                */
            }
            $this->line('');
        }

        $this->info('Profiles successfully generated for '.implode(', ', $this->slicers));
    }

    private function getFilamentFiles(): array
    {
        static $CACHE_KEY = 'filament_files';

        if (!Cache::has($CACHE_KEY)) {
            Cache::put($CACHE_KEY, $this->filamentsDirectory->listContents(self::FILAMENTS_DIRECTORY));
        }

        return Cache::get($CACHE_KEY);
    }

    private function getFilamentSpoolData($filamentFile): array
    {
        $CACHE_KEY = 'filament_spool_'.$filamentFile['id'];

        if (!Cache::has($CACHE_KEY)) {
            Cache::put(
                $CACHE_KEY,
                json_decode(
                    $this->filamentsDirectory->get(
                        self::FILAMENTS_DIRECTORY.DIRECTORY_SEPARATOR.$filamentFile['name']
                    ),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                )
            );
        }

        return Cache::get($CACHE_KEY);
    }
}
