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

use App\QueryOptions\MachineJobQueryOptions;
use App\Storage\BinaryUuid\HasBinaryUuid;
use DatePeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A machine job is performed by a machine
     *
     * @return BelongsTo
     */
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    /**
     * Scope the query for the given query options.
     *
     * @param  Builder $query
     * @param MachineJobQueryOptions $options
     *
     * @return Builder
     */
    public function scopeWithQueryOptions($query, MachineJobQueryOptions $options)
    {
        $this->whereType($query, $options)
            ->whereStatuses($query, $options)
            ->whereMachines($query, $options)
            ->whereStartDatePeriod($query, $options);
        return $query;
    }

    /**
     * Scope the query for the given start date period.
     *
     * @param  Builder $query
     * @param  MachineJobQueryOptions $options
     *
     * @return $this
     */
    protected function whereStartDatePeriod($query, MachineJobQueryOptions $options)
    {
        $query->when($options->start_date_period, static function ($query, DatePeriod $period) {
            return $query->whereBetween('started_at', [$period->getStartDate(), $period->getEndDate()]);
        });

        return $this;
    }

    /**
     * Scope the query for the given machine(s) (id's).
     *
     * @param  Builder $query
     * @param  MachineJobQueryOptions $options
     *
     * @return $this
     */
    protected function whereMachines($query, MachineJobQueryOptions $options)
    {
        $query->when($options->machines, static function ($query, $machines) {
            $column_name = 'machine_id';

            if (1 < count($machines)) {
                return $query->whereIn($column_name, $machines);
            }

            return $query->where($column_name, $machines);
        });

        return $this;
    }

    /**
     * Scope the query for the given type.
     *
     * @param  Builder $query
     * @param  MachineJobQueryOptions $options
     *
     * @return $this
     */
    protected function whereStatuses($query, MachineJobQueryOptions $options)
    {
        $query->when($options->statuses, static function ($query, $status) {
            $column_name = 'status';

            if (1 < count($status)) {
                return $query->whereIn($column_name, $status);
            }

            return $query->where($column_name, $status);
        });

        return $this;
    }

    /**
     * Scope the query for the given type.
     *
     * @param  Builder $query
     * @param  MachineJobQueryOptions $options
     *
     * @return $this
     */
    protected function whereType($query, MachineJobQueryOptions $options)
    {
        $query->when($options->type, static function ($query, $type) {
            return $query->where('type', $type);
        });

        return $this;
    }
}
