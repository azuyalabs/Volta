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

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class representing the model for a User Profile.
 */
class UserProfile extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'user_profile';

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['currency', 'language', 'country', 'city', 'preferences'];

    /**
     * Get the user's preferences.
     *
     * Note: this accessor method is needed as the JSON extension for SQLite is not installed.
     *
     * @param string $value
     */
    public function getPreferencesAttribute($value): array
    {
        return json_decode($value, true);
    }

    /**
     * Get the user that the profile belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
