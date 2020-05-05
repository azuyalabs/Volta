<?php

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\NegativeValueException;
use Volta\Domain\Exception\ZeroValueException;
use Volta\Domain\VolumetricFlowRate;

class MaximumVolumetricFlowRate
{
    public const CUBIC_MILLIMETER_PER_SECOND = 'mm^3/s';

    private VolumetricFlowRate $value;

    public function __construct(VolumetricFlowRate $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function getValue(): VolumetricFlowRate
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

    public function isEqual(VolumetricFlowRate $other): bool
    {
        return $this->value === $other;
    }
}
