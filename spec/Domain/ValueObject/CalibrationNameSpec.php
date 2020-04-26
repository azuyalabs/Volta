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

namespace spec\Volta\Domain\ValueObject;

use PhpSpec\ObjectBehavior;
use Volta\Domain\Exception\BlankCalibrationNameException;
use Volta\Domain\ValueObject\CalibrationName;

class CalibrationNameSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('volume');
    }

    public function it_has_name(): void
    {
        $this->getValue()->shouldBeString();
        $this->getValue()->shouldBe('volume');
    }

    public function it_throws_exception_if_name_is_blank(): void
    {
        $this->beConstructedWith('');

        $this->shouldThrow(BlankCalibrationNameException::class)->duringInstantiation();
    }

    public function it_compares_equality(): void
    {
        $other = new CalibrationName('width');
        $this->shouldNotBeEqual($other);

        $this->shouldBeEqual($this);

        $cloned = clone $this;
        $this->shouldBeEqual($cloned);
    }
}
