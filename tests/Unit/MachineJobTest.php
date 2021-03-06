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

namespace Tests\Feature;

use App\MachineJob;
use Tests\TestCase;

/**
 * Class containing cases for testing the Machine Job class.
 *
 * @internal
 * @coversNothing
 */
class MachineJobTest extends TestCase
{
    /** @test */
    public function itCanCorrectlyEstablishTheJobId(): void
    {
        $job = factory(MachineJob::class)->create();

        $job_id = $job->job_id;

        $this->assertIsString($job_id);
        $this->assertSame(16, strlen($job_id));
    }
}
