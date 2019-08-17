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

use App\Machine;
use Tests\TestCase;
use App\MachineJobType;
use App\Http\Resources\ThreeDPrinterJobResource;

/**
 * Class containing cases for testing the 3D Printer Job Resource class.
 *
 * @package Tests\Unit\Resources
 */
class ThreeDPrinterJobResourceTest extends TestCase
{
    /** @test */
    public function it_can_return_a_correct_response(): void
    {
        $resource = (new ThreeDPrinterJobResource($job = factory('App\MachineJob')->create(['type' => MachineJobType::THREE_D_PRINTER])))->jsonSerialize();

        $this->assertArraySubset(['type' => '3dprinterjobs', 'id' => $job->uuid_text], $resource);
        $this->assertArraySubset(['links' => ['self' => \getenv('APP_URL') . '/api/threedprinterjobs/' . $job->uuid_text]], $resource);

        $this->assertArraySubset([
            'attributes' => [
                'name'       => $job->name,
                'job_id'     => $job->job_id,
                'status'     => $job->status,
                'duration'   => $job->duration,
                'started_at' => $job->started_at,
                'machine'    => $job->machine,
                'details'    => $job->details,
            ]
        ], $resource);

        $this->assertInstanceOf(Machine::class, $job->machine);
    }
}
