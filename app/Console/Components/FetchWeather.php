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

namespace App\Console\Components;

use App\UserProfile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Events\Weather\WeatherFetched;
use App\Contracts\Repositories\WeatherRepository;

/**
 * Class for handling the retrieval of weather data.
 *
 * @package App\Console\Components
 */
class FetchWeather extends Command
{
    /**
     * @var string The console command name
     */
    protected $signature = 'dashboard:weather';

    /**
     * @var string The console command description
     */
    protected $description = 'Fetch the current weather forecast';

    /**
     * Execute the console command
     */
    public function handle(): void
    {
        // Get all unique cities from the registered user base
        $cityList = UserProfile::all()->unique('city')->filter(static function ($value) {
            return !\is_null($value->city);
        })->pluck('city')->toArray();

        foreach ($cityList as $city) {
            $weather = (app(WeatherRepository::class)->currentWeather($city));

            event(new WeatherFetched($city, $weather));
            Log::channel('dashboard')->info(formatLogMessage(\sprintf('Weather for %s retrieved.', $city), $this->signature), $weather);
        }
    }
}
