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

use OzdemirBurak\Iris\Color\Hex;

class Color
{
    private ColorName $name;

    private Hex $code;

    public function __construct(ColorName $name, Hex $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    public function isEqual(Color $other): bool
    {
        return $this->name === $other->getColorName()
            && $this->code === $other->getColorCode();
    }

    public function getColorName(): ColorName
    {
        return $this->name;
    }

    public function getColorCode(): Hex
    {
        return $this->code;
    }
}
