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
use Volta\Domain\Exception\InvalidWebsiteException;
use Volta\Domain\ValueObject\Website;

class WebsiteSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('https://www.example.com');
    }

    public function it_can_be_initialized(): void
    {
        $this->shouldBeAnInstanceOf(Website::class);
    }

    public function it_has_website_address_value(): void
    {
        $this->getValue()->shouldBeString();
        $this->getValue()->shouldBe('https://www.example.com');
    }

    public function it_rejects_empty_website_address_value(): void
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidWebsiteException::class)->duringInstantiation();
    }

    public function it_compares_equality(): void
    {
        $other = new Website('https://www.website.org');
        $this->shouldNotBeEqual($other);

        $this->shouldBeEqual($this);

        $another = clone $this;
        $this->shouldBeEqual($another);
    }

    public function it_rejects_an_invalid_value(): void
    {
        $this->beConstructedWith('notvalid');
        $this->shouldThrow(InvalidWebsiteException::class)->duringInstantiation();
    }
}
