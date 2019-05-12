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

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class VoltaServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Blade::directive('moneyFormat', function ($value) {
            return "<?php echo money($value, auth()->user()->profile->currency ?? 'USD'); ?>";
        });

        Blade::directive('CurrencySymbol', function ($code) {
            return "<?php echo Punic\Currency::getSymbol({$code}); ?>";
        });

        Blade::directive('CurrencySymbol', function ($code) {
            return "<?php echo Punic\Currency::getSymbol({$code}); ?>";
        });

        $this->registerServices();
    }

    /**
     * Register the Volta services.
     *
     * @return void
     */
    protected function registerServices()
    {
        $services = [
            'Contracts\Repositories\WeatherRepository' => 'Repositories\OpenWeatherMapRepository',
            'Contracts\Repositories\FilamentSpoolRepository' => 'Repositories\FilamentSpoolRepository',
            'Contracts\Repositories\MachineJobRepository' => 'Repositories\MachineJobRepository'
        ];

        foreach ($services as $key => $value) {
            $this->app->singleton('App\\' . $key, 'App\\' . $value);
        }
    }

    public function boot()
    {
        view()->composer('*', function ($view) {
            $variables = [
                'locale' => auth()->user()->profile->language ?? 'en-US',
                'currency' => auth()->user()->profile->currency ?? 'USD',
                'country' => auth()->user()->profile->country ?? 'US',
                'city' => auth()->user()->profile->city ?? 'New York',
                'preferences' => auth()->user()->profile->preferences ?? [],
            ];

            if (app()->isLocal()) {
                $variables['local'] = true;
            }

            $view->with('voltaScriptVariables', $variables);

            app()->isLocal();
        });
    }
}
