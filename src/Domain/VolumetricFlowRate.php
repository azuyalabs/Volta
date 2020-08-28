<?php

declare(strict_types=1);

namespace Volta\Domain;

use PhpUnitsOfMeasure\AbstractPhysicalQuantity;
use PhpUnitsOfMeasure\Exception\DuplicateUnitNameOrAlias;
use PhpUnitsOfMeasure\Exception\NonStringUnitName;
use PhpUnitsOfMeasure\UnitOfMeasure;

class VolumetricFlowRate extends AbstractPhysicalQuantity
{
    protected static $unitDefinitions;

    protected static function initialize(): void
    {
        // Flow rate meter per second
        try {
            $unit = UnitOfMeasure::nativeUnitFactory('m^3/s');
            $unit->addAlias('m³/s');
            $unit->addAlias('cubic meter per second');
            $unit->addAlias('cubic meters per second');

            static::addUnit($unit);
        } catch (DuplicateUnitNameOrAlias | NonStringUnitName $e) {
            // TODO: Do something here with this exception
        }

        // Flow rate millimeter per second
        try {
            $unit = UnitOfMeasure::linearUnitFactory('mm^3/s', 1e-9);
            $unit->addAlias('mm³/s');
            $unit->addAlias('cubic millimeter per second');
            $unit->addAlias('cubic millimeters per second');

            static::addUnit($unit);
        } catch (DuplicateUnitNameOrAlias | NonStringUnitName $e) {
            // TODO: Do something here with this exception
        }
    }
}
