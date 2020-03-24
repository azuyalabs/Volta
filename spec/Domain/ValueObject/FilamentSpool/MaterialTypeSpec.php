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

use PhpSpec\ObjectBehavior;
use Volta\Domain\Exception\FilamentSpool\InvalidMaterialTypeException;
use Volta\Domain\ValueObject\FilamentSpool\MaterialType;

class MaterialTypeSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('PLA');
    }

    public function it_has_value(): void
    {
        $this->getValue()->shouldBeString();
        $this->getValue()->shouldBe('PLA');
    }

    public function it_validates(): void
    {
        $this->beConstructedWith('ABS');
    }

    public function it_rejects_an_invalid_value(): void
    {
        $this->beConstructedWith('xyz');
        $this->shouldThrow(InvalidMaterialTypeException::class)->duringInstantiation();
    }

    public function it_compares_equality(): void
    {
        $other = new MaterialType('ABS');
        $this->shouldNotBeEqual($other);

        $this->shouldBeEqual($this);

        $cloned = clone $this;
        $this->shouldBeEqual($cloned);
    }
}
