<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    public function bookmarkable()
    {
        return $this->morphTo();
    }
}
