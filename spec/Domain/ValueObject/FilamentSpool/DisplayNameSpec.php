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
use Volta\Domain\Exception\FilamentSpool\BlankDisplayNameException;
use Volta\Domain\ValueObject\FilamentSpool\DisplayName;

class DisplayNameSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('ABC Plastics PLA Blue 1.75mm');
    }

    public function it_has_value(): void
    {
        $this->getValue()->shouldBeString();
        $this->getValue()->shouldBe('ABC Plastics PLA Blue 1.75mm');
    }

    public function it_throws_exception_if_name_is_blank(): void
    {
        $this->beConstructedWith('');

        $this->shouldThrow(BlankDisplayNameException::class)
            ->duringInstantiation()
        ;
    }

    public function it_compares_equality(): void
    {
        $other = new DisplayName('XYZFilaments ABS Red 1.75mm');
        $this->shouldNotBeEqual($other);

        $this->shouldBeEqual($this);

        $cloned = clone $this;
        $this->shouldBeEqual($cloned);
    }
}
