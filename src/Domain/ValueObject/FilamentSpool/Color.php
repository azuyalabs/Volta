<?php
/**
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2019. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

declare(strict_types=1);

namespace Volta\Domain\ValueObject\FilamentSpool;

class Color
{
    private $name;

    public function __construct(ColorName $name)
    {
        $this->name = $name;
        $this->validate();
    }

    private function validate(): void
    {
    }

    public function getColorName(): ColorName
    {
        return $this->name;
    }

    public function isEqual(Color $other): bool
    {
        return $this->name === $other->getColorName();
    }
}
