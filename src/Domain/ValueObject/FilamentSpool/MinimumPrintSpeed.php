<?php

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\NegativeValueException;
use Volta\Domain\Exception\ZeroValueException;

class MinimumPrintSpeed
{
    private const VALUE_OBJECT_NAME = 'minimum print speed';

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

        if (0.0 === $this->value) {
            throw new ZeroValueException(self::VALUE_OBJECT_NAME);
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
