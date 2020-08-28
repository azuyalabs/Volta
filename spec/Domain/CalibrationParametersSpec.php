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

use Volta\Domain\CalibrationParameters;
use Volta\Domain\Exception\CalibrationParameterNotFoundException;

class CalibrationParametersSpec
{
    public function let(): void
    {
        $this->add(['parameter' => 'value']);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CalibrationParameters::class);
    }

    public function it_can_add_a_parameter(): void
    {
        $this->add(['ratio' => 2]);

        $this->all()->shouldBeArray();
        $this->all()->shouldHaveCount(2);
        $this->get('ratio')->shouldBe(2);
    }

    public function it_can_set_a_parameter(): void
    {
        $this->set('pie', 3.14);

        $this->all()->shouldBeArray();
        $this->all()->shouldHaveCount(2);
        $this->get('pie')->shouldBe(3.14);
    }

    public function it_can_check_if_parameter_exists(): void
    {
        $this->has('parameter')->shouldBe(true);
    }

    public function it_can_remove_a_parameter(): void
    {
        $this->set('pie', 3.14);

        $this->all()->shouldBeArray();
        $this->all()->shouldHaveCount(2);
        $this->get('pie')->shouldBe(3.14);

        $this->remove('parameter');

        $this->all()->shouldHaveCount(2);
    }

    public function it_can_clear_all_parameters(): void
    {
        $this->clear();

        $this->all()->shouldBeArray();
        $this->all()->shouldHaveCount(0);
    }

    public function it_can_get_a_parameter(): void
    {
        $this->get('parameter')->shouldBe('value');
    }

    public function it_throws_exception(): void
    {
        $this->shouldThrow(CalibrationParameterNotFoundException::class)
            ->duringGet('something')
        ;
    }
}
