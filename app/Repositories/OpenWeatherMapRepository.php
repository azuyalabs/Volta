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

namespace App\Repositories;

use App\Contracts\Repositories\WeatherRepository as Contract;
use Cmfcmf\OpenWeatherMap\CurrentWeather;
use DateTime;
use Exception;
use Gmopx\LaravelOWM\LaravelOWM;
use Illuminate\Support\Facades\Log;

/**
 * Class representing actions to retrieve weather information using the OpenWeatherMap service.
 *
 * @package App\Repositories
 */
class OpenWeatherMapRepository implements Contract
{
    /**
     * @var CurrentWeather Container for the current weather information
     */
    private $weather;

    /**
     * {@inheritdoc}
     */
    public function currentWeather($city): array
    {
        try {
            $this->weather = (new LaravelOWM())->getCurrentWeather($city, 'en', 'metric', true);

            return [
                'city'        => $this->weather->city->name,
                'state'       => $this->getState(),
                'temperature' => [
                    'value' => $this->weather->temperature->getValue(),
                    'uom'   => $this->weather->temperature->getUnit() === '&deg;C' ? 'celsius' : null,
                ],
                'humidity' => [
                    'value' => $this->weather->humidity->getValue(),
                    'uom'   => $this->weather->humidity->getUnit(),
                ],
                'windspeed' => [
                    'value' => $this->weather->wind->speed->getValue(),
                    'uom'   => $this->weather->wind->speed->getUnit(),
                ],
                'sun' => [
                    'rise' => $this->weather->sun->rise->format(DateTime::ATOM),
                    'set'  => $this->weather->sun->set->format(DateTime::ATOM),
                ]
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [];
        }
    }

    /**
     * Map the applicable state for the current weather
     *
     * @return string text indicating the current weather state
     */
    private function getState(): string
    {
        $map = [
            800 => 'clear',
            801 => 'partly_cloudy',
            802 => 'partly_cloudy',
            803 => 'cloudy',
            804 => 'cloudy',
            520 => 'light_rain',
            500 => 'light_rain',
            501 => 'moderate_rain',
            701 => 'fog',
            741 => 'fog'
        ];

        $map_breezy = [
            800 => 'breezy_and_clear',
            801 => 'breezy_and_partly_cloudy',
            802 => 'breezy_and_partly_cloudy',
            803 => 'breezy_and_cloudy',
            804 => 'breezy_and_cloudy',
            520 => 'breezy_and_light_rain',
            500 => 'breezy_and_light_rain',
            501 => 'breezy_and_moderate_rain',
            701 => 'fog',
            741 => 'fog',
        ];

        $map_windy = [
            800 => 'windy_and_clear',
            801 => 'windy_and_partly_cloudy',
            802 => 'windy_and_partly_cloudy',
            803 => 'breezy_and_cloudy',
            804 => 'breezy_and_cloudy',
            520 => 'windy_and_light_rain',
            500 => 'windy_and_light_rain',
            501 => 'windy_and_moderate_rain',
            701 => 'fog',
            741 => 'fog',
        ];


        if ($this->weather->wind->speed->getValue() <= 5) {
            return $map[$this->weather->weather->id] ?? 'unknown';
        }

        if ($this->weather->wind->speed->getValue() > 5 && $this->weather->wind->speed->getValue() < 10) {
            return $map_breezy[$this->weather->weather->id] ?? 'unknown';
        }

        if ($this->weather->wind->speed->getValue() >= 10) {
            return $map_windy[$this->weather->weather->id] ?? 'unknown';
        }

        return 'unknown';
    }
}
