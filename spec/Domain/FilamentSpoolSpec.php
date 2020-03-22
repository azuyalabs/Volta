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
use PhpSpec\ObjectBehavior;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use Volta\Domain\Exception\ZeroDiameterException;
use Volta\Domain\Exception\ZeroWeightException;
use Volta\Domain\FilamentSpool;
use Volta\Domain\Manufacturer;
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
}
