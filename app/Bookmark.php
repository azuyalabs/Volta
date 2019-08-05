<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Bookmark extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id'];

    /**
     * Get the owning bookmarkable model.
     */
    public function bookmarkable(): MorphTo
    {
        return $this->morphTo();
    }
}
