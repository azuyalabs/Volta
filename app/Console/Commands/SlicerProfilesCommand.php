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

namespace App\Console\Commands;

use DateTime;
use Exception;
use Money\Money;
use function ceil;
use function mkdir;
use Money\Currency;
use const DATE_ATOM;
use function hexdec;
use function is_dir;
use function strlen;
use function strpos;
use function substr;
use function implode;
use function sprintf;
use RuntimeException;
use function file_exists;
use function json_decode;
use function json_encode;
use function str_replace;
use League\Plates\Engine;
use Volta\Domain\Manufacturer;
use function file_get_contents;
use function file_put_contents;
use Illuminate\Console\Command;
use Volta\Domain\FilamentSpool;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Volta\Domain\ValueObject\FilamentSpoolId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

/**
 * Class that handles generating Slicer profiles
 *
 * @package App\Console\Commands
 */
class SlicerProfilesCommand extends Command
{
    /**
     * Name of the disk where the filament spool definitions are stored
     */
    private const FILAMENTS_DISK = 'filaments';

    /**
     * Name of the directory where the filament spool definitions are stored
     */
    private const FILAMENTS_DIRECTORY = 'filaments';

    /**
     * Directory name where template files are stored
     */
    private const TEMPLATES_DIR = 'filaments/_templates';

    /**
     * Directory name where profiles will be stored
     */
    private const PROFILES_DIR = 'filaments/profiles';

    /**
     * List of supported slicers
     *
     * @var array
     */
    protected $slicers = [
        'slic3rpe'    => 'Slic3rPE',
        'cura'        => 'Ultimaker Cura',
        'slic3r'      => 'Slic3r',
        'prusaslicer' => 'Prusa Slicer',
        'kisslicer'   => 'KISSlicer'
    ];

    /**
     * Common settings for 'Bridge Speed Fan' (by filament type)
     *
     * @var array
     */
    protected $bridge_fan_speeds = ['PLA' => 100, 'Woodfill' => 100, 'ABS' => 30, 'PET' => 50];

    /**
     * Common settings for 'Disable Fan First Layers' (by filament type)
     *
     * @var array
     */
    protected $disable_fan_first_layers = ['PLA' => 1, 'Woodfill' => 1, 'ABS' => 0, 'PET' => 3];

    /**
     * Common settings for 'Min Fan Speed' (by filament type)
     *
     * @var array
     */
    protected $min_fan_speed = ['PLA' => 100, 'Woodfill' => 100, 'ABS' => 15, 'PET' => 30];

    /**
     * Common settings for 'Max Fan Speed' (by filament type)
     *
     * @var array
     */
    protected $max_fan_speed = ['PLA' => 100, 'Woodfill' => 100, 'ABS' => 30, 'PET' => 50];

    /**
     * Mapping for the parent filament
     *
     * @var array
     */
    protected $inherits = ['PLA' => 'PLA', 'Woodfill' => 'PLA', 'ABS' => 'ABS', 'PET' => 'PET'];

    /**
     * Common settings for 'Fan Below Layer Time' (by filament type)
     *
     * @var array
     */
    protected $fan_below_layer_time = ['PLA' => 100, 'Woodfill' => 100, 'ABS' => 20, 'PET' => 20];

    /**
     * Common settings for 'Filament Max Volumetric Speed' (by filament type)
     *
     * @var array
     */
    protected $filament_max_volumetric_speed = ['PLA' => 15, 'Woodfill' => 15, 'ABS' => 11, 'PET' => 8];

    /**
     * @var string The console command name
     */
    protected $signature = 'volta:profiles';

    /**
     * @var string The console command description
     */
    protected $description = 'Generate slicer profiles';

    /**
     * Handle to Template Engine
     *
     * @var Engine
     */
    protected $plates;

    protected $filamentsDirectory;

    /**
     * SlicerProfilesCommand constructor.
     */
    public function __construct()
    {
        $this->plates             = new Engine(storage_path('app/' . self::TEMPLATES_DIR), 'ini');
        $this->filamentsDirectory = Storage::disk(self::FILAMENTS_DISK);

        parent::__construct();
    }

