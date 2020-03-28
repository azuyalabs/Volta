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

namespace Volta\Domain;

use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

class Manufacturer
{
    private ManufacturerId $id;

    private ManufacturerName $name;

    private bool $filamentSupplier = false;

    private bool $equipmentSupplier = false;

    public function __construct(
        ManufacturerId $id,
        ManufacturerName $name
    ) {
        $this->id   = $id;
        $this->name = $name;
    }

    public function isEquipmentSupplier(): bool
    {
        return $this->equipmentSupplier;
    }

    public function setIsEquipmentSupplier(bool $equipmentSupplier): Manufacturer
    {
        $this->equipmentSupplier = $equipmentSupplier;
        return $this;
    }

    public function isFilamentSupplier(): bool
    {
        return $this->filamentSupplier;
    }

    public function setIsFilamentSupplier(bool $filamentSupplier): Manufacturer
    {
        $this->filamentSupplier = $filamentSupplier;
        return $this;
    }

    public function getId(): ManufacturerId
    {
        return $this->id;
    }

    public function setId(ManufacturerId $id): Manufacturer
    {
        $this->id = $id;
        return $this;
    }

    public function __toString()
    {
        return $this->getName()->getValue();
    }

    public function getName(): ManufacturerName
    {
        return $this->name;
    }

    public function setName(ManufacturerName $name): Manufacturer
    {
        $this->name = $name;
        return $this;
    }
}
