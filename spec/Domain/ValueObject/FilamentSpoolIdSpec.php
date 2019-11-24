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
use Volta\Domain\ValueObject\FilamentSpoolId;

class FilamentSpoolIdSpec extends ObjectBehavior
{
    public function it_generates_an_id(): void
    {
        $this->getValue()->shouldBeString();
        $this->getValue()->shouldMatch('/[a-f0-9-]{36}/i');
    }

    public function it_can_build_from_a_string(): void
    {
        $uuid = 'f5164b9c-3162-4d32-9d0c-8e3eb774be9d';
        $this->beConstructedThrough('fromString', [$uuid]);
        $this->getValue()->shouldBe($uuid);
    }

    public function it_compares_equality(): void
    {
        $other = new FilamentSpoolId();
        $this->shouldNotBeEqual($other);

        $this->shouldBeEqual($this);

        $another = clone $this;
        $this->shouldBeEqual($another);
    }

    public function it_throws_an_exception_on_an_invalid_uuid_string(): void
    {
        $this->beConstructedThrough('fromString', ['not_an_uuid']);
        $this->shouldThrow()->duringInstantiation();
    }

//    function it_not_equals_if_you_compare_to_another_type_of_id()
//    {
//        $other = ReviewerId::fromString($this->getWrappedObject()->getValue());
//        $this->isEqual($other)->shouldBe(false);
//    }
}
