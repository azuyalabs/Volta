<?php

declare(strict_types=1);

namespace spec\Volta\Application\DataTransformer\FilamentSpool;

use Money\Currency;
use Money\Money;
use OzdemirBurak\Iris\Color\Hex;
use PhpSpec\ObjectBehavior;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use Tests\FilamentSpoolBuilder;
use Volta\Application\DataTransformer\FilamentSpool\SlicerTemplateTransformer;
use Volta\Domain\Calibration;
use Volta\Domain\CalibrationCollection;
use Volta\Domain\CalibrationParameters;
use Volta\Domain\Manufacturer;
use Volta\Domain\ValueObject\CalibrationName;
use Volta\Domain\ValueObject\FilamentSpool\Color;
use Volta\Domain\ValueObject\FilamentSpool\ColorName;
use Volta\Domain\ValueObject\FilamentSpool\MaterialType;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

class SlicerTemplateTransformerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SlicerTemplateTransformer::class);
    }

    public function it_transforms_to_slicer_template(): void
    {
        $builder = new FilamentSpoolBuilder();
        $builder->withManufacturer(new Manufacturer(new ManufacturerId(), new ManufacturerName('ABC Plastics')));
        $builder->withDiameter(new Length(1.75, 'millimeter'));
        $builder->withWeight(new Mass(900, 'grams'));
        $builder->withPurchasePrice(new Money(28, new Currency('USD')));
        $builder->withMaterialType(new MaterialType(MaterialType::MATERIALTYPE_PET));
        $builder->withDensity(1.22);
        $builder->withColor(new Color(new ColorName('Red'), new Hex('#ff0000')));
        $builder->withCalibration(
            new Calibration(
                new CalibrationName(CalibrationCollection::FIRST_LAYER_PRINT_TEMP),
                new \DateTimeImmutable('2020-05-01'),
                [200, 205, 207]
            )
        );
        $builder->withCalibration(
            new Calibration(
                new CalibrationName(CalibrationCollection::NEXT_LAYER_PRINT_TEMP),
                new \DateTimeImmutable('2020-05-01'),
                [210, 212]
            )
        );
        $builder->withCalibration(
            new Calibration(
                new CalibrationName(CalibrationCollection::NEXT_LAYER_BED_TEMP),
                new \DateTimeImmutable('2020-05-01'),
                [72, 80]
            )
        );
        $builder->withCalibration(
            new Calibration(
                new CalibrationName(CalibrationCollection::FILAMENT_DIAMETER),
                new \DateTimeImmutable('2020-05-01'),
                [1.77, 1.78, 1.74]
            )
        );

        $builder->withCalibration(
            new Calibration(
                new CalibrationName(CalibrationCollection::K_VALUE),
                new \DateTimeImmutable('2020-06-12'),
                [1.77, 0.63, 0.46]
            )
        );
        $builder->withCalibration(
            new Calibration(
                new CalibrationName(CalibrationCollection::EXTRUSION_MULTIPLIER),
                new \DateTimeImmutable('2020-08-02'),
                [0.46, 0.47, 0.47],
                new CalibrationParameters([
                    CalibrationParameters::PRIOR_MULTIPLIER => 1,
                    CalibrationParameters::EXTRUSION_WIDTH  => 0.45,
                ])
            )
        );

        $spool = $builder->build();

        $this->transform($spool)->shouldIterateLike(
            [
                'id'                            => $spool->getId()->getValue(),
                'name'                          => 'PET Plus',
                'manufacturer'                  => 'ABC Plastics',
                'diameter'                      => 1.763,
                'weight'                        => 900,
                'material'                      => 'PET',
                'density'                       => 1.22,
                'purchase_price'                => 28.0,
                'price_per_kg'                  => 31,
                'color'                         => 'Red',
                'color_code'                    => '#ff0000',
                'display_name'                  => 'ABC Plastics PET Plus Red 1.75mm',
                'min_fan_speed'                 => 30,
                'max_fan_speed'                 => 50,
                'bridging_fan_speed'            => 50,
                'min_print_speed'               => 15,
                'first_layer_print_temperature' => 204.0,
                'next_layer_print_temperature'  => 211.0,
                'first_layer_bed_temperature'   => 75.0,
                'next_layer_bed_temperature'    => 76.0,
                'keep_warm_temperature'         => 137.0,
                'maximum_volumetric_speed'      => 8.0,
                'auto_cooling'                  => 1,
                'note'                          => 'Calibrated settings for ABC Plastics PET Plus Red 1.75mm.\n\n`First Layer Print Temperature` last calibrated on 2020-05-01\n`Next Layer Print Temperature` last calibrated on 2020-05-01\n`Next Layer Bed Temperature` last calibrated on 2020-05-01\n`Diameter` last calibrated on 2020-05-01\n`K Value` last calibrated on 2020-06-12',
                'disable_fan_first_layers'      => 3,
                'k_value'                       => 0.953,
                'fan_always_on'                 => 1,
                'fan_below_layer_time'          => 20,
                'extrusion_multiplier'          => 0.982,
            ]
        );
    }
}
