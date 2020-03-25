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
use OzdemirBurak\Iris\Color\Hex;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use Volta\Domain\Exception\ZeroDiameterException;
use Volta\Domain\Exception\ZeroWeightException;
use Volta\Domain\ValueObject\FilamentSpool\Color;
use Volta\Domain\ValueObject\FilamentSpool\ColorName;
use Volta\Domain\ValueObject\FilamentSpool\DisplayName;
use Volta\Domain\ValueObject\FilamentSpool\MaterialType;
use Volta\Domain\ValueObject\FilamentSpoolId;

class FilamentSpool
{
    private $id;

    private $name;

    private $purchasePrice;

    private $manufacturer;

    private $weight;

    private $diameter;

    private $material_type;

    private $color;

    public function __construct(
        FilamentSpoolId $id,
        Manufacturer $manufacturer,
        string $name
    ) {
        $this->id           = $id;
        $this->name         = $name;
        $this->manufacturer = $manufacturer;

        $this->purchasePrice = new Money(0, new Currency('USD'));
        $this->weight        = new Mass(0, 'kilogram');
        $this->diameter      = new Length(0, 'millimeter');
        $this->material_type = new MaterialType(MaterialType::MATERIALTYPE_PLA);
        $this->color         = new Color(new ColorName('Red'), new Hex('#ff0000'));
    }

    public function getDisplayName(): DisplayName
    {
        return new DisplayName(
            implode(
                ' ',
                [
                    $this->getManufacturer()->getName()->getValue(),
                    $this->getMaterialType()->getValue(),
                    $this->getColor()->getColorName()->getValue(),
                    $this->getDiameter()->toUnit('millimeter') . 'mm'
                ]
            )
        );
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

    public function getMaterialType(): MaterialType
    {
        return $this->material_type;
    }

    public function setMaterialType(MaterialType $material_type): FilamentSpool
    {
        $this->material_type = $material_type;
        return $this;
    }

    public function getColor(): Color
    {
        return $this->color;
    }

    public function setColor(Color $color): FilamentSpool
    {
        $this->color = $color;
        return $this;
    }

    public function getDiameter(): Length
    {
        return $this->diameter;
    }

    public function setDiameter(Length $diameter): FilamentSpool
    {
        if (abs($diameter->toNativeUnit() - 0) < PHP_FLOAT_EPSILON) {
            throw new ZeroDiameterException();
        }

        $this->diameter = $diameter;
        return $this;
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

    /**
     * Get the weight equivalent (gram) price for this spool.
     *
     * @return Money
     */
    public function getPricePerWeight(): Money
    {
        $weight = $this->weight->toNativeUnit();

        if (abs($weight - 0) < PHP_FLOAT_EPSILON) {
            throw new ZeroWeightException();
        }

        $pr = clone $this->getPurchasePrice();

        return $pr->divide($weight);
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
     * Get the kilogram equivalent price for this spool.
     *
     * Some manufacturers supply filament spools in quantities other than 1000 gram. This method allows for equal
     * comparison between different spools of different weight quantities.
     *
     * @return Money
     */
    public function getPricePerKilogram(): Money
    {
        $weight = $this->weight->toNativeUnit();

        if (abs($weight - 0) < PHP_FLOAT_EPSILON) {
            throw new ZeroWeightException();
        }

        $pr = clone $this->getPurchasePrice();

        return $pr->multiply(1000 / $weight);
    }
}
