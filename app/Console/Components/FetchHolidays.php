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

use DateTime;
use Exception;
use Yasumi\Yasumi;
use Yasumi\Holiday;
use App\UserProfile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Events\Holidays\HolidaysFetched;
use Yasumi\Filters\OfficialHolidaysFilter;

/**
 * Class for handling the fetching of public holidays.
 *
 * @package App\Console\Components
 */
class FetchHolidays extends Command
{
    /**
     * @var string The console command name
     */
    protected $signature = 'dashboard:holidays';

    /**
     * @var string The console command description
     */
    protected $description = 'Fetch the upcoming (official) holidays';

    /**
     * Execute the console command
     */
    public function handle(): void
    {
        // Get all unique countries from the registered user base
        $holidayProviders = UserProfile::all()->unique('country')->pluck('country')->toArray();

        try {
            foreach ($holidayProviders as $provider) {
                $holidays = Yasumi::createByISO3166_2($provider, (int)\date('Y'), 'en_US');
                $official = new OfficialHolidaysFilter($holidays->getIterator());

                $holidaysList = collect($official)->filter(static function (Holiday $holiday) {
                    return $holiday >= new DateTime();
                })->map(static function (Holiday $holiday) {
                    return [
                        'name' => $holiday->getName(),
                        'date' => $holiday->format(DateTime::ATOM)
                    ];
                })->slice(0, 5)->sortBy('date')->toArray();

                event(new HolidaysFetched($provider, \array_values($holidaysList)));

                Log::channel('dashboard')->info(formatLogMessage(\sprintf('Holidays for %s retrieved.', $provider), $this->signature), $holidaysList);
            }
        } catch (Exception $e) {
            Log::channel('dashboard')->error(formatLogMessage($e->getMessage(), $this->signature));
        }
    }
}
