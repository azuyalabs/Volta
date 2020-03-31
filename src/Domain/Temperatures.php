<?php
/**
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2019. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

declare(strict_types=1);

namespace Volta\Domain;

use PhpUnitsOfMeasure\PhysicalQuantity\Temperature;
use Volta\Domain\Exception\FilamentSpool\MaximumBedTemperatureExceededAbsoluteMaximumException;
use Volta\Domain\Exception\FilamentSpool\MaximumBedTemperatureExceededAbsoluteMinimumException;
use Volta\Domain\Exception\FilamentSpool\MaximumPrintTemperatureExceededAbsoluteMaximumException;
use Volta\Domain\Exception\FilamentSpool\MaximumPrintTemperatureExceededAbsoluteMinimumException;
use Volta\Domain\Exception\FilamentSpool\MinimumPrintTemperatureExceededAbsoluteMaximumException;
use Volta\Domain\Exception\FilamentSpool\MinimumPrintTemperatureExceededAbsoluteMinimumException;

/**
 * Class Temperatures
 *
 * The Temperatures class holds the manufacturer recommended temperature ranges considered ideal for the filament.
 * In case these are unknown, the temperatures are defaulted to a defacto standard.
 *
 * @package Volta\Domain
 */
class Temperatures
{
    private const UPPER_BOUND_PRINT_TEMP = 500.0;

    private const LOWER_BOUND_PRINT_TEMP = 150.0;

    private const UPPER_BOUND_BED_TEMP = 150.0;

    private const LOWER_BOUND_BED_TEMP = 0.0;

    private const TEMPERATURE_UNIT = 'celsius';

    // Ideally this should be set per material type
    public const DEFAULT_MIN_PRINT_TEMP = 190.0;
    public const DEFAULT_MAX_PRINT_TEMP = 220.0;

    // Ideally this should be set per material type
    public const DEFAULT_MIN_BED_TEMP = 50.0;
    public const DEFAULT_MAX_BED_TEMP = 100.0;

    private Temperature $max_print_temperature;

    private Temperature $min_print_temperature;

    private Temperature $max_bed_temperature;

    public function __construct(
        ?Temperature $min_print_temperature = null,
        ?Temperature $max_print_temperature = null,
        ?Temperature $max_bed_temperature = null
    ) {
        $this->max_print_temperature = $max_print_temperature ?? new Temperature(self::DEFAULT_MAX_PRINT_TEMP, self::TEMPERATURE_UNIT);
        $this->min_print_temperature = $min_print_temperature ?? new Temperature(self::DEFAULT_MIN_PRINT_TEMP, self::TEMPERATURE_UNIT);
        $this->max_bed_temperature   = $max_bed_temperature   ?? new Temperature(self::DEFAULT_MAX_BED_TEMP, self::TEMPERATURE_UNIT);

        $this->validate();
    }

    private function validate(): void
    {
        // Maximum Print Temperature
        if (self::UPPER_BOUND_PRINT_TEMP < $this->max_print_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MaximumPrintTemperatureExceededAbsoluteMaximumException();
        }

        if (self::LOWER_BOUND_PRINT_TEMP > $this->max_print_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MaximumPrintTemperatureExceededAbsoluteMinimumException();
        }

        // Minimum Print Temperature
        if (self::UPPER_BOUND_PRINT_TEMP < $this->min_print_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MinimumPrintTemperatureExceededAbsoluteMaximumException();
        }

        if (self::LOWER_BOUND_PRINT_TEMP > $this->min_print_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MinimumPrintTemperatureExceededAbsoluteMinimumException();
        }

        // Maximum Bed Temperature
        if (self::UPPER_BOUND_BED_TEMP < $this->max_bed_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MaximumBedTemperatureExceededAbsoluteMaximumException();
        }

        if (self::LOWER_BOUND_BED_TEMP > $this->max_bed_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MaximumBedTemperatureExceededAbsoluteMinimumException();
        }
    }

    public function getMaximumPrintTemperature(): Temperature
    {
        return $this->max_print_temperature;
    }

    public function getMinimumPrintTemperature(): Temperature
    {
        return $this->min_print_temperature;
    }

    public function getMaximumBedTemperature(): Temperature
    {
        return $this->max_bed_temperature;
    }
}
