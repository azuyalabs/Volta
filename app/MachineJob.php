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

namespace App;

use Spatie\BinaryUuid\HasBinaryUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class representing the model for a Machine Job.
 *
 * @property string $uuid_text
 *
 * @package App
 */
class MachineJob extends Model
{
    use HasBinaryUuid;
    use SoftDeletes;

    /**
     * @inheritdoc
     */
    protected $table = 'machine_jobs';

    /**
     * @inheritdoc
     */
    protected $casts = ['user_id' => 'int', 'machine_id' => 'int', 'status' => 'string', 'duration' => 'int', 'start_at' => 'DateTime', 'job_id' => 'string'];

    /**
     * @inheritdoc
     */
    protected $hidden = ['user_id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @inheritdoc
     */
    protected $fillable = ['name', 'status', 'duration', 'user_id', 'machine_id', 'started_at', 'type', 'job_id', 'details'];

    /**
     * A machine job is owned by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A machine job is performed by a machine
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
