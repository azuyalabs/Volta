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

namespace App\Console;

use Illuminate\Console\Command;

/**
 * Class that handles updating the entire dashboard (all components/widgets)
 *
 * @package App\Console
 */
class UpdateDashboard extends Command
{
    /**
     * @var string The console command name
     */
    protected $signature = 'dashboard:update';

    /**
     * @var string The console command description
     */
    protected $description = 'Update all components/widgets displayed on the dashboards';

    /**
     * Execute the console command
     */
    public function handle(): void
    {
        $this->call('dashboard:holidays');
        $this->call('dashboard:firmwares');
        $this->call('dashboard:slicers');
        $this->call('dashboard:weather');
    }
}
