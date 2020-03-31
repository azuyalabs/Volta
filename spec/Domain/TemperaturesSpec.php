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
use Volta\Domain\Exception\FilamentSpool\MaximumBedTemperatureExceededAbsoluteMaximumException;
use Volta\Domain\Exception\FilamentSpool\MaximumBedTemperatureExceededAbsoluteMinimumException;
use Volta\Domain\Exception\FilamentSpool\MaximumPrintTemperatureOutOfBoundsException;
use Volta\Domain\Exception\FilamentSpool\MinimumBedTemperatureExceededAbsoluteMaximumException;
use Volta\Domain\Exception\FilamentSpool\MinimumBedTemperatureExceededAbsoluteMinimumException;
use Volta\Domain\Exception\FilamentSpool\MinimumPrintTemperatureExceededAbsoluteMaximumException;
use Volta\Domain\Exception\FilamentSpool\MinimumPrintTemperatureExceededAbsoluteMinimumException;
use Volta\Domain\Temperatures;

class TemperaturesSpec extends ObjectBehavior
{
    private const TEMPERATURE_UNIT = 'celsius';

    public function let(): void
    {
        $this->beConstructedWith(
            new Temperature(190.0, self::TEMPERATURE_UNIT),
            new Temperature(215.0, self::TEMPERATURE_UNIT),
            new Temperature(55.0, self::TEMPERATURE_UNIT),
            new Temperature(80.0, self::TEMPERATURE_UNIT),
        );
    }

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
        $this->beConstructedWith(null, new Temperature(689, self::TEMPERATURE_UNIT));

        $this->shouldThrow(MaximumPrintTemperatureOutOfBoundsException::class)->duringInstantiation();
    }

    public function it_throws_exception_when_max_print_temperature_exceeds_absolute_min(): void
    {
        $this->beConstructedWith(null, new Temperature(41, self::TEMPERATURE_UNIT));

        $this->shouldThrow(MaximumPrintTemperatureOutOfBoundsException::class)->duringInstantiation();
    }

    public function it_has_minimum_print_temperature(): void
    {
        $this->getMinimumPrintTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getMinimumPrintTemperature()->toUnit(self::TEMPERATURE_UNIT)->shouldBe(190.0);
    }

    public function it_has_default_value_when_minimum_print_temperature_is_not_provided(): void
    {
        $this->beConstructedWith();

        $this->getMinimumPrintTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getMinimumPrintTemperature()->toUnit(self::TEMPERATURE_UNIT)->shouldBe(Temperatures::DEFAULT_MIN_PRINT_TEMP);
    }

    public function it_throws_exception_when_min_print_temperature_exceeds_absolute_max(): void
    {
        $this->beConstructedWith(new Temperature(708, self::TEMPERATURE_UNIT));

        $this->shouldThrow(MinimumPrintTemperatureExceededAbsoluteMaximumException::class)->duringInstantiation();
    }

    public function it_throws_exception_when_min_print_temperature_exceeds_absolute_min(): void
    {
        $this->beConstructedWith(new Temperature(13, self::TEMPERATURE_UNIT));

        $this->shouldThrow(MinimumPrintTemperatureExceededAbsoluteMinimumException::class)->duringInstantiation();
    }

    public function it_has_maximum_bed_temperature(): void
    {
        $this->getMaximumBedTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getMaximumBedTemperature()->toUnit(self::TEMPERATURE_UNIT)->shouldBe(80.0);
    }

    public function it_has_default_value_when_maximum_bed_temperature_is_not_provided(): void
    {
        $this->beConstructedWith();

        $this->getMaximumBedTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getMaximumBedTemperature()->toUnit(self::TEMPERATURE_UNIT)->shouldBe(Temperatures::DEFAULT_MAX_BED_TEMP);
    }

    public function it_throws_exception_when_max_bed_temperature_exceeds_absolute_max(): void
    {
        $this->beConstructedWith(null, null, null, new Temperature(209, self::TEMPERATURE_UNIT));

        $this->shouldThrow(MaximumBedTemperatureExceededAbsoluteMaximumException::class)->duringInstantiation();
    }

    public function it_throws_exception_when_max_bed_temperature_exceeds_absolute_min(): void
    {
        $this->beConstructedWith(null, null, null, new Temperature(-5, self::TEMPERATURE_UNIT));

        $this->shouldThrow(MaximumBedTemperatureExceededAbsoluteMinimumException::class)->duringInstantiation();
    }

    public function it_has_minimum_bed_temperature(): void
    {
        $this->getMinimumBedTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getMinimumBedTemperature()->toUnit(self::TEMPERATURE_UNIT)->shouldBe(55.0);
    }

    public function it_has_default_value_when_minimum_bed_temperature_is_not_provided(): void
    {
        $this->beConstructedWith();

        $this->getMinimumBedTemperature()->shouldBeAnInstanceOf(Temperature::class);
        $this->getMinimumBedTemperature()->toUnit(self::TEMPERATURE_UNIT)->shouldBe(Temperatures::DEFAULT_MIN_BED_TEMP);
    }

    public function it_throws_exception_when_min_bed_temperature_exceeds_absolute_max(): void
    {
        $this->beConstructedWith(null, null, new Temperature(203, self::TEMPERATURE_UNIT));

        $this->shouldThrow(MinimumBedTemperatureExceededAbsoluteMaximumException::class)->duringInstantiation();
    }

    public function it_throws_exception_when_min_bed_temperature_exceeds_absolute_min(): void
    {
        $this->beConstructedWith(null, null, new Temperature(-12, self::TEMPERATURE_UNIT));

        $this->shouldThrow(MinimumBedTemperatureExceededAbsoluteMinimumException::class)->duringInstantiation();
    }
}
