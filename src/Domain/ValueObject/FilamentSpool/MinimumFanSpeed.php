<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\FilamentSpool\MaximumValueMinimumFanSpeedException;
use Volta\Domain\Exception\NegativeValueException;

/**
 * Class representing the Minimum Fan Speed
 *
 * Although it is called 'speed', this attribute is usually expressed as a percentage.
 * (e.g. '50' denotes 50% of the fan speed's maximum capacity)
 *
 * @package Volta\Domain\ValueObject\FilamentSpool
 */
class MinimumFanSpeed
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->validate();
    }

    private function validate(): void
    {
        if (100 < $this->value) {
            throw new MaximumValueMinimumFanSpeedException();
        }

        if (0 > $this->value) {
            throw new NegativeValueException('minimum fan speed');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isEqual(int $other): bool
    {
        return $this->value === $other;
    }
}
