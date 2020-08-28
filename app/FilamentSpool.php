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

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use UnexpectedValueException;

/**
 * Class representing the model for a Filament Spool.
 */
class FilamentSpool extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'filament_spools';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'material',
        'purchase_price',
        'weight',
        'diameter',
        'density',
        'usage',
        'color',
        'color_value',
        'user_id',
        'manufacturer_id',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = ['user_id', 'created_at', 'updated_at'];

    /**
     * {@inheritdoc}
     */
    protected $casts = ['user_id' => 'int', 'usage' => 'float'];

    /**
     * A filament spool is owned by a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A filament spool is made by a manufacturer (supplier).
     */
    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    /**
     * Get the length (in meters) of the filament on this spool.
     */
    public function getLengthAttribute(): float
    {
        if (0 === $this->density || 0 === $this->diameter) {
            throw new UnexpectedValueException('Density can not be zero.');
        }

        return $this->attributes['length'] = ($this->weight / $this->density) / (M_PI * (($this->diameter / 2) ** 2));
    }

    /**
     * Get the weight equivalent (gram) price for this spool.
     */
    public function getPricePerWeightAttribute(): Money
    {
        return Money::JPY($this->purchase_price)->divide($this->weight);
    }

    /**
     * Get the kilogram equivalent price for this spool.
     *
     * Some manufacturers supply filament spools in quantities other than 1000 gram.
     */
    public function getPricePerKilogramAttribute(): Money
    {
        if (0 === $this->weight) {
            throw new UnexpectedValueException('Weight can not be zero.');
        }

        return Money::JPY($this->purchase_price)->multiply(1000 / $this->weight);
    }

    /**
     * Get the length equivalent (meter) price for this spool.
     */
    public function getPricePerLengthAttribute(): Money
    {
        return Money::JPY($this->purchase_price)->divide($this->length);
    }

    /**
     * Get the volume equivalent (cm3) price for this spool.
     */
    public function getPricePerVolumeAttribute(): Money
    {
        return Money::JPY($this->purchase_price)->divide($this->weight / $this->density);
    }

    /**
     * Mark a filament spool as empty (i.e. all filament has been used).
     */
    public function markAsEmpty(): void
    {
        $this->usage = $this->length;
    }

    /**
     * Is this filament spool empty?
     */
    public function isEmpty(): bool
    {
        return $this->usage === $this->length;
    }
}
