<?php

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\NegativeValueException;
use Volta\Domain\Exception\ZeroValueException;
use Volta\Domain\Velocity;

class MaximumVolumetricSpeed
{
    private Velocity $value;

    public function __construct(Velocity $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function getValue(): Velocity
    {
        return $this->value;
    }

    private function validate(): void
    {
        if (0 > $this->value->toNativeUnit()) {
            throw new NegativeValueException();
        }

        if (abs($this->value->toNativeUnit() - 0) < PHP_FLOAT_EPSILON) {
            throw new ZeroValueException();
        }
    }

    public function isEqual(Velocity $other): bool
    {
        return $this->value === $other;
    }
}
