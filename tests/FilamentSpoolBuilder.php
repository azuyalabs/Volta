<?php
declare(strict_types=1);

namespace Tests;

use PhpUnitsOfMeasure\PhysicalQuantity\Length;
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

    public function __construct()
    {
        $this->id           = new FilamentSpoolId();
        $this->manufacturer = new Manufacturer(new ManufacturerId(), new ManufacturerName('XYZ Filaments'));
        $this->diameter     = new Length(0.0, 'millimeters');
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

    public function build(): FilamentSpool
    {
        $spool = new FilamentSpool(
            $this->id,
            $this->manufacturer,
            'dasd'
        );
        $spool->setDiameter($this->diameter);

        return $spool;
    }
}
