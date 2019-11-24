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

use Cknow\Money\Money;
use Illuminate\Support\Str;

/**
 * A trait to have monetary Eloquent attributes
 *
 * @package App\Traits
 */
trait Monetary
{

    /**
     * Get the value of the given model attribute
     *
     * @param string $key the name of the model attribute
     * @return Money the value of the model attribute representation as a Money object.
     */
    public function getAttributeValue($key)
    {
        // Pass attributes that are not Money representatives to the parent method.
        if (!$this->isMoneyAttribute($key)) {
            return parent::getAttributeValue($key);
        }

        $monetary_value = Money::{$this->getCurrency()}($this->getAttributes()[$key]);

        if ($this->hasGetMutator($key)) {
            return $this->mutateAttribute($key, $monetary_value);
        }

        return $monetary_value;
    }

    /**
     * Check if the model attribute is set for a Money representation
     *
     * @param string $key the model attribute
     * @return bool true if the model attribute is set for a Money representation, false otherwise
     */
    private function isMoneyAttribute(string $key): bool
    {
        return in_array($key, $this->money_attributes);
    }

    /**
     * Get the currency of the authenticated user.
     *
     * If no currency can be obtained, the US Dollar currency will serve as fallback.
     *
     * @return string the currency (code)
     */
    private function getCurrency(): string
    {
        return auth()->user()->profile->currency ?? 'USD';
    }

    /**
     * Sets the value for the given model attribute
     *
     * @param string $key the name of the model attribute
     * @param number $value the (new) value to be set for the model attribute
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        // Pass attributes that are not Money representations to the parent method.
        if (!$this->isMoneyAttribute($key)) {
            return parent::setAttribute($key, $value);
        }

        $numeric_value = Money::parseByDecimal((string)$value, $this->getCurrency())->getAmount();

        if ($this->hasSetMutator($key)) {
            $method = 'set' . Str::studly($key) . 'Attribute';
            $this->{$method}($value);
            $numeric_value = $this->attributes[$key];
        }

        return parent::setAttribute($key, $numeric_value);
    }
}
