<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject;

use Volta\Domain\Exception\BlankCalibrationNameException;

class CalibrationName
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(CalibrationName $other): bool
    {
        return $this->value === $other->value;
    }

    private function validate(): void
    {
        if (empty($this->value)) {
            throw new BlankCalibrationNameException();
        }
    }
}
