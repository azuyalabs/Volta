<?php


namespace Volta\Domain;

use PhpUnitsOfMeasure\PhysicalQuantity\Velocity as BaseVelocity;
use PhpUnitsOfMeasure\UnitOfMeasure;

class Velocity extends BaseVelocity
{
    protected static function initialize(): void
    {
        parent::initialize();

        $mm_second = UnitOfMeasure::linearUnitFactory('mm/s', 0.001);
        $mm_second->addAlias('millimeter per second');
        BaseVelocity::addUnit($mm_second);
    }
}
