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
use Volta\Domain\ValueObject\FilamentSpool\MaximumVolumetricFlowRate;
use Volta\Domain\VolumetricFlowRate;

class MaximumVolumetricFlowRateSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(new VolumetricFlowRate(15.501, MaximumVolumetricFlowRate::CUBIC_MILLIMETER_PER_SECOND));
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MaximumVolumetricFlowRate::class);
    }

    public function it_has_value(): void
    {
        $this->getValue()->shouldBeAnInstanceOf(VolumetricFlowRate::class);
        $this->getValue()->toUnit(MaximumVolumetricFlowRate::CUBIC_MILLIMETER_PER_SECOND)->shouldBeLike(15.501);
    }

    public function it_compares_equality(): void
    {
        $other = new MaximumVolumetricFlowRate(new VolumetricFlowRate(78.33, MaximumVolumetricFlowRate::CUBIC_MILLIMETER_PER_SECOND));
        $this->shouldNotBeEqual($other->getValue());

        $this->shouldBeEqual($this->getValue());

        $cloned = clone $this;
        $this->shouldBeEqual($cloned->getValue());
    }

    public function it_throws_an_exception_when_value_is_negative(): void
    {
        $this->beConstructedWith(new VolumetricFlowRate(-10.56, MaximumVolumetricFlowRate::CUBIC_MILLIMETER_PER_SECOND));
        $this->shouldThrow(NegativeValueException::class)
            ->duringInstantiation();
    }

    public function it_throws_an_exception_when_value_is_zero(): void
    {
        $this->beConstructedWith(new VolumetricFlowRate(0, MaximumVolumetricFlowRate::CUBIC_MILLIMETER_PER_SECOND));
        $this->shouldThrow(ZeroValueException::class)
            ->duringInstantiation();
    }
}
