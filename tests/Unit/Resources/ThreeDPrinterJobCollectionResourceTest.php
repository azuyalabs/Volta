<?php

declare(strict_types=1);
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
use App\MachineJob;
use Tests\TestCase;

/**
 * Class containing cases for testing the 3D Printer Job Resource Collection class.
 *
 * //TODO: Incomplete tests!
 *
 * @internal
 * @coversNothing
 */
class ThreeDPrinterJobCollectionResourceTest extends TestCase
{
    /** @test */
    public function itCanReturnACorrectResponse(): void
    {
        $resource = (new ThreeDPrinterJobCollectionResource($jos = factory(MachineJob::class, 2)->create()))->jsonSerialize();

        $this->assertArrayHasKey('data', $resource);
    }
}
