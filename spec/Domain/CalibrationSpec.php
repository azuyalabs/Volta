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
use Volta\Domain\Calibration;
use Volta\Domain\Exception\EmptyMeasurementsException;
use Volta\Domain\ValueObject\CalibrationName;

class CalibrationSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(
            new CalibrationName('diameter'),
            new \DateTimeImmutable('2020-03-16'),
            [50.5, 45.3, 50, 51.6],
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Calibration::class);
    }

    public function it_has_a_name(): void
    {
        $this->getName()->shouldBeAnInstanceOf(CalibrationName::class);
        $this->getName()->shouldBeLike(new CalibrationName('diameter'));
    }

    public function it_has_a_timestamp(): void
    {
        $this->getTimestamp()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this->getTimestamp()->shouldBeLike(new \DateTimeImmutable('2020-03-16'));
    }

    public function it_has_measurements(): void
    {
        $this->getMeasurements()->shouldBeArray();
        $this->getMeasurements()->shouldBe([50.5, 45.3, 50, 51.6]);
    }

    public function it_throws_an_error_when_measurements_are_empty(): void
    {
        $this->beConstructedWith(
            new CalibrationName('length'),
            new \DateTimeImmutable('2018-02-16'),
            [],
        );
        $this->shouldThrow(EmptyMeasurementsException::class);
    }

    public function it_has_a_maximum(): void
    {
        $this->getMaximum()->shouldBeNumeric();
        $this->getMaximum()->shouldBe(51.6);
    }

    public function it_has_a_minimum(): void
    {
        $this->getMinimum()->shouldBeNumeric();
        $this->getMinimum()->shouldBe(45.3);
    }

    public function it_has_an_average(): void
    {
        $this->getAverage()->shouldBeNumeric();
        $this->getAverage()->shouldBe(49.35);
    }
}
