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

namespace App\Traits;

use App\User;
use App\Bookmark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Bookmarkable
{
    /**
     * Get all of the model's bookmarks.
     *
     * @return MorphMany
     */
    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    /**
     * Determine if the model is bookmarked by the given user.
     *
     * @param User $user
     *
     * @return bool
     */
    public function isBookmarkedBy(User $user): bool
    {
        return $this->bookmarks()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Scope a query to instances bookmarked by the given user.
     *
     * @param Builder $query
     * @param User $user
     *
     * @return Builder
     */
    public function scopeBookmarkedBy($query, User $user): Builder
    {
        return $query->whereHas('bookmarks', static function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    /**
     * Have the authenticated user bookmark the model.
     *
     * If the authenticated user already have bookmarked the model, the model instance
     * will be un-bookmarked.
     *
     * @return void
     */
    public function bookmark(): void
    {
        if ($this->isBookmarkedBy(Auth::user())) {
            $this->bookmarks()->where('user_id', Auth::user()->id)->delete();
        } else {
            $this->bookmarks()->save(
                new Bookmark(['user_id' => Auth::user()->id])
            );
        }
    }
}