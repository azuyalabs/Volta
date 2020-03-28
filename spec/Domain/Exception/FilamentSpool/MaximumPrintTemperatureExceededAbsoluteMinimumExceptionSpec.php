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

namespace spec\Volta\Domain\Exception\FilamentSpool;

use PhpSpec\ObjectBehavior;
use Volta\Domain\Exception\Exception;

class MaximumPrintTemperatureExceededAbsoluteMinimumExceptionSpec extends ObjectBehavior
{
    public function it_is_a_domain_exception(): void
    {
        $this->shouldImplement(Exception::class);
    }

    public function it_is_an_spl_range_exception(): void
    {
        $this->shouldBeAnInstanceOf(\RangeException::class);
    }

    public function it_has_a_descriptive_message(): void
    {
        $this->getMessage()->shouldBe('maximum print temperature can not exceed absolute minimum');
    }
}
