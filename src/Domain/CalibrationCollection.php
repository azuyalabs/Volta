<?php

namespace Volta\Domain;

use Volta\Domain\Exception\NoCalibrationsException;

class CalibrationCollection
{
    private array $calibrations = [];

    public function add(Calibration $calibration): void
    {
        $this->calibrations[$calibration->getName()->getValue()][] = $calibration;
    }

    public function getCalibrations(?string $name = null): array
    {
        return is_null($name) ? $this->calibrations: $this->calibrations[$name] ;
    }

    public function getAverage(string $name):  float
    {
        if (!isset($this->calibrations[$name])) {
            throw new NoCalibrationsException();
        }

        $result = 0;
        $c      = $this->calibrations[$name];

        if (0 < count($c)) {
            $sum  = array_reduce($c, static function ($carry, $item) {
                $count  = (is_array($carry)) ? $carry[0] : 0;
                $values = (is_array($carry)) ? $carry[1] : 0;

                return [$count + count($item->getMeasurements()), $values + array_sum($item->getMeasurements())];
            });

            $result = $sum[1] / $sum[0];
        }

        return $result;
    }

    public function getMaximum(string $name): float
    {
        if (!isset($this->calibrations[$name])) {
            throw new NoCalibrationsException();
        }

        return array_reduce($this->calibrations[$name], static function ($carry, $item) {
            $m = max($item->getMeasurements());

            return (!is_null($carry) && $carry > $m) ? $carry : $m;
        });
    }

    public function getMinimum(string $name): float
    {
        if (!isset($this->calibrations[$name])) {
            throw new NoCalibrationsException();
        }

        return array_reduce($this->calibrations[$name], static function ($carry, $item) {
            $m = min($item->getMeasurements());

            return (!is_null($carry) && $carry < $m) ? $carry : $m;
        });
    }
}
