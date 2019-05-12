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

namespace App\Contracts\Repositories;

/**
 * WeatherRepository interface
 *
 * @package App\Contracts\Repositories
 */
interface WeatherRepository
{
    /**
     * Get the current weather details for the given city.
     *
     * @param  string $city
     * @return array
     */
    public function currentWeather($city): array;
}
