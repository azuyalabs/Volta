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
use Volta\Domain\Exception\ZeroDensityException;
use Volta\Domain\Exception\ZeroDiameterException;
use Volta\Domain\Exception\ZeroWeightException;
use Volta\Domain\ValueObject\FilamentSpool\Color;
use Volta\Domain\ValueObject\FilamentSpool\ColorName;
use Volta\Domain\ValueObject\FilamentSpool\DisplayName;
use Volta\Domain\ValueObject\FilamentSpool\MaterialType;
use Volta\Domain\ValueObject\FilamentSpool\MaximumFanSpeed;
use Volta\Domain\ValueObject\FilamentSpool\MinimumFanSpeed;
use Volta\Domain\ValueObject\FilamentSpool\MinimumPrintSpeed;
use Volta\Domain\ValueObject\FilamentSpoolId;

class FilamentSpool
{
    protected array $min_fan_speed_definition = [
            MaterialType::MATERIALTYPE_PLA  => 100,
            'Woodfill'                      => 100,
            MaterialType::MATERIALTYPE_ABS  => 15,
            MaterialType::MATERIALTYPE_PETG => 30,
    ];

    protected array $max_fan_speed_definition = [
            MaterialType::MATERIALTYPE_PLA  => 100,
            'Woodfill'                      => 100,
            MaterialType::MATERIALTYPE_ABS  => 30,
            MaterialType::MATERIALTYPE_PETG => 50,
    ];

    protected array $min_print_speed_definition = [
            MaterialType::MATERIALTYPE_PLA  => 15,
            'Woodfill'                      => 15,
            MaterialType::MATERIALTYPE_ABS  => 5,
            MaterialType::MATERIALTYPE_PETG => 15,
    ];

    private FilamentSpoolId $id;
    private string $name;
    private Money $purchasePrice;
    private Manufacturer $manufacturer;
    private Mass $weight;
    private Length $diameter;
    private Length $diameter_tolerance;
    private Length $ovality_tolerance;
    private MaterialType $material_type;
    private Color $color;
    private Temperatures $temperatures;
    private float $density      = 1.0;
    private array $calibrations = [];

    public function __construct(
        FilamentSpoolId $id,
        Manufacturer $manufacturer,
        string $name
    ) {
        $this->id           = $id;
        $this->name         = $name;
        $this->manufacturer = $manufacturer;

        $this->purchasePrice      = new Money(0, new Currency('USD'));
        $this->weight             = new Mass(1, 'kilogram');
        $this->diameter           = new Length(1.75, 'millimeter');
        $this->diameter_tolerance = new Length(0.05, 'millimeter');
        $this->ovality_tolerance  = new Length(0.05, 'millimeter');
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

    public function getMinimumPrintSpeed(): MinimumPrintSpeed
    {
        $value = $this->min_print_speed_definition[$this->material_type->getValue()];

        return new MinimumPrintSpeed($value);
    }

    public function getDisplayName(): DisplayName
    {
        return new DisplayName(
            implode(
                ' ',
                [
                                $this->getManufacturer()->getName()->getValue(),
                                $this->getName(),
                                $this->getColor()->getColorName()->getValue(),
                                $this->getDiameter()->toUnit('millimeter').'mm',
                        ]
            )
        );
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
        if ($this->isZero($diameter->toNativeUnit())) {
            throw new ZeroDiameterException();
        }

        $this->diameter = $diameter;

        return $this;
    }

    private function isZero(float $value): bool
    {
        return abs($value - 0) < PHP_FLOAT_EPSILON;
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
        if ($this->isZero($weight->toNativeUnit())) {
            throw new ZeroWeightException();
        }

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

        $pr = clone $this->getPurchasePrice();

        return $pr->multiply(1 / $weight);
    }

    public function getDensity(): float
    {
        return $this->density;
    }

    public function setDensity(float $density): FilamentSpool
    {
        if ($this->isZero($density)) {
            throw new ZeroDensityException();
        }

        $this->density = $density;

        return $this;
    }

    public function getOvalityTolerance(): Length
    {
        return $this->ovality_tolerance;
    }

    public function setOvalityTolerance(Length $diameter): FilamentSpool
    {
        $this->ovality_tolerance = $diameter;

        return $this;
    }

    public function addCalibration(Calibration $calibration): void
    {
        $this->calibrations[] = $calibration;
    }

    public function getCalibrations(): array
    {
        return $this->calibrations;
    }

    /**
     * Get the print temperature for the first layer.
     *
     * The print temperature for the first layer is based on any recorded calibrations. If no calibrations
     * are present, the manufacturer's recommended minimum print temperature is used alternatively.
     * Should there be no manufacturer's recommended temperatures, then the de facto standard for the
     * material is used.
     */
    public function getFirstLayerPrintTemperature()
    {
        $r = array_filter($this->calibrations, static function ($v) {
            return $v->getName()->getValue() === 'first_layer_print_temperature';
        });

        // Default to the manufacturer's recommended minimum temperature
        $temp = $this->getTemperatures()->getMinimumPrintTemperature()->toUnit('celsius');

        if (0 < count($r)) {
            $sum = array_reduce($r, static function ($carry, $item) {
                $count  = (is_array($carry)) ? $carry[0] : 0;
                $values = (is_array($carry)) ? $carry[1] : 0;

                return [$count + count($item->getMeasurements()), $values + array_sum($item->getMeasurements())];
            });
            $temp = round($sum[1] / $sum[0]);
        }

        return $temp;
    }

    /**
     * Get the print temperature for the next layer.
     *
     * The print temperature for the next layer is based on any recorded calibrations. If no calibrations
     * are present, the manufacturer's recommended minimum print temperature is used alternatively.
     * Should there be no manufacturer's recommended temperatures, then the de facto standard for the
     * material is used.
     */
    public function getNextLayerPrintTemperature()
    {
        $r = array_filter($this->calibrations, static function ($v) {
            return $v->getName()->getValue() === 'next_layer_print_temperature';
        });

        // Default to the manufacturer's recommended minimum temperature
        $temp = $this->getTemperatures()->getMinimumPrintTemperature()->toUnit('celsius');

        if (0 < count($r)) {
            $sum = array_reduce($r, static function ($carry, $item) {
                $count  = (is_array($carry)) ? $carry[0] : 0;
                $values = (is_array($carry)) ? $carry[1] : 0;

                return [$count + count($item->getMeasurements()), $values + array_sum($item->getMeasurements())];
            });
            $temp = round($sum[1] / $sum[0]);
        }

        return $temp;
    }
}
