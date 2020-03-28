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

class Temperatures
{
    private const UPPER_MAX_PRINT_TEMP = 500.0;

    private const LOWER_MIN_PRINT_TEMP = 150.0;

    private const UPPER_MAX_BED_TEMP = 150.0;

    private const LOWER_MIN_BED_TEMP = 0.0;

    // Ideally this should be set per material type
    public const DEFAULT_MAX_PRINT_TEMP = 200.0;

    private Temperature $max_print_temperature;

    public function __construct(?Temperature $max_print_temperature = null)
    {
        $this->max_print_temperature = $max_print_temperature ?? new Temperature(self::DEFAULT_MAX_PRINT_TEMP, 'celsius');

        $this->validate();
    }

    public function getMaximumPrintTemperature(): Temperature
    {
        return $this->max_print_temperature;
    }

    private function validate(): void
    {
        if (self::UPPER_MAX_PRINT_TEMP < $this->max_print_temperature->toNativeUnit()) {
            throw new MaximumPrintTemperatureExceededAbsoluteMaximumException();
        }
    }
}
