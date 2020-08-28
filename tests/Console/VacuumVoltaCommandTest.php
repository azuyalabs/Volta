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

namespace Tests\Console;

use Tests\TestCase;

/**
 * Class for testing the volta:vacuum console command.
 */
class VacuumVoltaCommandTest extends TestCase
{
    /**
     * The name of the command.
     */
    private const CONSOLE_COMMAND = 'volta:vacuum';

    /** @test */
    public function it_can_prune_stale_statuses(): void
    {
        $this->artisan(self::CONSOLE_COMMAND)->expectsOutput('Database vacuumed.');
    }
}
