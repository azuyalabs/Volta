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

namespace Volta\Application\DataTransformer\FilamentSpool;

class SlicerTemplate
{
    private $diameter = 0;

    public function getDiameter(): float
    {
        return $this->diameter;
    }

    public function setDiameter(float $diameter): void
    {
        $this->diameter = $diameter;
    }
}
