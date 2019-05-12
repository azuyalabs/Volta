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
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use App\Events\SlicerReleases\SlicerReleasesFetched;

/**
 * Class for getting the latest release version of major 3D printer Slicer applications.
 *
 * @package App\Console\Components
 */
class FetchSlicerReleases extends Command
{
    /**
     * @var string The console command name
     */
    protected $signature = 'dashboard:slicers';

    /**
     * @var string The console command description
     */
    protected $description = 'Fetch latest release version of major 3D slicer applications.';

    /**
     * Execute the console command
     */
    public function handle(): void
    {
        $client = new GitHubApi();

        $releasesList[] = $client->fetchLatestRelease('alexrj', 'Slic3r');
        $releasesList[] = $client->fetchLatestRelease('Ultimaker', 'Cura');

        $releasesList[] = $client->fetchLatestRelease('prusa3d', 'Slic3r', 'Slic3rPE', function ($version) {
            $prefix = 'version_';
            return (\strpos($version, $prefix) === 0) ? \substr($version, \strlen($prefix)) : $version;
        });
        $releasesList[] = $this->getSimplify3DRelease();

        // Sort the releases with the newest one first
        $releasesList = \array_reverse(\array_values(Arr::sort($releasesList, function ($value) {
            return new Carbon($value['release_date']);
        })));

        // Broadcast (and log) the result
        Log::channel('dashboard')->info(formatLogMessage('latest releases retrieved', $this->signature), $releasesList);
        event(new SlicerReleasesFetched($releasesList));
    }

    /**
     * Get the latest release information of Simplify3D
     *
     * Note: Since Simplify3D is proprietary software, release information returned here is
     * based on public release information.
     *
     * @return array release information of Simplify3D
     */
    private function getSimplify3DRelease()
    {
        return [
            'name' => 'Simplify3D',
            'version' => '4.1.0',
            'release_date' => '2018-11-06'
        ];
    }
}