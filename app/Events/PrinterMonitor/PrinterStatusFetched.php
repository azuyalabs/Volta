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

namespace App\Events\PrinterMonitor;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrinterStatusFetched implements ShouldBroadcast
{
    public $status;

    /**
     * Create a new event instance.
     */
    public function __construct(array $status)
    {
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array|Channel
     */
    public function broadcastOn()
    {
        return new Channel('printer.'.$this->status['id']);
    }
}
