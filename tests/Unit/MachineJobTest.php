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

namespace Tests\Feature;

use App\User;
use App\Machine;
use App\MachineJob;
use Tests\TestCase;

/**
 * Class containing cases for testing the Machine Job class.
 *
 * @package Tests\Unit
 */
class MachineJobTest extends TestCase
{
    /** @test */
    public function it_can_correctly_establish_the_job_id(): void
    {
        $job = factory(MachineJob::class)->create();

        $job_id = $job->job_id;

        $this->assertIsString($job_id);
        $this->assertSame(16, \strlen($job_id));
    }
}
