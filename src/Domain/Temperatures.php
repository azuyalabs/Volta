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
use Volta\Domain\Exception\FilamentSpool\MaximumBedTemperatureOutOfBoundsException;
use Volta\Domain\Exception\FilamentSpool\MaximumPrintTemperatureOutOfBoundsException;
use Volta\Domain\Exception\FilamentSpool\MinimumBedTemperatureExceededAbsoluteMaximumException;
use Volta\Domain\Exception\FilamentSpool\MinimumBedTemperatureExceededAbsoluteMinimumException;
use Volta\Domain\Exception\FilamentSpool\MinimumPrintTemperatureOutOfBoundsException;

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
    private const LOWER_BOUND_PRINT_TEMP = 150.0;

    private const UPPER_BOUND_PRINT_TEMP = 500.0;

    private const LOWER_BOUND_BED_TEMP = 0.0;

    private const UPPER_BOUND_BED_TEMP = 150.0;

    private const TEMPERATURE_UNIT = 'celsius';

    // Ideally this should be set per material type
    public const DEFAULT_MIN_PRINT_TEMP = 190.0;
    public const DEFAULT_MAX_PRINT_TEMP = 220.0;

    // Ideally this should be set per material type
    public const DEFAULT_MIN_BED_TEMP = 45.0;
    public const DEFAULT_MAX_BED_TEMP = 100.0;

    private Temperature $max_print_temperature;

    private Temperature $min_print_temperature;

    private Temperature $max_bed_temperature;

    private Temperature $min_bed_temperature;

    public function __construct(
        ?Temperature $min_print_temperature = null,
        ?Temperature $max_print_temperature = null,
        ?Temperature $min_bed_temperature = null,
        ?Temperature $max_bed_temperature = null
    ) {
        $this->min_print_temperature = $min_print_temperature ?? new Temperature(
            self::DEFAULT_MIN_PRINT_TEMP,
            self::TEMPERATURE_UNIT
        );
        $this->max_print_temperature = $max_print_temperature ?? new Temperature(
            self::DEFAULT_MAX_PRINT_TEMP,
            self::TEMPERATURE_UNIT
        );

        $this->min_bed_temperature = $min_bed_temperature ?? new Temperature(
            self::DEFAULT_MIN_BED_TEMP,
            self::TEMPERATURE_UNIT
        );
        $this->max_bed_temperature = $max_bed_temperature ?? new Temperature(
            self::DEFAULT_MAX_BED_TEMP,
            self::TEMPERATURE_UNIT
        );

        $this->validate();
    }

    private function validate(): void
    {
        if ($this->isOutOfBounds(
            $this->max_print_temperature->toUnit(self::TEMPERATURE_UNIT),
            self::LOWER_BOUND_PRINT_TEMP,
            self::UPPER_BOUND_PRINT_TEMP
        )) {
            throw new MaximumPrintTemperatureOutOfBoundsException();
        }

        if ($this->isOutOfBounds(
            $this->min_print_temperature->toUnit(self::TEMPERATURE_UNIT),
            self::LOWER_BOUND_PRINT_TEMP,
            self::UPPER_BOUND_PRINT_TEMP
        )) {
            throw new MinimumPrintTemperatureOutOfBoundsException();
        }

        if ($this->isOutOfBounds(
            $this->max_bed_temperature->toUnit(self::TEMPERATURE_UNIT),
            self::LOWER_BOUND_BED_TEMP,
            self::UPPER_BOUND_BED_TEMP
        )) {
            throw new MaximumBedTemperatureOutOfBoundsException();
        }

        // Minimum Bed Temperature
        if (self::UPPER_BOUND_BED_TEMP < $this->min_bed_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MinimumBedTemperatureExceededAbsoluteMaximumException();
        }

        if (self::LOWER_BOUND_BED_TEMP > $this->min_bed_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MinimumBedTemperatureExceededAbsoluteMinimumException();
        }
    }

    private function isOutOfBounds($value, $lowerLimit, $upperLimit): bool
    {
        return ($value < $lowerLimit || $value > $upperLimit);
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

    public function getMinimumBedTemperature(): Temperature
    {
        return $this->min_bed_temperature;
    }
}
