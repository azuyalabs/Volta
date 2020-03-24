<?php

namespace spec\Volta\Application\DataTransformer\FilamentSpool;

use PhpSpec\ObjectBehavior;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use Tests\FilamentSpoolBuilder;
use Volta\Application\DataTransformer\FilamentSpool\FilamentSpoolSlicerTemplateTransformer;
use Volta\Domain\Manufacturer;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

class FilamentSpoolSlicerTemplateTransformerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FilamentSpoolSlicerTemplateTransformer::class);
    }

    public function it_transforms_to_slicer_template(): void
    {
        $builder = new FilamentSpoolBuilder();
        $builder->withManufacturer(new Manufacturer(new ManufacturerId(), new ManufacturerName('ABC Plastics')));
        $builder->withDiameter(new Length(1.1, 'millimeter'));
        $spool = $builder->build();

        $this->transform($spool)->shouldIterateLike(
            [
                'id'           => $spool->getId()->getValue(),
                'name'         => 'dasd',
                'manufacturer' => 'ABC Plastics',
                'diameter'     => 0.0011,
                'weight'       => 0,
                'price'        => 0
            ]
        );
    }
}
