<?php

declare(strict_types=1);

namespace Volta\Domain;

use Volta\Domain\Exception\NoCalibrationsException;

class CalibrationCollection
{
    public const FIRST_LAYER_PRINT_TEMP   = 'first_layer_print_temperature';
    public const NEXT_LAYER_PRINT_TEMP    = 'next_layer_print_temperature';
    public const FIRST_LAYER_BED_TEMP     = 'first_layer_bed_temperature';
    public const NEXT_LAYER_BED_TEMP      = 'next_layer_bed_temperature';
    public const FILAMENT_DIAMETER        = 'diameter';
    public const EXTRUSION_MULTIPLIER     = 'extrusion_multiplier';
    public const K_VALUE                  = 'k_value';

    private array $calibrations = [];

    public function add(Calibration $calibration): void
    {
        $this->calibrations[$calibration->getName()->getValue()][] = $calibration;
    }

    public function getCalibrations(?string $name = null): array
    {
        return null === $name ? $this->calibrations : $this->calibrations[$name];
    }

    public function getAverage(string $name): float
    {
        if (!isset($this->calibrations[$name])) {
            throw new NoCalibrationsException();
        }

        $result    = 0;
        $cals      = $this->calibrations[$name];

        if (0 < count($cals)) {
            $sum  = array_reduce($cals, static function ($carry, $item) {
                $count  = (is_array($carry)) ? $carry[0] : 0;
                $values = (is_array($carry)) ? $carry[1] : 0;

                return [$count + count($item->getMeasurements()), $values + array_sum($item->getMeasurements())];
            });

            if (0 < $sum[0]) {
                $result = $sum[1] / $sum[0];
            }
        }

        return $result;
    }

    public function getMaximum(string $name): float
    {
        if (!isset($this->calibrations[$name])) {
            throw new NoCalibrationsException();
        }

        return array_reduce($this->calibrations[$name], static function ($carry, $item) {
            $msr = max($item->getMeasurements());

            return (null !== $carry && $carry > $msr) ? $carry : $msr;
        });
    }

    public function getMinimum(string $name): float
    {
        if (!isset($this->calibrations[$name])) {
            throw new NoCalibrationsException();
        }

        return array_reduce($this->calibrations[$name], static function ($carry, $item) {
            $msr = min($item->getMeasurements());

            return (null !== $carry && $carry < $msr) ? $carry : $msr;
        });
    }

    public function getLatestCalibrationDate(string $name): \DateTimeImmutable
    {
        if (!isset($this->calibrations[$name])) {
            throw new NoCalibrationsException();
        }

        return array_reduce($this->calibrations[$name], static function ($carry, $item) {
            $time = $item->getTimestamp();

            return (null !== $carry && $carry > $time) ? $carry : $time;
        });
    }

    public function getCalibrationNames(): array
    {
        return array_keys($this->calibrations);
    }

    public function getLatestCalibration(string $name): Calibration
    {
        if (!isset($this->calibrations[$name])) {
            throw new NoCalibrationsException();
        }

        return array_reduce($this->calibrations[$name], static function ($carry, $item) {
            return (null !== $carry && $carry->getTimestamp() > $item->getTimestamp()) ? $carry : $item;
        });
    }

    public function getEarliestCalibration(string $name): Calibration
    {
        if (!isset($this->calibrations[$name])) {
            throw new NoCalibrationsException();
        }

        return array_reduce($this->calibrations[$name], static function ($carry, $item) {
            return (null !== $carry && $carry->getTimestamp() < $item->getTimestamp()) ? $carry : $item;
        });
    }
}
