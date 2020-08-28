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

namespace App\Events\Holidays;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class handling the broadcasting events of national holidays to the Dashboard.
 */
class HolidaysFetched implements ShouldBroadcast
{
    /**
     * @var array list containing all holidays
     */
    public $holidays;

    /**
     * @var string code of the holiday provider (i.e. country code)
     */
    public $provider;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $provider, array $holidays)
    {
        $this->provider = $provider;
        $this->holidays = $holidays;
    }

    /**
     * Get the channel(s) the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('holidays.'.$this->provider);
    }
}
