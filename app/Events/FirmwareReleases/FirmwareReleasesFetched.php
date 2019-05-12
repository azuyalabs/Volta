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

namespace App\Events\FirmwareReleases;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class handling the broadcasting events of 3D Printer firmware releases to the Dashboard
 *
 * @package App\Events\FirmwareReleases
 */
class FirmwareReleasesFetched implements ShouldBroadcast
{

    /**
     * @var array list containing all 3D Printer firmware release information
     */
    public $firmware_releases = [];

    /**
     * Constructor.
     *
     * @param array $firmware_releases list containing all 3D Printer firmware release information
     */
    public function __construct(array $firmware_releases)
    {
        $this->firmware_releases = $firmware_releases;
    }

    /**
     * Get the channel(s) the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('firmware_releases');
    }
}
