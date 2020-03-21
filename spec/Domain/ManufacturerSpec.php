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

use PhpSpec\ObjectBehavior;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

class ManufacturerSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(
            new ManufacturerId(),
            new ManufacturerName('ABC Plastics')
        );
    }

    public function it_has_an_id(): void
    {
        $this->getId()->shouldReturnAnInstanceOf(ManufacturerId::class);
    }

    public function it_has_a_name(): void
    {
        $this->getName()->shouldReturnAnInstanceOf(ManufacturerName::class);
    }

    public function it_can_update_name(ManufacturerName $name): void
    {
        $this->setName($name);
        $this->getName()->shouldBe($name);
    }

    public function it_tells_if_manufacturer_is_filament_supplier(): void
    {
        $this->isFilamentSupplier()->shouldBe(false);
    }

    public function it_can_set_manufacturer_is_filament_supplier(): void
    {
        $this->setIsFilamentSupplier(false);
        $this->isFilamentSupplier()->shouldBe(false);
    }

    public function it_tells_if_manufacturer_is_equipment_supplier(): void
    {
        $this->isEquipmentSupplier()->shouldBe(false);
    }

    public function it_can_set_manufacturer_is_equipment_supplier(): void
    {
        $this->setIsEquipmentSupplier(true);
        $this->isEquipmentSupplier()->shouldBe(true);
    }
}
