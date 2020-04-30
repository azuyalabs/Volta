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

        // TODO Validate if measurements is empty.
    }

    public function getTimestamp(): \DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function getName(): CalibrationName
    {
        return $this->name;
    }

    public function getMeasurements(): array
    {
        return $this->measurements;
    }

    public function getMaximum(): float
    {
        return max($this->measurements);
    }

    public function getMinimum():float
    {
        return min($this->measurements);
    }

    public function getAverage():float
    {
        return (array_sum($this->measurements)/count($this->measurements));
    }
}