    /**
     * Execute the console command
     *
     * @throws Exception
     */
    public function handle(): void
    {
        $filamentFiles = $this->getFilamentFiles();

        $cura_material_settings = [];

        foreach ($filamentFiles as $filamentFile) {
            $f = $this->getFilamentSpoolData($filamentFile);

            // TODO: Implement Application exception
            if (null === $f) {
                echo 'definition is empty. not valid!!';
                continue;
            }

            $color                  = $f['color']['name'] ?? $this->color2Name($f['color']['code']);
            $f['color']['rgba_int'] = hexdec(ltrim($f['color']['code'], '#') . '00');

            $filamentName = implode(' ', [$f['brand'], $f['type'], $color, $f['diameter'] . 'mm']);

            // TODO: Update original filament definition
            //if (!isset($f['id'])) {
            //    $f = ['id' => Uuid::uuid4()] + $f;
            //    \file_put_contents($filamentFile, \json_encode($f, JSON_PRETTY_PRINT));
            // }

            $spool = new FilamentSpool(
                new FilamentSpoolId(),
                new Manufacturer(
                    new ManufacturerId(),
                    new ManufacturerName($f['brand'])
                ),
                $filamentName
            );
            $spool->setPurchasePrice(new Money($f['price'], new Currency('JPY')));

            // Set defaults
            $f['filament_name']                 = $filamentName;
            $f['bridge_fan_speed']              = $this->bridge_fan_speeds[$f['type']];
            $f['disable_fan_first_layers']      = $this->disable_fan_first_layers[$f['type']];
            $f['extrusion_multiplier']          = 1;
            $f['cooling']                       = $f['type'] === 'ABS' ? 0 : 1;
            $f['fan_always_on']                 = $f['type'] === 'ABS' ? 0 : 1;
            $f['k_value']                       = ($f['type'] === 'PET') ? 45 : 30;
            $f['filament_notes']                = sprintf('Calibrated settings for %s.\\n\\n', $filamentName);
            $f['filament_colour']               = $color;
            $f['min_fan_speed']                 = $this->min_fan_speed[$f['type']];
            $f['max_fan_speed']                 = $this->max_fan_speed[$f['type']];
            $f['min_print_speed']               = ($f['type'] === 'ABS') ? 5 : 15;
            $f['fan_below_layer_time']          = $this->fan_below_layer_time[$f['type']];
            $f['filament_max_volumetric_speed'] = $this->filament_max_volumetric_speed[$f['type']];
            $f['inherits']                      = $this->inherits[$f['type']];

            if (!isset($f['first_layer_bed_temperature'])) {
                $f['first_layer_bed_temperature'] = 60;
            }

            if (!isset($f['first_layer_temperature'])) {
                $f['first_layer_temperature'] = 205;
            }

            if (!isset($f['next_layer_bed_temperature'])) {
                $f['next_layer_bed_temperature'] = $f['first_layer_bed_temperature'];
            }

            if (!isset($f['next_layer_temperature'])) {
                $f['next_layer_temperature'] = $f['first_layer_temperature'];
            }

            if (!isset($f['keep_warm_temperature'])) {
                $f['keep_warm_temperature'] = ceil($f['next_layer_temperature'] * 0.65);
            }

            $f['price_per_cm3'] = ($f['price'] * $f['density']) / $f['weight'];

            // Store Cura Material Settings
            $cura_material_settings[(string)$f['id']] = ['spool_weight' => $f['weight'], 'spool_cost' => $f['price']];

            $this->info($filamentName . ' (' . $filamentFile['filename'] . ')');

            # Info
            $f['instructions_url'] = $f['info']['instructions_url'] ?? '';
            $f['msds_url']         = $f['info']['msds_url']         ?? '';
            $f['tds_url']          = $f['info']['tds_url']          ?? '';

            # Retrieve Linear Advance Calibration data
            if (isset($f['k_value_calibrations'])) {
                $kValueCalibration = $f['k_value_calibrations'][0];
                $kvalue            = $kValueCalibration['value'];
                if (isset($kvalue)) {
                    $f['k_value'] = $kvalue;
                    $f['filament_notes'] .= sprintf('K Value last calibrated on %s\\n', $kValueCalibration['date']);
                }
            } else {
                $this->warn('>> Linear Advance Calibration not performed yet.');
            }

            # Retrieve Diameter Calibration data
            if (isset($f['diameter_calibrations'])) {
                $dm     = collect($f['diameter_calibrations']);
                $avg    = $dm->pluck('measurements')->flatten()->average();
                $margin = $avg - $f['diameter'];

                if (isset($avg)) {
                    $this->info(sprintf('Filament Diameter    : %.3fmm [%.3fmm (%.2f%%)]', $avg, $margin, ($margin / $f['diameter'] * 100)));
                    $f['diameter'] = sprintf('%.3f', $avg);
                    $f['filament_notes'] .= sprintf('Filament diameter last calibrated on %s\\n', $dm->pluck('date')->max());
                }
            } else {
                $this->warn('>> Filament Diameter Calibration not performed yet.');
            }

            # Retrieve Extrusion Multiplier Calibration data
            if (isset($f['extrusion_calibrations'])) {
                $em = collect($f['extrusion_calibrations']);

                $newMultiplier = $em->map(static function ($item) {
                    return ($item['extrusion_width'] / collect($item['measurements'])->average()) * $item['multiplier'];
                })->average();

                $avg_extrusion_width = $em->pluck('extrusion_width')->flatten()->average();

                $average = $em->pluck('measurements')->flatten()->average();
                $margin  = $average - $avg_extrusion_width;

                if (isset($newMultiplier)) {
                    $this->info(sprintf('Extrusion Width      : %.3fmm [%.3fmm (%.2f%%)]', $average, $margin, ($margin / $avg_extrusion_width * 100)));
                    $this->info(sprintf('Extrusion Multiplier : %.3f', $newMultiplier));

                    $f['extrusion_multiplier'] = sprintf('%.3f', $newMultiplier);
                    $f['filament_notes'] .= sprintf('Extrusion Multiplier last calibrated on %s\\n', $em->pluck('date')->max());
                }
            } else {
                $this->warn('>> Extrusion Multiplier Calibration not performed yet.');
            }

            // Export profiles for each supported slicer
            foreach ($this->slicers as $slicer_id => $slicer_name) {
                $outputDirectory = storage_path('app/' . self::PROFILES_DIR . DIRECTORY_SEPARATOR . $slicer_id);

                // Create slicer profile directory if not exists
                if (!file_exists($outputDirectory) && !mkdir($outputDirectory, 0777, true) && !is_dir($outputDirectory)) {
                    throw new RuntimeException(sprintf('Directory "%s" could not be created', $outputDirectory));
                }

                $profileFilename = $filamentName . '.ini';

                if ('cura' === $slicer_id) {
                    $profileFilename = str_replace(' ', '_', $filamentName) . '.xml.fdm_material';

                    // Output Cura Material Settings (replace this in your cura.cfg file)
                    file_put_contents($outputDirectory . DIRECTORY_SEPARATOR . 'cura_material_settings.txt', 'material_settings = ' . json_encode($cura_material_settings));
                }

                // Save output
                file_put_contents(
                    $outputDirectory . DIRECTORY_SEPARATOR . $profileFilename,
                    $this->plates->render($slicer_id, [
                        'generated_on' => (new DateTime())->format(DATE_ATOM),
                        'profile'      => $f
                    ])
                );
            }
            $this->line('');
        }

        $this->info('Profiles successfully generated for ' . implode(', ', $this->slicers));
    }

    /**
     * Get the name of a colour based on its hexadecimal code
     *
     * @param string $color the colour hexadecimal code
     * @return string the name of the colour
     */
    protected function color2Name(string $color): string
    {
        // Strip any preceding hash character
        $needle = '#';
        if (strpos($color, $needle) >= 0) {
            $color = substr($color, strlen($needle));
        }

        $response  = file_get_contents('http://www.thecolorapi.com/id?hex=' . $color);
        $color_api = json_decode($response, true);

        return $color_api['name']['value'] ?? $color;
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
        $CACHE_KEY = 'filament_spool_' . $filamentFile['id'];

        if (!Cache::has($CACHE_KEY)) {
            Cache::put($CACHE_KEY, json_decode($this->filamentsDirectory->get(
                self::FILAMENTS_DIRECTORY .
                DIRECTORY_SEPARATOR .
                $filamentFile['name']
            ), true));
        }
        return Cache::get($CACHE_KEY);
    }
}
