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

namespace spec\Volta\Application\DataTransformer\FilamentSpool;

 use PhpSpec\ObjectBehavior;

 class SlicerTemplateSpec extends ObjectBehavior
 {
     public function it_has_diameter(): void
     {
         $this->getDiameter()->shouldBe(0);
         $this->setDiameter(1.75);
         $this->getDiameter()->shouldBe(1.75);
     }
 }
