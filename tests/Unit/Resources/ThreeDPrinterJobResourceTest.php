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

use App\Http\Resources\ThreeDPrinterJobResource;
use App\Machine;
use App\MachineJob;
use App\MachineJobType;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Tests\TestCase;

/**
 * Class containing cases for testing the 3D Printer Job Resource class.
 *
 * @internal
 * @coversNothing
 */
class ThreeDPrinterJobResourceTest extends TestCase
{
    use ArraySubsetAsserts;

    /** @test
     *
     * @throws \Exception
     */
    public function itCanReturnACorrectResponse(): void
    {
        $resource = (new ThreeDPrinterJobResource($job = factory(MachineJob::class)->create(['type' => MachineJobType::THREE_D_PRINTER])))->jsonSerialize();

        self::assertArraySubset(['type' => '3dprinterjobs', 'id' => $job->uuid_text], $resource);
        self::assertArraySubset(['links' => ['self' => getenv('APP_URL').'/api/threedprinterjobs/'.$job->uuid_text]], $resource);

        self::assertArraySubset([
            'attributes' => [
                'name'       => $job->name,
                'job_id'     => $job->job_id,
                'status'     => $job->status,
                'duration'   => $job->duration,
                'started_at' => $job->started_at,
                'machine'    => $job->machine,
                'details'    => $job->details,
            ],
        ], $resource);

        $this->assertInstanceOf(Machine::class, $job->machine);
    }
}
