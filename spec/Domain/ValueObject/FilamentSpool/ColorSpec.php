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

namespace spec\Volta\Domain\ValueObject\FilamentSpool;

use OzdemirBurak\Iris\Color\Hex;
use PhpSpec\ObjectBehavior;
use Volta\Domain\ValueObject\FilamentSpool\Color;
use Volta\Domain\ValueObject\FilamentSpool\ColorName;

class ColorSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(
            new ColorName('White'),
            new Hex('#ffffff')
        );
    }

    public function it_has_color_name(): void
    {
        $this->getColorName()->shouldBeAnInstanceOf(ColorName::class);
        $this->getColorName()->getValue()->shouldBe('White');
    }

    public function it_has_color_code(): void
    {
        $this->getColorCode()->shouldBeAnInstanceOf(Hex::class);
        $this->getColorCode()->__toString()->shouldBe('#ffffff');
    }

    public function it_compares_equality(): void
    {
        $other = new Color(
            new ColorName('Orange'),
            new Hex('#ffa500')
        );
        $this->shouldNotBeEqual($other);

        $this->shouldBeEqual($this);

        $cloned = clone $this;
        $this->shouldBeEqual($cloned);
    }
}
