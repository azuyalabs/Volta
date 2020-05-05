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
use Volta\Domain\ValueObject\FilamentSpool\MaximumVolumetricSpeed;
use Volta\Domain\Velocity;

class MaximumVolumetricSpeedSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(new Velocity(15.5, MaximumVolumetricSpeed::MILLIMETER_PER_SECOND));
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MaximumVolumetricSpeed::class);
    }

    public function it_has_value(): void
    {
        $this->getValue()->shouldBeAnInstanceOf(Velocity::class);
        $this->getValue()->toUnit(MaximumVolumetricSpeed::MILLIMETER_PER_SECOND)->shouldBe(15.5);
    }

    public function it_compares_equality(): void
    {
        $other = new MaximumVolumetricSpeed(new Velocity(78.33, MaximumVolumetricSpeed::MILLIMETER_PER_SECOND));
        $this->shouldNotBeEqual($other->getValue());

        $this->shouldBeEqual($this->getValue());

        $cloned = clone $this;
        $this->shouldBeEqual($cloned->getValue());
    }

    public function it_throws_an_exception_when_value_is_negative(): void
    {
        $this->beConstructedWith(new Velocity(-10.56, MaximumVolumetricSpeed::MILLIMETER_PER_SECOND));
        $this->shouldThrow(NegativeValueException::class)
            ->duringInstantiation();
    }

    public function it_throws_an_exception_when_value_is_zero(): void
    {
        $this->beConstructedWith(new Velocity(0, MaximumVolumetricSpeed::MILLIMETER_PER_SECOND));
        $this->shouldThrow(ZeroValueException::class)
            ->duringInstantiation();
    }
}
