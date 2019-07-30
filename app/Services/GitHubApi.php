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

namespace App\Services;

use Carbon\Carbon;
use Github\Client;
use Predis\Client as PredisClient;
use Illuminate\Support\Facades\Log;
use Github\Exception\RuntimeException;
use Cache\Adapter\Predis\PredisCachePool;

/**
 * Class containing convenience methods for interacting with the Github API.
 *
 * @package App\Services
 */
class GitHubApi
{
    /**
     * @var \Github\Client Github Client instance
     */
    private $client;

    /**
     * GitHubApi constructor.
     *
     * A Github Client is instantiated with caching enabled.
     */
    public function __construct()
    {
        $redisClient = new PredisClient([
            'scheme' => 'tcp',
            'host' => config('database.redis.default.host'),
            'port' => config('database.redis.default.port'),
        ]);

        $pool = new PredisCachePool($redisClient);

        $this->client = new Client();
        $this->client->addCache($pool);
    }

    /**
     * Fetch the latest releases of a Github repository
     *
     * @param string $userName the Github username
     * @param string $repoName the Github repository name belonging to the user
     * @param string|null $friendlyName an optional friendly name for the repository
     * @param callable|null $callback an optional callback function to process the version number (not all repositories adhere to the semver standard).
     *
     * @return array structure containing the latest release version number, the release date and the (friendly) repository name
     */
    public function fetchLatestRelease(string $userName, string $repoName, string $friendlyName = null, callable $callback = null): array
    {
        try {
            $release = $this->client->repo()->releases()->latest($userName, $repoName);

            // Execute callback function to allow for customized version string
            return [
                'name' => $friendlyName ?? $repoName,
                'version' => \is_callable($callback) ? $callback(\trim($release['tag_name'])) : \trim($release['tag_name']),
                'release_date' => (new Carbon(\trim($release['published_at'])))->toIso8601String(),
            ];
        } catch (RuntimeException $e) {

            // Alternatively, try to find the latest release based on the repository tags
            if ('Not Found' === $e->getMessage()) {
                $tags = $this->client->repo()->tags($userName, $repoName);

                // Get the tag with the highest numerical value (assuming most maintainers apply a semver pattern)
                $lastTag = collect($tags)->sortBy(static function ($item) {
                    \preg_match_all('/(\d{1,6})/m', $item['name'], $matches);
                    return \implode('.', $matches[0]);
                })->last();

                // Need to make a second API call to retrieve the date associated with this tag's commit
                $tagCommit = $this->client->repo()->commits()->show($userName, $repoName, $lastTag['commit']['sha']);

                return [
                    'name' => $friendlyName ?? $repoName,
                    'version' => $lastTag['name'],
                    'release_date' => (new Carbon(\trim($tagCommit['commit']['author']['date'])))->toIso8601String(),
                ];
            }
            Log::error($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return [
            'name' => null,
            'version' => null,
            'release_date' => null,
        ];
    }
}
