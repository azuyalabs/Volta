<?php

namespace App\Listeners;

use App\Events\BookmarkCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class BookmarkLogger
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BookmarkCreated $event
     * @return void
     */
    public function handle(BookmarkCreated $event): void
    {
        Log::info('User '.$event->user->name . ' - '.$event->bookmark->bookmarkable->name);
    }
}
