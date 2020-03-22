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

use Money\Currency;
use Money\Money;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use Volta\Domain\ValueObject\FilamentSpoolId;

class FilamentSpool
{
    private $id;

    private $name;

    private $purchasePrice;

    private $manufacturer;

    private $weight;

    public function __construct(
        FilamentSpoolId $id,
        Manufacturer $manufacturer,
        string $name
    ) {
        $this->id            = $id;
        $this->name          = $name;
        $this->manufacturer  = $manufacturer;

        $this->purchasePrice = new Money(0, new Currency('USD'));
        $this->weight        = new Mass(0, 'kilogram');
    }

    public function getWeight(): Mass
    {
        return $this->weight;
    }

    public function setWeight(Mass $weight): FilamentSpool
    {
        $this->weight = $weight;
        return $this;
    }

    public function getManufacturer(): Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(Manufacturer $manufacturer): FilamentSpool
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getId(): FilamentSpoolId
    {
        return $this->id;
    }

    public function getPurchasePrice(): Money
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(Money $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;
        return $this;
    }

    /**
     * Get the weight equivalent (gram) price for this spool.
     *
     * @return Money
     */
    public function getPricePerWeight(): Money
    {
        $weight = $this->weight->toNativeUnit();

        if (abs($weight-0) < PHP_FLOAT_EPSILON) {
            throw new \UnexpectedValueException('Weight can not be zero.');
        }

        $pr = clone $this->getPurchasePrice();

        return $pr->divide($weight);
    }
}
