<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\NegativeValueException;

/**
 * Class representing the number of first layers at which the fan should be disabled.
 *
 * @package Volta\Domain\ValueObject\FilamentSpool
 */
class DisableFanFirstLayers
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->validate();
    }

    private function validate(): void
    {
        if (0 > $this->value) {
            throw new NegativeValueException();
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
