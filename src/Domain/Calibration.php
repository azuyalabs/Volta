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

use Volta\Domain\ValueObject\CalibrationName;

class Calibration
{
    private CalibrationName $name;
    private \DateTimeImmutable $timestamp;
    private array $measurements;

    public function __construct(CalibrationName $name, \DateTimeImmutable $timestamp, array $measurements)
    {
        $this->name         = $name;
        $this->timestamp    = $timestamp;
        $this->measurements = $measurements;
    }

    public function setTimestamp(\DateTimeImmutable $timestamp): Calibration
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTimestamp(): \DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function setName(CalibrationName $name): Calibration
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): CalibrationName
    {
        return $this->name;
    }


    public function setMeasurements(array $measurements): Calibration
    {
        $this->measurements = $measurements;

        return $this;
    }

    public function getMeasurements(): array
    {
        return $this->measurements;
    }
}
