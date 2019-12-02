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

namespace App\Console\Components;

use Carbon\Carbon;
use App\Services\GitHubApi;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Events\FirmwareReleases\FirmwareReleasesFetched;

/**
 * Class for getting the latest release version of major 3D printer firmwares.
 *
 * @package App\Console\Components
 */
class FetchFirmwareReleases extends Command
{
    /**
     * @var string The console command name
     */
    protected $signature = 'dashboard:firmwares';

    /**
     * @var string The console command description
     */
    protected $description = 'Fetch latest release version of major 3D printer firmwares.';

    /**
     * Execute the console command
     */
    public function handle(): void
    {
        $client = new GitHubApi();

        $releasesList[] = $client->fetchLatestRelease('MarlinFirmware', 'Marlin');
        $releasesList[] = $client->fetchLatestRelease('gnea', 'grbl', null, static function ($version) {
            preg_match_all('/^[v](\d{1,2})[.](.{1,3})[.]\w+$/', $version, $matches);
            return $matches[1][0] . '.' . $matches[2][0];
        });
        $releasesList[] = $client->fetchLatestRelease('repetier', 'Repetier-Firmware', 'Repetier');
        $releasesList[] = $client->fetchLatestRelease('prusa3d', 'Prusa-Firmware', 'Prusa MK3', static function ($version) {
            return substr($version, 1);
        });

        // Sort the releases with the newest one first
        $releasesList = array_reverse(array_values(Arr::sort($releasesList, static function ($value) {
            return new Carbon($value['release_date']);
        })));

        // Broadcast (and log) the result
        Log::channel('dashboard')->info(formatLogMessage('latest releases retrieved', $this->signature), $releasesList);
        event(new FirmwareReleasesFetched($releasesList));
    }
}
