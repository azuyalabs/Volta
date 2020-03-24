<?php
declare(strict_types=1);

namespace Tests;

use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use Volta\Domain\FilamentSpool;
use Volta\Domain\Manufacturer;
use Volta\Domain\ValueObject\FilamentSpoolId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

class FilamentSpoolBuilder
{
    private $id;

    private $diameter;

    private $manufacturer;

    private $weight;

    private $name;

    public function __construct()
    {
        $this->id           = new FilamentSpoolId();
        $this->manufacturer = new Manufacturer(new ManufacturerId(), new ManufacturerName('XYZ Filaments'));
        $this->name         = 'Glowy Pink';
        $this->diameter     = new Length(0.0, 'millimeters');
        $this->weight       = new Mass(0.0, 'grams');
    }

    public function withWeight(Mass $weight): void
    {
        $this->weight = $weight;
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

    public function build(): FilamentSpool
    {
        $spool = new FilamentSpool(
            $this->id,
            $this->manufacturer,
            $this->name
        );
        $spool->setDiameter($this->diameter);
        $spool->setWeight($this->weight);

        return $spool;
    }
}
