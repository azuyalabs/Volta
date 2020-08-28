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

namespace App\Events\SlicerReleases;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class handling the broadcasting events of 3D Printer Slicer software releases to the Dashboard.
 */
class SlicerReleasesFetched implements ShouldBroadcast
{
    /**
     * @var array list containing all 3D Printer Slicer software release information
     */
    public $slicer_releases = [];

    /**
     * Constructor.
     *
     * @param array $slicer_releases list containing all 3D Printer Slicer software release information
     */
    public function __construct(array $slicer_releases)
    {
        $this->slicer_releases = $slicer_releases;
    }

    /**
     * Get the channel(s) the event should broadcast on.
     *
     * @return array|Channel
     */
    public function broadcastOn()
    {
        return new Channel('slicer_releases');
    }
}
