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

namespace App;

use Illuminate\Support\Facades\Log;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Cache\Repository as Cache;

class Documentation
{
    /**
     * The filesystem implementation.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The cache implementation.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Create a new documentation instance.
     *
     * @param  Filesystem $files
     * @param  Cache $cache
     * @return void
     */
    public function __construct(Filesystem $files, Cache $cache)
    {
        $this->files = $files;
        $this->cache = $cache;
    }

    /**
     * Get the documentation index page.
     *
     * @return string|null
     */
    public function getIndex()
    {
        try {
            return $this->cache->remember('docs.index', 5, function () {
                $path = base_path('resources/docs/documentation.md');

                if ($this->files->exists($path)) {
                    return markdown($this->files->get($path));
                }

                return null;
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    /**
     * Get the given documentation page.
     *
     * @param  string $page
     * @return string|null
     */
    public function get($page)
    {
        try {
            return $this->cache->remember('docs.' . $page, 5, function () use ($page) {
                $path = base_path('resources/docs/' . $page . '.md');

                if ($this->files->exists($path)) {
                    return markdown($this->files->get($path));
                }

                return null;
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}
