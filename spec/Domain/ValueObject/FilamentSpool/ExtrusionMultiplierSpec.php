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
use Volta\Domain\Exception\UpperLimitValueException;
use Volta\Domain\Exception\ZeroValueException;
use Volta\Domain\ValueObject\FilamentSpool\ExtrusionMultiplier;

class ExtrusionMultiplierSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(1.03);
    }

    public function it_has_value(): void
    {
        $this->getValue()->shouldBeFloat();
        $this->getValue()->shouldBe(1.03);
    }

    public function it_throws_an_exception_when_value_negative(): void
    {
        $this->beConstructedWith(-2.14);
        $this->shouldThrow(NegativeValueException::class)->duringInstantiation();
    }

    public function it_throws_an_exception_when_value_is_zero(): void
    {
        $this->beConstructedWith(0);
        $this->shouldThrow(ZeroValueException::class)->duringInstantiation();
    }

    public function it_throws_an_exception_when_value_exceeds_upper_limit(): void
    {
        $this->beConstructedWith(3.14);
        $this->shouldThrow(UpperLimitValueException::class)->duringInstantiation();
    }

    public function it_compares_equality(): void
    {
        $other = new ExtrusionMultiplier(0.93);
        $this->shouldNotBeEqual($other->getValue());

        $this->shouldBeEqual($this->getValue());

        $cloned = clone $this;
        $this->shouldBeEqual($cloned->getValue());
    }
}
