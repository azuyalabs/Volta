<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\NegativeValueException;
use Volta\Domain\Exception\UpperLimitValueException;
use Volta\Domain\Exception\ZeroValueException;

/**
 * Class representing the extrusion multiplier. The multiplier can be used to adjust the
 * filament flow. A multiplier less than 1 will reduce the flow, a multiplier higher than 1
 * increases the flow.
 */
class ExtrusionMultiplier
{
    private const VALUE_OBJECT_NAME = 'extrusion multiplier';

    private const UPPER_LIMIT = 2;

    private float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
        $this->validate();
    }

    private function validate(): void
    {
        if (0.0 > $this->value) {
            throw new NegativeValueException(self::VALUE_OBJECT_NAME);
        }

        if (abs($this->value - 0) < PHP_FLOAT_EPSILON) {
            throw new ZeroValueException();
        }

        if (self::UPPER_LIMIT <= $this->value) {
            throw new UpperLimitValueException(self::VALUE_OBJECT_NAME, self::UPPER_LIMIT);
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function isEqual(float $other): bool
    {
        return $this->value === $other;
    }
}
