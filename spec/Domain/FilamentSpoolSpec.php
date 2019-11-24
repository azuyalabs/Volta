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

namespace spec\Volta\Domain;

use PhpSpec\ObjectBehavior;
use Volta\Domain\FilamentSpool;
use Volta\Domain\ValueObject\FilamentSpoolId;

class FilamentSpoolSpec extends ObjectBehavior
{
    public function let():void
    {
        $this->beConstructedWith(
            new FilamentSpoolId(),
            'Midnight Blue'
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FilamentSpool::class);
    }

    public function it_has_an_identifier(): void
    {
        $this->getId()->shouldReturnAnInstanceOf(FilamentSpoolId::class);
    }

    public function it_has_a_name(): void
    {
        $this->getName()->shouldBe('Midnight Blue');
    }
}
