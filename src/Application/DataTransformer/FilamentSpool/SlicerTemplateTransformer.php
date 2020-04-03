<?php

declare(strict_types=1);


namespace Volta\Application\DataTransformer\FilamentSpool;

use League\Fractal\TransformerAbstract;
use Volta\Domain\FilamentSpool;

class SlicerTemplateTransformer extends TransformerAbstract
{
    public function transform(FilamentSpool $spool): array
    {
        return [
            'id'                => $spool->getId()->getValue(),
            'name'              => $spool->getName(),
            'manufacturer'      => $spool->getManufacturer()->getName()->getValue(),
            'diameter'          => $spool->getDiameter()->toUnit('millimeters'),
            'weight'            => $spool->getWeight()->toUnit('grams'),
            'material'          => $spool->getMaterialType()->getValue(),
            'density'           => $spool->getDensity(),
            'price'             => $spool->getPurchasePrice()->getAmount(),
            'color'             => $spool->getColor()->getColorName()->getValue(),
            'color_code'        => (string)$spool->getColor()->getColorCode(),
            'display_name'      => $spool->getDisplayName()->getValue(),
            'min_fan_speed'     => $spool->getMinimumFanSpeed()->getValue(),
            'max_fan_speed'     => $spool->getMaximumFanSpeed()->getValue(),
            'min_print_speed'   => $spool->getMinimumPrintSpeed()->getValue(),
        ];
    }
}
