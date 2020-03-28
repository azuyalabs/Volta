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
use Volta\Domain\Exception\FilamentSpool\MaximumPrintTemperatureExceededAbsoluteMaximumException;
use Volta\Domain\Exception\FilamentSpool\MaximumPrintTemperatureExceededAbsoluteMinimumException;
use Volta\Domain\Exception\FilamentSpool\MinimumPrintTemperatureExceededAbsoluteMaximumException;
use Volta\Domain\Exception\FilamentSpool\MinimumPrintTemperatureExceededAbsoluteMinimumException;

class Temperatures
{
    private const UPPER_MAX_PRINT_TEMP = 500.0;

    private const LOWER_MIN_PRINT_TEMP = 150.0;

    private const UPPER_MAX_BED_TEMP = 150.0;

    private const LOWER_MIN_BED_TEMP = 0.0;

    private const TEMPERATURE_UNIT = 'celsius';

    // Ideally this should be set per material type
    public const DEFAULT_MIN_PRINT_TEMP = 190.0;
    public const DEFAULT_MAX_PRINT_TEMP = 220.0;

    private Temperature $max_print_temperature;

    private Temperature $min_print_temperature;

    public function __construct(
        ?Temperature $min_print_temperature = null,
        ?Temperature $max_print_temperature = null
    ) {
        $this->max_print_temperature = $max_print_temperature ?? new Temperature(self::DEFAULT_MAX_PRINT_TEMP, self::TEMPERATURE_UNIT);
        $this->min_print_temperature = $min_print_temperature ?? new Temperature(self::DEFAULT_MIN_PRINT_TEMP, self::TEMPERATURE_UNIT);

        $this->validate();
    }

    private function validate(): void
    {
        // Maximum Print Temperature
        if (self::UPPER_MAX_PRINT_TEMP < $this->max_print_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MaximumPrintTemperatureExceededAbsoluteMaximumException();
        }

        if (self::LOWER_MIN_PRINT_TEMP > $this->max_print_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MaximumPrintTemperatureExceededAbsoluteMinimumException();
        }

        // Minimum Print Temperature
        if (self::UPPER_MAX_PRINT_TEMP < $this->min_print_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MinimumPrintTemperatureExceededAbsoluteMaximumException();
        }

        if (self::LOWER_MIN_PRINT_TEMP > $this->min_print_temperature->toUnit(self::TEMPERATURE_UNIT)) {
            throw new MinimumPrintTemperatureExceededAbsoluteMinimumException();
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
}
