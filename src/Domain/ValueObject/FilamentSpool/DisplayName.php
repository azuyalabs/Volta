<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\FilamentSpool\BlankDisplayNameException;

class DisplayName
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
            throw new BlankDisplayNameException();
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(DisplayName $other): bool
    {
        return $this->value === $other->value;
    }
}
