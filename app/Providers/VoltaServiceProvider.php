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

namespace App\Providers;

use App\Storage\BinaryUuid\MySqlGrammar;
use App\Storage\BinaryUuid\SQLiteGrammar;
use Exception;
use Illuminate\Database\Connection;
use Illuminate\Database\Query\Grammars\MySqlGrammar as IlluminateMySqlGrammar;
use Illuminate\Database\Query\Grammars\SQLiteGrammar as IlluminateSQLiteGrammar;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use RuntimeException;

class VoltaServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerServices();
    }

    /**
     * Register the Volta services.
     */
    protected function registerServices(): void
    {
        $services = [
            'Contracts\Repositories\WeatherRepository'       => 'Repositories\OpenWeatherMapRepository',
            'Contracts\Repositories\FilamentSpoolRepository' => 'Repositories\FilamentSpoolRepository',
            'Contracts\Repositories\MachineJobRepository'    => 'Repositories\MachineJobRepository',
            'Contracts\Repositories\ManufacturerRepository'  => 'Repositories\ManufacturerRepository',
        ];

        foreach ($services as $key => $value) {
            $this->app->singleton('App\\'.$key, 'App\\'.$value);
        }
    }

    /**
     * Register custom Blade directives.
     */
    protected function registerBladeDirectives(): void
    {
        Blade::directive('moneyFormat', static function ($value) {
            return "<?php echo money($value, auth()->user()->profile->currency ?? 'USD'); ?>";
        });

        Blade::directive('CurrencySymbol', static function ($code) {
            return "<?php echo Punic\Currency::getSymbol({$code}); ?>";
        });

        Blade::directive('CurrencySymbol', static function ($code) {
            return "<?php echo Punic\Currency::getSymbol({$code}); ?>";
        });
    }

    public function boot(): void
    {
        $this->registerBladeDirectives();

        // Inject all views with custom variables
        view()->composer('*', static function ($view) {
            $variables = [
                'locale'      => auth()->user()->profile->language ?? 'en-US',
                'currency'    => auth()->user()->profile->currency ?? 'USD',
                'country'     => auth()->user()->profile->country ?? 'US',
                'city'        => auth()->user()->profile->city ?? 'New York',
                'preferences' => auth()->user()->profile->preferences ?? [],
            ];

            if (app()->isLocal()) {
                $variables['local'] = true;
            }

            $view->with('voltaScriptVariables', $variables);

            app()->isLocal();
        });

        // Allow database/models for Binary UUID
        /* @var Connection $connection */
        try {
            $connection = app('db')->connection();
            $connection->setSchemaGrammar($this->createGrammarFromConnection($connection));
            $this->optimizeUuids();
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Set the UUID factory to use optimize UUID's.
     */
    protected function optimizeUuids(): void
    {
        $factory = new UuidFactory();
        $codec   = new OrderedTimeCodec($factory->getUuidBuilder());
        $factory->setCodec($codec);
        Uuid::setFactory($factory);
    }

    /**
     * Determines the proper SQL Grammar from the provided connection instance.
     *
     * @param Connection $connection Database connection instance
     *
     * @return SQLiteGrammar|MySqlGrammar
     *
     * @throws Exception
     */
    protected function createGrammarFromConnection(Connection $connection): Grammar
    {
        $queryGrammar      = $connection->getQueryGrammar();
        $queryGrammarClass = get_class($queryGrammar);
        if (!in_array($queryGrammarClass, [
            IlluminateMySqlGrammar::class,
            IlluminateSQLiteGrammar::class,
        ], true)) {
            throw new RuntimeException("There current grammar `$queryGrammarClass` doesn't support binary uuids. Only  MySql and SQLite connections are supported.");
        }
        if ($queryGrammar instanceof IlluminateSQLiteGrammar) {
            $grammar = new SQLiteGrammar();
        } else {
            $grammar = new MySqlGrammar();
        }
        $grammar->setTablePrefix($queryGrammar->getTablePrefix());

        return $grammar;
    }
}
