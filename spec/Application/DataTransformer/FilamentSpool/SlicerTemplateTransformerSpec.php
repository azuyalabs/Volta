<?php

namespace spec\Volta\Application\DataTransformer\FilamentSpool;

use OzdemirBurak\Iris\Color\Hex;
use PhpSpec\ObjectBehavior;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use Tests\FilamentSpoolBuilder;
use Volta\Application\DataTransformer\FilamentSpool\SlicerTemplateTransformer;
use Volta\Domain\Calibration;
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
        $builder->withMaterialType(new MaterialType(MaterialType::MATERIALTYPE_PETG));
        $builder->withDensity(1.22);
        $builder->withColor(new Color(new ColorName('Red'), new Hex('#ff0000')));
        $builder->withCalibration(
            new Calibration(
                new CalibrationName('first_layer_print_temperature'),
                new \DateTimeImmutable('2020-05-01'),
                [200, 205, 207]
            )
        );
        $builder->withCalibration(
            new Calibration(
                new CalibrationName('next_layer_print_temperature'),
                new \DateTimeImmutable('2020-05-01'),
                [210, 212]
            )
        );
        $builder->withCalibration(
            new Calibration(
                new CalibrationName('next_layer_bed_temperature'),
                new \DateTimeImmutable('2020-05-01'),
                [72, 80]
            )
        );
        $builder->withCalibration(
            new Calibration(
                new CalibrationName('diameter'),
                new \DateTimeImmutable('2020-05-01'),
                [1.77, 1.78, 1.74]
            )
        );
        $spool = $builder->build();

        $this->transform($spool)->shouldIterateLike(
            [
                'id'                            => $spool->getId()->getValue(),
                'name'                          => 'PETG Plus',
                'manufacturer'                  => 'ABC Plastics',
                'diameter'                      => 1.763,
                'weight'                        => 900,
                'material'                      => 'PETG',
                'density'                       => 1.22,
                'price'                         => 0,
                'color'                         => 'Red',
                'color_code'                    => '#ff0000',
                'display_name'                  => 'ABC Plastics PETG Plus Red 1.75mm',
                'min_fan_speed'                 => 30,
                'max_fan_speed'                 => 50,
                'min_print_speed'               => 15,
                'first_layer_print_temperature' => 204.0,
                'next_layer_print_temperature'  => 211.0,
                'first_layer_bed_temperature'   => 75.0,
                'next_layer_bed_temperature'    => 76.0,
                'note'                          => 'Calibrated settings for ABC Plastics PETG Plus Red 1.75mm.\n\n',
            ]
        );
    }
}
