<?php


namespace Volta\Application\DataTransformer\FilamentSpool;

use League\Fractal\TransformerAbstract;
use Volta\Domain\FilamentSpool;

class FilamentSpoolSlicerTemplateTransformer extends TransformerAbstract
{
    public function transform(FilamentSpool $spool): array
    {
        return [
            'id'           => $spool->getId()->getValue(),
            'name'         => $spool->getName(),
            'manufacturer' => $spool->getManufacturer()->getName()->getValue(),
            'diameter'     => $spool->getDiameter()->toNativeUnit(),
            'weight'       => $spool->getWeight()->toNativeUnit(),
            'price'        => $spool->getPurchasePrice()->getAmount()
        ];
    }
}
