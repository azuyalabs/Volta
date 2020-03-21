<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject\Manufacturer;

class ManufacturerFilamentSupplier
{
    private $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function isFilamentSupplier(): bool
    {
        return $this->getValue();
    }

    public function isEqual(ManufacturerFilamentSupplier $filamentSupplier): bool
    {
        return $this->value === $filamentSupplier->value;
    }
}
