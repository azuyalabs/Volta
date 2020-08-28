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

class SpoolCalibration extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'spool_calibrations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'spool_id',
        'calibrated_at',
        'type',
        'measurements',
    ];

    public function spool()
    {
        return $this->belongsTo(FilamentSpool::class);
    }
}
