<?php


namespace Volta\Application\DataTransformer\FilamentSpool;

use League\Fractal\TransformerAbstract;
use Volta\Domain\FilamentSpool;

class SlicerTemplateTransformer extends TransformerAbstract
{
    public function transform(FilamentSpool $spool): array
    {
        return [
            'id'           => $spool->getId()->getValue(),
            'name'         => $spool->getName(),
            'manufacturer' => $spool->getManufacturer()->getName()->getValue(),
            'diameter'     => $spool->getDiameter()->toUnit('millimeters'),
            'weight'       => $spool->getWeight()->toUnit('grams'),
            'price'        => $spool->getPurchasePrice()->getAmount()
        ];
    }
}
