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
use Volta\Domain\ValueObject\CalibrationName;

class CalibrationSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(
            new CalibrationName('diameter'),
            new \DateTimeImmutable('2020-03-16'),
            [50.5, 45.3, 51.6],
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

    public function it_can_update_the_name(): void
    {
        $name = 'length';
        $this->setName(new CalibrationName($name));
        $this->getName()->shouldBeLike(new CalibrationName($name));
    }

    public function it_has_a_timestamp(): void
    {
        $this->getTimestamp()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this->getTimestamp()->shouldBeLike(new \DateTimeImmutable('2020-03-16'));
    }

    public function it_can_update_the_timestamp(): void
    {
        $date = '2020-05-28';
        $this->setTimestamp(new \DateTimeImmutable($date));
        $this->getTimestamp()->shouldBeLike(new \DateTimeImmutable($date));
    }

    public function it_has_measurements(): void
    {
        $this->getMeasurements()->shouldBeArray();
        $this->getMeasurements()->shouldBe([50.5, 45.3, 51.6]);
    }

    public function it_can_update_measurements(): void
    {
        $measurements = [100, 67.3];
        $this->setMeasurements($measurements);
        $this->getMeasurements()->shouldBeArray();
        $this->getMeasurements()->shouldBe($measurements);
    }
}
