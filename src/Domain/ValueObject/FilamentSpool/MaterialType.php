<?php
/**
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2020. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

declare(strict_types=1);

namespace Volta\Domain\ValueObject\FilamentSpool;

use Volta\Domain\Exception\FilamentSpool\InvalidMaterialTypeException;

class MaterialType
{
    public const MATERIALTYPE_PLA      = 'PLA';
    public const MATERIALTYPE_ABS      = 'ABS';
    public const MATERIALTYPE_PET      = 'PET';
    public const MATERIALTYPE_PP       = 'PP';
    public const MATERIALTYPE_WOODFILL = 'Woodfill';
    public const MATERIALTYPE_FLEX     = 'FLEX';

    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->validate();
    }

    private function validate(): void
    {
        $types = [
            self::MATERIALTYPE_ABS,
            self::MATERIALTYPE_PLA,
            self::MATERIALTYPE_PET,
            self::MATERIALTYPE_PP,
            self::MATERIALTYPE_WOODFILL,
            self::MATERIALTYPE_FLEX,
        ];
        if (false === \in_array($this->value, $types, true)) {
            throw new InvalidMaterialTypeException();
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(MaterialType $type): bool
    {
        return $this->value === $type->value;
    }
}
