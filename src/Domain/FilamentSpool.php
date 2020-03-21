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

use Money\Money;
use Volta\Domain\ValueObject\FilamentSpoolId;

class FilamentSpool
{
    private $id;

    private $name;

    private $purchasePrice;

    private $manufacturer;

    public function __construct(
        FilamentSpoolId $id,
        Manufacturer $manufacturer,
        string $name,
        Money $purchasePrice
    ) {
        $this->id            = $id;
        $this->name          = $name;
        $this->purchasePrice = $purchasePrice;
        $this->manufacturer  = $manufacturer;
    }

    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }

    /**
     * @param Manufacturer $manufacturer
     * @return FilamentSpool
     */
    public function setManufacturer(Manufacturer $manufacturer): FilamentSpool
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): FilamentSpoolId
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setPurchasePrice(Money $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;
        return $this;
    }

    public function getPurchasePrice(): Money
    {
        return $this->purchasePrice;
    }
}