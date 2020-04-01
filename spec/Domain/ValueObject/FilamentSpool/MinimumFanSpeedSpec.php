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
use Volta\Domain\Exception\FilamentSpool\MaximumValueMinimumFanSpeedException;
use Volta\Domain\ValueObject\FilamentSpool\MinimumFanSpeed;

class MinimumFanSpeedSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(55);
    }

    public function it_has_value(): void
    {
        $this->getValue()->shouldBeInteger();
        $this->getValue()->shouldBe(55);
    }

    public function it_throws_an_exception_when_value_exceeds_maximum(): void
    {
        $this->beConstructedWith(115);
        $this->shouldThrow(MaximumValueMinimumFanSpeedException::class)
                ->duringInstantiation();
    }

    public function it_compares_equality(): void
    {
        $other = new MinimumFanSpeed(78);
        $this->shouldNotBeEqual($other->getValue());

        $this->shouldBeEqual($this->getValue());

        $cloned = clone $this;
        $this->shouldBeEqual($cloned->getValue());
    }
}
