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

namespace spec\Volta\Domain;

use Money\Currency;
use Money\Money;
use OzdemirBurak\Iris\Color\Hex;
use PhpSpec\ObjectBehavior;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use PhpUnitsOfMeasure\PhysicalQuantity\Temperature;
use Volta\Domain\Calibration;
use Volta\Domain\CalibrationCollection;
use Volta\Domain\Exception\ZeroDensityException;
use Volta\Domain\Exception\ZeroDiameterException;
use Volta\Domain\Exception\ZeroWeightException;
use Volta\Domain\FilamentSpool;
use Volta\Domain\Manufacturer;
use Volta\Domain\Temperatures;
use Volta\Domain\ValueObject\CalibrationName;
use Volta\Domain\ValueObject\FilamentSpool\Color;
use Volta\Domain\ValueObject\FilamentSpool\ColorName;
use Volta\Domain\ValueObject\FilamentSpool\DisplayName;
use Volta\Domain\ValueObject\FilamentSpool\MaterialType;
use Volta\Domain\ValueObject\FilamentSpool\MaximumFanSpeed;
use Volta\Domain\ValueObject\FilamentSpool\MinimumFanSpeed;
use Volta\Domain\ValueObject\FilamentSpool\MinimumPrintSpeed;
use Volta\Domain\ValueObject\FilamentSpoolId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

class FilamentSpoolSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(
            new FilamentSpoolId(),
            new Manufacturer(
                new ManufacturerId(),
                new ManufacturerName('ABC Plastics')
            ),
            'Super PLA'
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FilamentSpool::class);
    }

    public function it_has_an_identifier(): void
    {
        $this->getId()->shouldReturnAnInstanceOf(FilamentSpoolId::class);
    }

    public function it_has_a_name(): void
    {
        $this->getName()->shouldBe('Super PLA');
    }

    public function it_can_update_the_name(): void
    {
        $newName = 'PLA Old Purple';
        $this->setName($newName);
        $this->getName()->shouldBe($newName);
    }

    public function it_has_a_purchase_price(): void
    {
        $this->getPurchasePrice()->shouldReturnAnInstanceOf(Money::class);
    }

    public function it_can_update_the_purchase_price(): void
    {
        $newPrice = new Money(4500, new Currency('JPY'));

        $this->setPurchasePrice($newPrice);
        $this->getPurchasePrice()->shouldBe($newPrice);
    }

    public function it_has_a_manufacturer(): void
    {
        $this->getManufacturer()->shouldReturnAnInstanceOf(Manufacturer::class);
    }

    public function it_can_update_manufacturer(Manufacturer $manufacturer): void
    {
        $this->setManufacturer($manufacturer);
        $this->getManufacturer()->shouldBe($manufacturer);
    }

    public function it_has_a_weight(): void
    {
        $this->getWeight()->shouldReturnAnInstanceOf(Mass::class);
    }

    public function it_can_update_weight(): void
    {
        $weight = new Mass(50.5, 'grams');

        $this->setWeight($weight);
        $this->getWeight()->shouldBe($weight);
    }

    public function it_throws_exception_setting_weight_to_zero(): void
    {
        $this->shouldThrow(ZeroWeightException::class)
            ->duringSetWeight(new Mass(0, 'grams'));
    }

    public function it_has_a_price_per_weight(): void
    {
        static $currency = 'JPY';
        $price           = new Money(5700, new Currency($currency));
        $weight          = new Mass(850, 'gram');

        $this->setWeight($weight);
        $this->setPurchasePrice($price);

        $this->getPricePerWeight()->shouldBeAnInstanceOf(Money::class);
        $this->getPricePerWeight()->getAmount()->shouldBeLike(6706);
        $this->getPricePerWeight()->getCurrency()->getCode()->shouldBe($currency);
    }

    public function it_has_a_price_per_kilogram(): void
    {
        static $currency = 'USD';
        $price           = new Money(2800, new Currency($currency));
        $weight          = new Mass(750, 'gram');

        $this->setWeight($weight);
        $this->setPurchasePrice($price);

        $this->getPricePerWeight()->shouldBeAnInstanceOf(Money::class);
        $this->getPricePerWeight()->getAmount()->shouldBeLike(3733);
        $this->getPricePerWeight()->getCurrency()->getCode()->shouldBe($currency);
    }

    public function it_has_a_nominal_diameter(): void
    {
        $this->getNominalDiameter()->shouldReturnAnInstanceOf(Length::class);
    }

    public function it_can_update_the_nominal_diameter(): void
    {
        $diameter = new Length(0.1, 'meters');

        $this->setNominalDiameter($diameter);
        $this->getNominalDiameter()->shouldBe($diameter);
    }

    public function it_throws_exception_setting_nominal_diameter_to_zero(): void
    {
        $this->shouldThrow(ZeroDiameterException::class)
            ->duringSetNominalDiameter(new Length(0, 'meters'));
    }

    public function it_has_a_diameter(): void
    {
        $this->addCalibration(new Calibration(
            new CalibrationName('diameter'),
            new \DateTimeImmutable('2020-03-08'),
            [1.74, 1.72, 1.74, 1.76, 1.77]
        ));
        $this->getDiameter()->shouldBeAnInstanceOf(Length::class);
        $this->getDiameter()->toUnit('millimeter')->shouldBe(1.746);
    }

    public function it_has_a_diameter_when_no_calibrations(): void
    {
        $this->getDiameter()->shouldBeAnInstanceOf(Length::class);
        $this->getDiameter()->toUnit('millimeter')->shouldBe(1.75);
    }

    public function it_has_a_diameter_tolerance(): void
    {
        $this->getDiameterTolerance()->shouldReturnAnInstanceOf(Length::class);
    }

    public function it_can_update_diameter_tolerance(): void
    {
        $tolerance = new Length(0.03, 'millimeters');

        $this->setDiameterTolerance($tolerance);
        $this->getDiameterTolerance()->shouldBe($tolerance);
    }

    public function it_has_a_materialtype(): void
    {
        $this->getMaterialType()->shouldReturnAnInstanceOf(MaterialType::class);
    }

    public function it_can_update_materialtype(): void
    {
        $type = new MaterialType('PP');

        $this->setMaterialType($type);
        $this->getMaterialType()->shouldBe($type);
    }

    public function it_has_a_color(): void
    {
        $this->getColor()->shouldReturnAnInstanceOf(Color::class);
        $this->getColor()->getColorName()->getValue()->shouldBe('Red');
    }

    public function it_can_update_color(): void
    {
        $color = new Color(new ColorName('Blue'), new Hex('#0000ff'));

        $this->setColor($color);
        $this->getColor()->shouldBe($color);
    }

    public function it_has_a_display_name(): void
    {
        $this->getDisplayName()->shouldReturnAnInstanceOf(DisplayName::class);
        $this->getDisplayName()->getValue()->shouldBe('ABC Plastics Super PLA Red 1.75mm');
    }

    public function it_has_a_minimum_fan_speed(): void
    {
        $this->getMinimumFanSpeed()->shouldReturnAnInstanceOf(MinimumFanSpeed::class);
        $this->getMinimumFanSpeed()->getValue()->shouldBe(100);

        $this->setMaterialType(new MaterialType(MaterialType::MATERIALTYPE_ABS));
        $this->getMinimumFanSpeed()->getValue()->shouldBe(15);

        $this->setMaterialType(new MaterialType(MaterialType::MATERIALTYPE_PLA));
        $this->getMinimumFanSpeed()->getValue()->shouldBe(100);

        $this->setMaterialType(new MaterialType(MaterialType::MATERIALTYPE_PETG));
        $this->getMinimumFanSpeed()->getValue()->shouldBe(30);

        $this->setMaterialType(new MaterialType(MaterialType::MATERIALTYPE_WOODFILL));
        $this->getMinimumFanSpeed()->getValue()->shouldBe(100);
    }

    public function it_has_a_maximum_fan_speed(): void
    {
        $this->getMaximumFanSpeed()->shouldReturnAnInstanceOf(MaximumFanSpeed::class);
        $this->getMaximumFanSpeed()->getValue()->shouldBe(100);

        $this->setMaterialType(new MaterialType(MaterialType::MATERIALTYPE_ABS));
        $this->getMaximumFanSpeed()->getValue()->shouldBe(30);

        $this->setMaterialType(new MaterialType(MaterialType::MATERIALTYPE_PLA));
        $this->getMaximumFanSpeed()->getValue()->shouldBe(100);

        $this->setMaterialType(new MaterialType(MaterialType::MATERIALTYPE_PETG));
        $this->getMaximumFanSpeed()->getValue()->shouldBe(50);

        $this->setMaterialType(new MaterialType(MaterialType::MATERIALTYPE_WOODFILL));
        $this->getMaximumFanSpeed()->getValue()->shouldBe(100);
    }

    public function it_has_a_minimum_print_speed(): void
    {
        $this->getMinimumPrintSpeed()->shouldReturnAnInstanceOf(MinimumPrintSpeed::class);
        $this->getMinimumPrintSpeed()->getValue()->shouldBe(15.0);

        $this->setMaterialType(new MaterialType(MaterialType::MATERIALTYPE_ABS));
        $this->getMinimumPrintSpeed()->getValue()->shouldBe(5.0);
    }

    public function it_has_print_temperatures(): void
    {
        $this->getPrintTemperatures()->shouldReturnAnInstanceOf(Temperatures::class);
        $this->getPrintTemperatures()->getMinimumPrintTemperature()->toUnit('celsius')->shouldBe(Temperatures::DEFAULT_MIN_PRINT_TEMP);
        $this->getPrintTemperatures()->getMaximumPrintTemperature()->toUnit('celsius')->shouldBe(Temperatures::DEFAULT_MAX_PRINT_TEMP);
    }

    public function it_can_update_print_temperatures(): void
    {
        $this->setPrintTemperatures(
            new Temperatures(
                new Temperature(167, 'celsius'),
                new Temperature(235, 'celsius')
            )
        );
        $this->getPrintTemperatures()->getMinimumPrintTemperature()->toUnit('celsius')->shouldBe(167.0);
        $this->getPrintTemperatures()->getMaximumPrintTemperature()->toUnit('celsius')->shouldBe(235.0);
    }

    public function it_has_bed_temperatures(): void
    {
        $this->getBedTemperatures()->shouldReturnAnInstanceOf(Temperatures::class);
        $this->getBedTemperatures()->getMinimumBedTemperature()->toUnit('celsius')->shouldBe(Temperatures::DEFAULT_MIN_BED_TEMP);
        $this->getBedTemperatures()->getMaximumBedTemperature()->toUnit('celsius')->shouldBe(Temperatures::DEFAULT_MAX_BED_TEMP);
    }

    public function it_can_update_bed_temperatures(): void
    {
        $this->setBedTemperatures(
            new Temperatures(
                null,
                null,
                new Temperature(63, 'celsius'),
                new Temperature(82, 'celsius')
            )
        );
        $this->getBedTemperatures()->getMinimumBedTemperature()->toUnit('celsius')->shouldBe(63.0);
        $this->getBedTemperatures()->getMaximumBedTemperature()->toUnit('celsius')->shouldBe(82.0);
    }

    public function it_has_a_density(): void
    {
        $this->getDensity()->shouldBeDouble();
        $this->getDensity()->shouldBe(1.0);
    }

    public function it_can_update_density(): void
    {
        $density = 1.27;

        $this->setDensity($density);
        $this->getDensity()->shouldBe($density);
    }

    public function it_throws_exception_setting_density_to_zero(): void
    {
        $this->shouldThrow(ZeroDensityException::class)
            ->duringSetDensity(0.0);
    }

    public function it_has_an_ovality_tolerance(): void
    {
        $this->getOvalityTolerance()->shouldReturnAnInstanceOf(Length::class);
    }

    public function it_can_update_ovality_tolerance(): void
    {
        $tolerance = new Length(0.03, 'millimeters');

        $this->setOvalityTolerance($tolerance);
        $this->getOvalityTolerance()->shouldBe($tolerance);
    }

    public function it_can_add_a_calibration(): void
    {
        $calibration = new Calibration(
            new CalibrationName('volume'),
            new \DateTimeImmutable('2020-04-05'),
            [10, 20]
        );
        $this->addCalibration($calibration);
        $this->getCalibrations()->shouldReturnAnInstanceOf(CalibrationCollection::class);
        $this->getCalibrations()->getCalibrations('volume')->shouldReturn([$calibration]);
    }

    public function it_has_a_first_layer_print_temperature(): void
    {
        $calibration = new Calibration(
            new CalibrationName('first_layer_print_temperature'),
            new \DateTimeImmutable('2020-04-05'),
            [210, 215]
        );
        $this->addCalibration($calibration);

        $this->getFirstLayerPrintTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getFirstLayerPrintTemperature()->toUnit('celsius')->shouldBe(213.0);
    }

    public function it_has_a_first_layer_print_temperature_when_multiple_calibrations(): void
    {
        $calibration = new Calibration(
            new CalibrationName('first_layer_print_temperature'),
            new \DateTimeImmutable('2020-04-05'),
            [212, 213]
        );
        $this->addCalibration($calibration);

        $this->addCalibration(
            new Calibration(
                new CalibrationName('first_layer_print_temperature'),
                new \DateTimeImmutable('2020-04-06'),
                [211, 223]
            )
        );

        $this->getFirstLayerPrintTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getFirstLayerPrintTemperature()->toUnit('celsius')->shouldBe(215.0);
    }

    public function it_has_a_first_layer_print_temperature_when_no_calibrations(): void
    {
        $this->setPrintTemperatures(
            new Temperatures(
                new Temperature(220, 'celsius'),
                new Temperature(250, 'celsius')
            )
        );
        $this->getFirstLayerPrintTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getFirstLayerPrintTemperature()->toUnit('celsius')->shouldBe(220.0);
    }

    public function it_has_a_next_layer_print_temperature(): void
    {
        $calibration = new Calibration(
            new CalibrationName('next_layer_print_temperature'),
            new \DateTimeImmutable('2020-04-05'),
            [190, 205]
        );
        $this->addCalibration($calibration);

        $this->getNextLayerPrintTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getNextLayerPrintTemperature()->toUnit('celsius')->shouldBe(198.0);
    }

    public function it_has_a_next_layer_print_temperature_when_multiple_calibrations(): void
    {
        $calibration = new Calibration(
            new CalibrationName('next_layer_print_temperature'),
            new \DateTimeImmutable('2020-04-05'),
            [198, 200]
        );
        $this->addCalibration($calibration);

        $this->addCalibration(
            new Calibration(
                new CalibrationName('next_layer_print_temperature'),
                new \DateTimeImmutable('2020-04-06'),
                [204, 205]
            )
        );

        $this->getNextLayerPrintTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getNextLayerPrintTemperature()->toUnit('celsius')->shouldBe(202.0);
    }

    public function it_has_a_next_layer_print_temperature_when_no_calibrations(): void
    {
        $this->getNextLayerPrintTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getNextLayerPrintTemperature()->toUnit('celsius')->shouldBe(Temperatures::DEFAULT_MIN_PRINT_TEMP);
    }

    public function it_has_a_first_layer_bed_temperature(): void
    {
        $calibration = new Calibration(
            new CalibrationName('first_layer_bed_temperature'),
            new \DateTimeImmutable('2020-04-29'),
            [55, 57]
        );
        $this->addCalibration($calibration);

        $this->getFirstLayerBedTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getFirstLayerBedTemperature()->toUnit('celsius')->shouldBe(56.0);
    }

    public function it_has_a_first_layer_bed_temperature_when_multiple_calibrations(): void
    {
        $calibration = new Calibration(
            new CalibrationName('first_layer_bed_temperature'),
            new \DateTimeImmutable('2020-05-11'),
            [50, 52]
        );
        $this->addCalibration($calibration);

        $this->addCalibration(
            new Calibration(
                new CalibrationName('first_layer_bed_temperature'),
                new \DateTimeImmutable('2020-05-12'),
                [55, 60]
            )
        );

        $this->getFirstLayerBedTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getFirstLayerBedTemperature()->toUnit('celsius')->shouldBe(54.0);
    }

    public function it_has_a_first_layer_bed_temperature_when_no_calibrations(): void
    {
        $this->getFirstLayerBedTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getFirstLayerBedTemperature()->toUnit('celsius')->shouldBe(Temperatures::DEFAULT_MIN_BED_TEMP);
    }

    public function it_has_a_next_layer_bed_temperature(): void
    {
        $calibration = new Calibration(
            new CalibrationName('next_layer_bed_temperature'),
            new \DateTimeImmutable('2020-04-29'),
            [76, 80, 98]
        );
        $this->addCalibration($calibration);

        $this->getNextLayerBedTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getNextLayerBedTemperature()->toUnit('celsius')->shouldBe(85.0);
    }

    public function it_has_a_next_layer_bed_temperature_when_multiple_calibrations(): void
    {
        $calibration = new Calibration(
            new CalibrationName('next_layer_bed_temperature'),
            new \DateTimeImmutable('2020-05-11'),
            [76, 88, 99]
        );
        $this->addCalibration($calibration);

        $this->addCalibration(
            new Calibration(
                new CalibrationName('next_layer_bed_temperature'),
                new \DateTimeImmutable('2020-05-12'),
                [45, 67, 47]
            )
        );

        $this->getNextLayerBedTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getNextLayerBedTemperature()->toUnit('celsius')->shouldBe(70.0);
    }

    public function it_has_a_next_layer_bed_temperature_when_no_calibrations(): void
    {
        $this->getNextLayerBedTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getNextLayerBedTemperature()->toUnit('celsius')->shouldBe(Temperatures::DEFAULT_MIN_BED_TEMP);
    }
}
