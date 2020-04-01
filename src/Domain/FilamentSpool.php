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
use Volta\Domain\ValueObject\FilamentSpool\MaximumFanSpeed;
use Volta\Domain\ValueObject\FilamentSpool\MinimumFanSpeed;
use Volta\Domain\ValueObject\FilamentSpoolId;

class FilamentSpool
{
    protected array $min_fan_speed_definition = [
        MaterialType::MATERIALTYPE_PLA  => 100,
        'Woodfill'                      => 100,
        MaterialType::MATERIALTYPE_ABS  => 15,
        MaterialType::MATERIALTYPE_PETG => 30
    ];

    protected array $max_fan_speed_definition = [
        MaterialType::MATERIALTYPE_PLA  => 100,
        'Woodfill'                      => 100,
        MaterialType::MATERIALTYPE_ABS  => 30,
        MaterialType::MATERIALTYPE_PETG => 50
    ];

    private FilamentSpoolId $id;
    private string $name;
    private Money $purchasePrice;
    private Manufacturer $manufacturer;
    private Mass $weight;
    private Length $diameter;
    private Length $diameter_tolerance;
    private MaterialType $material_type;
    private Color $color;
    private ?Color $alternativeColor = null;
    private Temperatures $temperatures;
    private float $density = 0.0;

    public function __construct(
        FilamentSpoolId $id,
        Manufacturer $manufacturer,
        string $name
    ) {
        $this->id           = $id;
        $this->name         = $name;
        $this->manufacturer = $manufacturer;

        $this->purchasePrice      = new Money(0, new Currency('USD'));
        $this->weight             = new Mass(0, 'kilogram');
        $this->diameter           = new Length(0, 'millimeter');
        $this->diameter_tolerance = new Length(0.05, 'millimeter');
        $this->material_type      = new MaterialType(MaterialType::MATERIALTYPE_PLA);
        $this->color              = new Color(new ColorName('Red'), new Hex('#ff0000'));
        $this->temperatures       = new Temperatures();
    }

    public function getTemperatures(): Temperatures
    {
        return $this->temperatures;
    }

    public function setTemperatures(Temperatures $temperatures): FilamentSpool
    {
        $this->temperatures = $temperatures;

        return $this;
    }

    public function getMinimumFanSpeed(): MinimumFanSpeed
    {
        $value = $this->min_fan_speed_definition[$this->material_type->getValue()];

        return new MinimumFanSpeed($value);
    }

    public function getMaximumFanSpeed(): MaximumFanSpeed
    {
        $value = $this->max_fan_speed_definition[$this->material_type->getValue()];

        return new MaximumFanSpeed($value);
    }

    public function getDisplayName(): DisplayName
    {
        $colorName = $this->getAlternativeColor() instanceof Color ?
                $this->getAlternativeColor()->getColorName()->getValue() :
                $this->getColor()->getColorName()->getValue();

        return new DisplayName(
            implode(
                ' ',
                [
                        $this->getManufacturer()->getName()->getValue(),
                        $this->getMaterialType()->getValue(),
                        $colorName,
                        $this->getDiameter()->toUnit('millimeter').'mm',
                    ]
            )
        );
    }

    public function getAlternativeColor(): ?Color
    {
        return $this->alternativeColor;
    }

    public function setAlternativeColor(Color $color): FilamentSpool
    {
        $this->alternativeColor = $color;

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

    public function getDiameterTolerance(): Length
    {
        return $this->diameter_tolerance;
    }

    public function setDiameterTolerance(Length $diameter): FilamentSpool
    {
        $this->diameter_tolerance = $diameter;

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

        return $pr->multiply(1 / $weight);
    }

    public function getDensity(): float
    {
        return $this->density;
    }

    public function setDensity(float $density): FilamentSpool
    {
        if (abs($density - 0) < PHP_FLOAT_EPSILON) {
            throw new ZeroDensityException();
        }

        $this->density = $density;

        return $this;
}
}
