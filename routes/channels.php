<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::routes();

/*
Broadcast::channel('printer.{printer}', function ($user, $printer) {
    return false;
});
*/

/*
 * Channel where upcoming holidays are published to.
 *
 * Each provider (i.e. country) will have it's own channel.
 * Any user is allowed to listen to this channel.
 */
Broadcast::channel('holidays.*', function () {
    return true;
});

Broadcast::channel('dashboard', function (User $user) {
    return true;
});

Broadcast::channel('printer.*', function (User $user) {
    return true;
});
