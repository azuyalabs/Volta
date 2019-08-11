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

namespace App\Events;

use App\User;
use App\Bookmark;
use Illuminate\Queue\SerializesModels;

class BookmarkCreated
{
    use SerializesModels;

    public $bookmark;
    public $user;

    /**
     * Create a new event instance.
     *
     * @param Bookmark $bookmark
     * @return void
     */
    public function __construct(Bookmark $bookmark, User $user)
    {
        $this->bookmark = $bookmark;
        $this->user     = $user;
    }
}
