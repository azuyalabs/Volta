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

namespace spec\Volta\Domain;

use PhpSpec\ObjectBehavior;
use PhpUnitsOfMeasure\PhysicalQuantity\Temperature;
use Volta\Domain\Exception\FilamentSpool\MaximumPrintTemperatureExceededAbsoluteMaximumException;
use Volta\Domain\Temperatures;

class TemperaturesSpec extends ObjectBehavior
{
    private const TEMPERATURE_UNIT = 'celsius';

    public function let(): void
    {
        $this->beConstructedWith(
            new Temperature(215.0, self::TEMPERATURE_UNIT),
        );
    }

//        MaximumPrintTemperature
    //MinimumPrintTemperature
    //MaximumBedTemperature
    //MinimumBedTemperature

    public function it_has_maximum_print_temperature(): void
    {
        $this->getMaximumPrintTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getMaximumPrintTemperature()->toUnit(self::TEMPERATURE_UNIT)->shouldBe(215.0);
    }

    public function it_has_default_value_when_maximum_print_temperature_is_not_provided(): void
    {
        $this->beConstructedWith();

        $this->getMaximumPrintTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getMaximumPrintTemperature()->toUnit(self::TEMPERATURE_UNIT)->shouldBe(Temperatures::DEFAULT_MAX_PRINT_TEMP);
    }

    public function it_throws_exception_when_max_print_temperature_exceeds_absolute_max(): void
    {
        $this->beConstructedWith(new Temperature(689, self::TEMPERATURE_UNIT));

        $this->shouldThrow(MaximumPrintTemperatureExceededAbsoluteMaximumException::class)->duringInstantiation();
    }
}
