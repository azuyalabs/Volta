<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject\Manufacturer;

class ManufacturerName
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(ManufacturerName $other): bool
    {
        return $this->value === $other->value;
    }
}
