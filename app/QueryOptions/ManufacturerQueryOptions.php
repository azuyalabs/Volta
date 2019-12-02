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

namespace App\QueryOptions;

use DatePeriod;

/**
 * Class representing Query Options for the Manufacturer Repository
 *
 * @package App\QueryOptions
 */
class ManufacturerQueryOptions
{
    /**
     * The statuses that must be associated to the retrieved machine jobs.
     *
     * @var array
     */
    public $statuses;

    /**
     * The type that must belong to the retrieved machine jobs.
     *
     * @var string
     */
    public $type;

    /**
     * The machines that must be associated to the retrieved machine jobs.
     *
     * @var array
     */
    public $machines;

    /**
     * The date period for the start date that must be associated to the retrieved machine jobs.
     *
     * @var DatePeriod
     */
    public $start_date_period;

    /**
     * Set the statuses that must be associated to the retrieved machine jobs.
     *
     * @param  array $statuses
     * @return $this
     */
    public function statuses(?array $statuses)
    {
        $this->statuses = $statuses;

        return $this;
    }

    /**
     * Set the type that must belong to the retrieved machine jobs.
     *
     * @param  string $type
     * @return $this
     */
    public function type(?string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the machines (id's) that must belong to the retrieved machine jobs.
     *
     * @param  array $machines
     * @return $this
     */
    public function machines(?array $machines)
    {
        $this->machines = $machines;

        return $this;
    }

    /**
     * Set the date range for the start date that must belong to the retrieved machine jobs.
     *
     * @param  DatePeriod $start_date_period
     *
     * @return $this
     */
    public function start_date_period(?DatePeriod $start_date_period)
    {
        $this->start_date_period = $start_date_period;

        return $this;
    }
}
