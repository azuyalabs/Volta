<?php

declare(strict_types=1);

namespace Volta\Domain\ValueObject\Manufacturer;

use Volta\Domain\Exception\Manufacturer\BlankManufacturerNameException;

class ManufacturerName
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate();
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

    /**
     * @throws BlankManufacturerNameException
     */
    private function validate(): void
    {
        if (empty($this->value)) {
            throw new BlankManufacturerNameException();
        }
    }
}
