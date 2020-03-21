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

use App\Machine;
use App\Manufacturer;
use App\Policies\MachinePolicy;
use App\Policies\ManufacturerPolicy;
use App\Policies\ProductPolicy;
use App\Product;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model'         => 'App\Policies\ModelPolicy',
        Machine::class      => MachinePolicy::class,
        Manufacturer::class => ManufacturerPolicy::class,
        Product::class      => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::routes();

        // Implicitly grant "Admin" role all permissions
        Gate::before(static function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });
    }
}
