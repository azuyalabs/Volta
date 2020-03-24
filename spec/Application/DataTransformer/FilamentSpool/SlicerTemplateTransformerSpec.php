<?php

namespace spec\Volta\Application\DataTransformer\FilamentSpool;

use PhpSpec\ObjectBehavior;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use Tests\FilamentSpoolBuilder;
use Volta\Application\DataTransformer\FilamentSpool\SlicerTemplateTransformer;
use Volta\Domain\Manufacturer;
use Volta\Domain\ValueObject\FilamentSpool\MaterialType;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerId;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

class SlicerTemplateTransformerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SlicerTemplateTransformer::class);
    }

    public function it_transforms_to_slicer_template(): void
    {
        $builder = new FilamentSpoolBuilder();
        $builder->withManufacturer(new Manufacturer(new ManufacturerId(), new ManufacturerName('ABC Plastics')));
        $builder->withDiameter(new Length(1.75, 'millimeter'));
        $builder->withWeight(new Mass(900, 'grams'));
        $builder->withMaterialType(new MaterialType(MaterialType::MATERIALTYPE_PETG));
        $spool = $builder->build();

        $this->transform($spool)->shouldIterateLike(
            [
                'id'           => $spool->getId()->getValue(),
                'name'         => 'Glowy Pink',
                'manufacturer' => 'ABC Plastics',
                'diameter'     => 1.75,
                'weight'       => 900,
                'price'        => 0,
                'material'     => 'PETG'
            ]
        );
    }
}
