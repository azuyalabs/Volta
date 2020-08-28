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

namespace spec\Volta\Domain\ValueObject\Manufacturer;

use PhpSpec\ObjectBehavior;
use Volta\Domain\Exception\Manufacturer\BlankManufacturerNameException;
use Volta\Domain\ValueObject\Manufacturer\ManufacturerName;

class ManufacturerNameSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('ABC Plastics');
    }

    public function it_has_name(): void
    {
        $this->getValue()->shouldBeString();
        $this->getValue()->shouldBe('ABC Plastics');
    }

    public function it_throws_exception_if_name_is_blank(): void
    {
        $this->beConstructedWith('');

        $this
            ->shouldThrow(BlankManufacturerNameException::class)
            ->duringInstantiation()
        ;
    }

    public function it_compares_equality(): void
    {
        $other = new ManufacturerName('XYZ Printers');
        $this->shouldNotBeEqual($other);

        $this->shouldBeEqual($this);

        $cloned = clone $this;
        $this->shouldBeEqual($cloned);
    }
}
