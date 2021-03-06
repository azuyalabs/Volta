<?php

declare(strict_types=1);

namespace Tests;

use Money\Currency;
use Money\Money;
use OzdemirBurak\Iris\Color\Hex;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use PhpUnitsOfMeasure\PhysicalQuantity\Temperature;
use Volta\Domain\Calibration;
use Volta\Domain\FilamentSpool;
use Volta\Domain\Manufacturer;
use Volta\Domain\Temperatures;
use Volta\Domain\ValueObject\FilamentSpool\Color;
use Volta\Domain\ValueObject\FilamentSpool\ColorName;
use Volta\Domain\ValueObject\FilamentSpool\FilamentSpoolId;
use Volta\Domain\ValueObject\FilamentSpool\MaterialType;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

class FilamentSpoolBuilder
{
    private FilamentSpoolId $id;

    private Length $diameter;

    private Manufacturer $manufacturer;

    private Mass $weight;

    private Money $purchase_price;

    private string $name;

    private MaterialType $material;

    private Color $color;

    private float $density;

    private array $calibrations;

    private Temperatures $print_temperatures;

    private Temperatures $bed_temperatures;

    public function __construct()
    {
        $this->id           = new FilamentSpoolId();
        $this->manufacturer = new Manufacturer(
            new ManufacturerId(),
            new ManufacturerName('XYZ Filaments')
        );
        $this->name               = 'PET Plus';
        $this->diameter           = new Length(0.0, 'millimeters');
        $this->weight             = new Mass(0.0, 'grams');
        $this->purchase_price     = new Money(0, new Currency('USD'));
        $this->material           = new MaterialType(MaterialType::MATERIALTYPE_PET);
        $this->color              = new Color(new ColorName('Green'), new Hex('#00ff00'));
        $this->density            = 1;
        $this->print_temperatures = new Temperatures(new Temperature(210, 'celsius'), new Temperature(250, 'celsius'));
        $this->bed_temperatures   = new Temperatures(null, null, new Temperature(75, 'celsius'), new Temperature(90, 'celsius'));
    }

    public function withWeight(Mass $weight): void
    {
        $this->weight = $weight;
    }

    public function withPurchasePrice(Money $price): void
    {
        $this->purchase_price = $price;
    }

    public function withManufacturer(Manufacturer $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    public function withId(FilamentSpoolId $id): void
    {
        $this->id = $id;
    }

    public function withDiameter(Length $diameter): void
    {
        $this->diameter = $diameter;
    }

    public function withName(string $name): void
    {
        $this->name = $name;
    }

    public function withMaterialType(MaterialType $type): void
    {
        $this->material = $type;
    }

    public function withColor(Color $color): void
    {
        $this->color = $color;
    }

    public function withDensity(float $density): void
    {
        $this->density = $density;
    }

    public function withCalibration(Calibration $calibration): void
    {
        $this->calibrations[] = $calibration;
    }

    public function build(): FilamentSpool
    {
        $spool = new FilamentSpool(
            $this->id,
            $this->manufacturer,
            $this->name,
            $this->color,
            $this->diameter
        );
        $spool->setWeight($this->weight);
        $spool->setPurchasePrice($this->purchase_price);
        $spool->setMaterialType($this->material);
        $spool->setDensity($this->density);
        foreach ($this->calibrations as $calibration) {
            $spool->addCalibration($calibration);
        }
        $spool->setPrintTemperatures($this->print_temperatures);
        $spool->setBedTemperatures($this->bed_temperatures);

        return $spool;
    }
}
