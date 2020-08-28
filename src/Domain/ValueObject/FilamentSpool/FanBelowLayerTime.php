<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\NegativeValueException;
use Volta\Domain\Exception\ZeroValueException;

/**
 * Class representing the number of seconds of layer printing time at  which (or below) the
 * fan needs to be enabled.
 */
class FanBelowLayerTime
{
    private const VALUE_OBJECT_NAME = 'fan below layer time';

    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->validate();
    }

    private function validate(): void
    {
        if (0 > $this->value) {
            throw new NegativeValueException(self::VALUE_OBJECT_NAME);
        }

        if (0 === $this->value) {
            throw new ZeroValueException(self::VALUE_OBJECT_NAME);
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
