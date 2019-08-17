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

namespace Tests\Unit;

use App\Http\Resources\ThreeDPrinterJobCollectionResource;
use Tests\TestCase;

/**
 * Class containing cases for testing the 3D Printer Job Resource Collection class.
 *
 * //TODO: Incomplete tests!
 *
 * @package Tests\Unit\Resources
 */
class ThreeDPrinterJobCollectionResourceTest extends TestCase
{
    /** @test */
    public function it_can_return_a_correct_response(): void
    {
        $resource = (new ThreeDPrinterJobCollectionResource($jos = factory('App\MachineJob', 2)->create()))->jsonSerialize();

        $this->assertArrayHasKey('data', $resource);
    }
}
