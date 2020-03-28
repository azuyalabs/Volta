<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\FilamentSpool\BlankColorNameException;

class ColorName
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->value)) {
            throw new BlankColorNameException();
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(ColorName $other): bool
    {
        return $this->value === $other->value;
    }
}
