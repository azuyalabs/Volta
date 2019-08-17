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

namespace Tests\Console;

use Tests\TestCase;
use Spatie\ModelStatus\Status;
use Illuminate\Support\Facades\DB;

/**
 * Class for testing the volta:prune console command
 *
 * @package Tests\Console
 */
class OptimizeVoltaCommandTest extends TestCase
{
    /**
     * The name of the optimize command
     */
    private const OPTIMIZE_COMMAND = 'volta:optimize';

    /** @test */
    public function it_can_prune_stale_statuses(): void: void
    {
        $samples = 100;
        factory(Status::class, $samples)->create();

        $this->assertSame($samples, Status::query()->count());
        $this->assertSame($samples, DB::table('statuses')->count());

        $this->artisan(self::OPTIMIZE_COMMAND)->expectsOutput('Old model statuses pruned.');

        $unique_models = DB::table('statuses')->distinct()->count('model_id');
        $row_count     = DB::table('statuses')->count();

        $this->assertSame($row_count, Status::query()->count());
        $this->assertSame($unique_models, $row_count);
    }

    /** @test */
    public function it_can_vacuum_the_database(): void: void
    {
        $this->artisan(self::OPTIMIZE_COMMAND)->expectsOutput('Database vacuumed.');
    }
}
