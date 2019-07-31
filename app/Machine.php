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

use Cknow\Money\Money;
use App\Traits\Monetary;
use Spatie\ModelStatus\HasStatuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class representing the model for a Machine (e.g. 3D Printer, Laser Cutter, etc.).
 *
 * @package App
 */
class Machine extends Model
{
    use SoftDeletes;
    use Monetary;
    use HasStatuses;

    public $money_attributes = [
        'acquisition_cost', 'residual_value', 'maintenance_cost'
    ];

    /**
     * @inheritdoc
     */
    protected $table = 'machines';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'user_id',
        'model_id',
        'name',
        'acquisition_cost',
        'residual_value',
        'maintenance_cost',
        'lifespan',
        'operating_hours',
        'energy_consumption',
        'reference_id'
    ];

    /**
     * @inheritdoc
     */
    protected $appends = [
        'hourlyrate'
    ];

    /**
     * @inheritdoc
     */
    protected $dates = ['deleted_at'];

    /**
     * @inheritdoc
     */
    protected $casts = ['user_id' => 'int'];

    /**
     * Get the user that the machine belongs to.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product model that the machine belongs to.
     *
     * @return BelongsTo
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get my machines
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeMine($query): Builder
    {
        return $query->whereUserId(auth()->user()->id);
    }

    /**
     * Get all my machines that are paired (i.e. having an external reference ID)
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeMyPaired($query): Builder
    {
        return $query->mine()->where('reference_id', '<>', '');
    }

    /**
     * Calculates the hourly cost rate of this machine.
     *
     * @return Money
     */
    public function getHourlyRateAttribute(): Money
    {
        $rate = $this->getLifetimeCostAttribute();

        $rate = $rate->divide($this->lifespan); // Division by zero is handled by the Money class
        $rate = $rate->divide($this->operating_hours); // Division by zero is handled by the Money class

        return $rate;
    }

    /**
     * Calculates the total cost of this machine during its life.
     *
     * @return Money
     */
    public function getLifetimeCostAttribute(): Money
    {
        return $this->acquisition_cost->subtract($this->residual_value)->add($this->maintenance_cost);
    }
}
