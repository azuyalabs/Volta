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
use Volta\Domain\ValueObject\Manufacturer\ManufacturerFilamentSupplier;

class ManufacturerFilamentSupplierSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(true);
    }

    public function it_has_a_value(): void
    {
        $this->getValue()->shouldBeBool();
        $this->getValue()->shouldBe(true);
        $this->isFilamentSupplier()->shouldBe(true);
    }

    public function it_compares_equality(): void
    {
        $other = new ManufacturerFilamentSupplier(false);
        $this->shouldNotBeEqual($other);

        $this->shouldBeEqual($this);

        $cloned = clone $this;
        $this->shouldBeEqual($cloned);
    }
}
