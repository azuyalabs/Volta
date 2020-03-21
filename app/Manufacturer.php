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

use App\QueryOptions\ManufacturerQueryOptions;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Manufacturer
 *
 * @package App
 */
class Manufacturer extends Model
{
    use SoftDeletes;
    use Sluggable, SluggableScopeHelpers;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'manufacturers';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'country', 'website', 'filament_supplier', 'equipment_supplier'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Returns the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the route key for the model
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return $this->getSlugKeyName();
    }

    /**
     * Get the products for the manufacturer
     *
     * @return HasMany
     */
    public function models(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the spools for the manufacturer
     *
     * @return HasMany
     */
    public function spools(): HasMany
    {
        return $this->hasMany(FilamentSpool::class);
    }

    /**
     * Scope a query to only include manufacturers that are a filament supplier.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeIsFilamentSupplier($query): Builder
    {
        return $query->where('filament_supplier', true);
    }

    /**
     * Scope a query to only include manufacturers that are an equipment supplier.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeIsEquipmentSupplier($query): Builder
    {
        return $query->where('equipment_supplier', true);
    }

    /**
     * Scope the query for the given query options.
     *
     * @param Builder $query
     * @param ManufacturerQueryOptions $options
     *
     * @return Builder
     */
    public function scopeWithQueryOptions($query, ManufacturerQueryOptions $options)
    {
        /*$this->whereType($query, $options)
            ->whereStatuses($query, $options)
            ->whereMachines($query, $options)
            ->whereStartDatePeriod($query, $options);*/
        return $query;
    }
}
