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
use Volta\Domain\Exception\ZeroDensityException;
use Volta\Domain\Exception\ZeroDiameterException;
use Volta\Domain\Exception\ZeroWeightException;
use Volta\Domain\FilamentSpool;
use Volta\Domain\Manufacturer;
use Volta\Domain\Temperatures;
use Volta\Domain\ValueObject\FilamentSpool\Color;
use Volta\Domain\ValueObject\FilamentSpool\ColorName;
use Volta\Domain\ValueObject\FilamentSpool\DisplayName;
use Volta\Domain\ValueObject\FilamentSpool\MaterialType;
use Volta\Domain\ValueObject\FilamentSpool\MaximumFanSpeed;
use Volta\Domain\ValueObject\FilamentSpool\MinimumFanSpeed;
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
            'Midnight Blue'
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
        $this->getName()->shouldBe('Midnight Blue');
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

    public function it_can_update_weight(Mass $weight): void
    {
        $this->setWeight($weight);
        $this->getWeight()->shouldBe($weight);
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

    public function it_throws_exception_price_per_weight_on_weight_is_zero(): void
    {
        $weight = new Mass(0, 'gram');

        $this->setWeight($weight);
        $this->shouldThrow(ZeroWeightException::class)->duringGetPricePerWeight();
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

    public function it_throws_exception_price_per_kilogram_on_weight_is_zero(): void
    {
        $weight = new Mass(0, 'gram');

        $this->setWeight($weight);
        $this->shouldThrow(ZeroWeightException::class)->duringGetPricePerKilogram();
    }

    public function it_has_a_diameter(): void
    {
        $this->getDiameter()->shouldReturnAnInstanceOf(Length::class);
    }

    public function it_can_update_diameter(): void
    {
        $diameter = new Length(0.1, 'meters');

        $this->setDiameter($diameter);
        $this->getDiameter()->shouldBe($diameter);
    }

    public function it_throws_exception_setting_diameter_to_zero(): void
    {
        $this->shouldThrow(ZeroDiameterException::class)
            ->duringSetDiameter(new Length(0, 'meters'));
    }

    public function it_has_a_diameter_tolerance(): void
    {
        $this->getDiameterTolerance()->shouldReturnAnInstanceOf(Length::class);
    }

    public function it_can_update_diameter_tolerance(): void
    {
        $diameter = new Length(0.03, 'millimeters');

        $this->setDiameterTolerance($diameter);
        $this->getDiameterTolerance()->shouldBe($diameter);
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

    public function it_has_not_an_alternative_color_by_default(): void
    {
        $this->getAlternativeColor()->shouldBeNull();
    }

    public function it_can_update_alternative_color(): void
    {
        $color = new Color(new ColorName('Ruby Red'), new Hex('#9b111e'));

        $this->setAlternativeColor($color);
        $this->getAlternativeColor()->shouldBe($color);
    }

    public function it_has_a_display_name(): void
    {
        $this->getDisplayName()->shouldReturnAnInstanceOf(DisplayName::class);
        $this->getDisplayName()->getValue()->shouldBe('ABC Plastics PLA Red 1.75mm');
    }

    public function it_has_alternative_color_in_display_name_if_alternative_color_is_set(): void
    {
        $this->setAlternativeColor(new Color(new ColorName('Himalaya'), new Hex('#665D1E')));

        $this->getDisplayName()->shouldReturnAnInstanceOf(DisplayName::class);
        $this->getDisplayName()->getValue()->shouldBe('ABC Plastics PLA Himalaya 1.75mm');
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

    public function it_has_temperatures(): void
    {
        $this->getTemperatures()->shouldReturnAnInstanceOf(Temperatures::class);
        $this->getTemperatures()->getMinimumPrintTemperature()->toUnit('celsius')->shouldBe(Temperatures::DEFAULT_MIN_PRINT_TEMP);
        $this->getTemperatures()->getMaximumPrintTemperature()->toUnit('celsius')->shouldBe(Temperatures::DEFAULT_MAX_PRINT_TEMP);
    }

    public function it_can_update_temperatures(): void
    {
        $this->setTemperatures(
            new Temperatures(
                new Temperature(167, 'celsius'),
                new Temperature(235, 'celsius')
            )
        );
        $this->getTemperatures()->getMinimumPrintTemperature()->toUnit('celsius')->shouldBe(167.0);
        $this->getTemperatures()->getMaximumPrintTemperature()->toUnit('celsius')->shouldBe(235.0);
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
}
