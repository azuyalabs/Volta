<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\FilamentSpool\MaximumValueMaximumFanSpeedException;

/**
 * Class representing the Maximum Fan Speed
 *
 * Although it is called 'speed', this attribute is usually expressed as a percentage.
 * (e.g. '50' denotes 50% of the fan speed's maximum capacity)
 *
 * @package Volta\Domain\ValueObject\FilamentSpool
 */
class MaximumFanSpeed
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->validate();
    }

    private function validate(): void
    {
        if (100 < $this->value) {
            throw new MaximumValueMaximumFanSpeedException();
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
