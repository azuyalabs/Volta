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

namespace App\Console;

use App\Console\Commands\SlicerProfilesCommand;
use App\Console\Components\FetchFirmwareReleases;
use App\Console\Components\FetchHolidays;
use App\Console\Components\FetchSlicerReleases;
use App\Console\Components\FetchWeather;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateDashboard::class,
        FetchHolidays::class,
        FetchFirmwareReleases::class,
        FetchSlicerReleases::class,
        FetchWeather::class,
        SlicerProfilesCommand::class,
        VersionCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('dashboard:holidays')->twiceDaily();
        $schedule->command('dashboard:firmwares')->twiceDaily();
        $schedule->command('dashboard:slicers')->twiceDaily();
        $schedule->command('dashboard:weather')->everyFifteenMinutes();
        $schedule->command('volta:vacuum')->weeklyOn(0);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
