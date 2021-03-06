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
use Volta\Domain\Exception\NegativeValueException;
use Volta\Domain\Exception\ZeroValueException;
use Volta\Domain\ValueObject\FilamentSpool\MinimumPrintSpeed;

class MinimumPrintSpeedSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(43.0);
    }

    public function it_has_value(): void
    {
        $this->getValue()->shouldBeDouble();
        $this->getValue()->shouldBe(43.0);
    }

    public function it_throws_an_exception_when_value_negative(): void
    {
        $this->beConstructedWith(-5.4);
        $this->shouldThrow(NegativeValueException::class)
            ->duringInstantiation()
        ;
    }

    public function it_throws_an_exception_when_value_is_zero(): void
    {
        $this->beConstructedWith(0.0);
        $this->shouldThrow(ZeroValueException::class)
            ->duringInstantiation()
        ;
    }

    public function it_compares_equality(): void
    {
        $other = new MinimumPrintSpeed(83.5);
        $this->shouldNotBeEqual($other->getValue());

        $this->shouldBeEqual($this->getValue());

        $cloned = clone $this;
        $this->shouldBeEqual($cloned->getValue());
    }
}
