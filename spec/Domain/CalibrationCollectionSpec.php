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
use Volta\Domain\CalibrationCollection;
use Volta\Domain\Exception\NoCalibrationsException;
use Volta\Domain\ValueObject\CalibrationName;

class CalibrationCollectionSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->add(new Calibration(
            new CalibrationName('length'),
            new \DateTimeImmutable('2020-03-13'),
            [113, 115, 117]
        ));
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CalibrationCollection::class);
    }

    public function it_can_add_a_calibration(): void
    {
        $this->add(new Calibration(
            new CalibrationName('volume'),
            new \DateTimeImmutable('2020-04-05'),
            [10, 20]
        ));

        $this->getCalibrations()->shouldBeArray();
        $this->getCalibrations()->shouldHaveCount(2);
    }

    public function it_can_get_calibrations_by_name(): void
    {
        $this->add(new Calibration(
            new CalibrationName('volume'),
            new \DateTimeImmutable('2020-04-05'),
            [10, 20]
        ));

        $this->add(new Calibration(
            new CalibrationName('volume'),
            new \DateTimeImmutable('2020-04-06'),
            [23, 30]
        ));

        $this->getCalibrations('volume')->shouldBeArray();
        $this->getCalibrations('volume')->shouldHaveCount(2);

        $this->getCalibrations('length')->shouldBeArray();
        $this->getCalibrations('length')->shouldHaveCount(1);
    }

    public function it_can_get_an_average_with_a_single_calibration(): void
    {
        $this->getAverage('length')->shouldBeDouble();
        $this->getAverage('length')->shouldBe(115.0);
    }

    public function it_can_get_an_average_with_multiple_calibration(): void
    {
        $this->add(new Calibration(
            new CalibrationName('speed'),
            new \DateTimeImmutable('2019-03-13'),
            [356, 350, 298, 478]
        ));

        $this->add(new Calibration(
            new CalibrationName('speed'),
            new \DateTimeImmutable('2019-03-15'),
            [267, 114]
        ));

        $this->getAverage('speed')->shouldBeDouble();
        $this->getAverage('speed')->shouldBe(310.5);
    }

    public function it_throws_an_exception_when_for_average_no_calibrations_exist(): void
    {
        $this->shouldThrow(NoCalibrationsException::class)
            ->duringGetAverage('zutons');
    }

    public function it_can_get_the_maximum_with_a_single_calibration(): void
    {
        $this->getMaximum('length')->shouldBeDouble();
        $this->getMaximum('length')->shouldBe(117.0);
    }

    public function it_can_get_the_maximum_with_multiple_calibration(): void
    {
        $this->add(new Calibration(
            new CalibrationName('length'),
            new \DateTimeImmutable('2019-03-13'),
            [66, 33, 109]
        ));

        $this->getMaximum('length')->shouldBeDouble();
        $this->getMaximum('length')->shouldBe(117.0);
    }

    public function it_throws_an_exception_when_for_maximum_no_calibrations_exist(): void
    {
        $this->shouldThrow(NoCalibrationsException::class)
            ->duringGetMaximum('zutons');
    }

    public function it_can_get_the_minimum_with_a_single_calibration(): void
    {
        $this->getMinimum('length')->shouldBeDouble();
        $this->getMinimum('length')->shouldBe(113.0);
    }

    public function it_can_get_the_minimum_with_multiple_calibration(): void
    {
        $this->add(new Calibration(
            new CalibrationName('length'),
            new \DateTimeImmutable('2019-03-13'),
            [66, 33, 109]
        ));

        $this->getMinimum('length')->shouldBeDouble();
        $this->getMinimum('length')->shouldBe(33.0);
    }

    public function it_throws_an_exception_when_for_minimum_no_calibrations_exist(): void
    {
        $this->shouldThrow(NoCalibrationsException::class)
            ->duringGetMinimum('zutons');
    }

    public function it_can_get_latest_calibration_date(): void
    {
        $this->add(new Calibration(
            new CalibrationName('length'),
            new \DateTimeImmutable('2021-12-13'),
            [33, 109]
        ));

        $this->getLatestCalibrationDate('length')->shouldBeAnInstanceOf(\DateTimeInterface::class);
        $this->getLatestCalibrationDate('length')->shouldBeLike(new \DateTimeImmutable('2021-12-13'));
    }

    public function it_can_get_calibration_names(): void
    {
        $this->add(new Calibration(
            new CalibrationName('volume'),
            new \DateTimeImmutable('2021-12-13'),
            [190, 2010]
        ));

        $this->getCalibrationNames()->shouldBeArray();
        $this->getCalibrationNames()->shouldBe(['length', 'volume']);
    }

    public function it_can_get_latest_calibration(): void
    {
        $firstDate = new \DateTimeImmutable('2021-12-13');
        $this->add(new Calibration(
            new CalibrationName('length'),
            $firstDate,
            [33, 109]
        ));

        $secondDate = new \DateTimeImmutable('2020-12-14');
        $this->add(new Calibration(
            new CalibrationName('length'),
            $secondDate,
            [66, 29, 89]
        ));

        $thirdDate = new \DateTimeImmutable('2019-03-12');
        $this->add(new Calibration(
            new CalibrationName('length'),
            $thirdDate,
            [6, 9, 113]
        ));

        $this->getLatestCalibration('length')->shouldBeAnInstanceOf(Calibration::class);
        $this->getLatestCalibration('length')->getTimestamp()->shouldBe($firstDate);
    }

    public function it_throws_an_exception_when_for_latest_calibration_no_calibrations_exist(): void
    {
        $this->shouldThrow(NoCalibrationsException::class)
            ->duringGetLatestCalibration('crutons');
    }

    public function it_can_get_first_calibration(): void
    {
        $firstDate = new \DateTimeImmutable('2022-07-23');
        $this->add(new Calibration(
            new CalibrationName('speed'),
            $firstDate,
            [123, 126]
        ));

        $secondDate = new \DateTimeImmutable('2020-09-14');
        $this->add(new Calibration(
            new CalibrationName('speed'),
            $secondDate,
            [89, 43, 89]
        ));

        $thirdDate = new \DateTimeImmutable('2018-03-19');
        $this->add(new Calibration(
            new CalibrationName('speed'),
            $thirdDate,
            [15, 449, 113]
        ));

        $this->getEarliestCalibration('speed')->shouldBeAnInstanceOf(Calibration::class);
        $this->getEarliestCalibration('speed')->getTimestamp()->shouldBe($thirdDate);
    }

    public function it_throws_an_exception_when_for_earliest_calibration_no_calibrations_exist(): void
    {
        $this->shouldThrow(NoCalibrationsException::class)
            ->duringGetEarliestCalibration('daltons');
    }
}
