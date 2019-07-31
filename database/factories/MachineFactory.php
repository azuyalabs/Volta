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

use App\User;
use App\Product;
use Money\Currency;
use Cknow\Money\Money;
use Faker\Generator as Faker;

$factory->define(\App\Machine::class, function (Faker $faker) {
    $products = Product::where('class', 'machine')->get();
    $product_models = $products->pluck('name', 'id')->all();
    $product_model_id = $faker->randomElement(\array_keys($product_models));
    $user_id = $faker->randomElement(User::all()->pluck('id')->toArray());

    // Retrieve the subunit Number of the Currency assigned to the User account
    $user = User::find($user_id);
    $currencies = Money::getCurrencies();

    // Stored currencies aren't always registered with the Money library. In such case
    // default the subUnits to 2.
    try {
        $subUnit = $currencies->subunitFor(new Currency($user->profile->currency));
    } catch (Exception $e) {
        $subUnit = 2;
    }

    $ratio = 10 ** $subUnit;

    return [
        'user_id' => $user_id,
        'model_id' => $product_model_id,
        'reference_id' => null,
        'name' => $product_models[$product_model_id],
        'acquisition_cost' => $faker->numberBetween($ratio, 10000 * $ratio),
        'residual_value' => $faker->numberBetween($ratio, 1000 * $ratio),
        'maintenance_cost' => $faker->numberBetween($ratio, 4000 * $ratio),
        'lifespan' => $faker->numberBetween(1, 15),
        'operating_hours' => $faker->numberBetween(100, 1500),
        'energy_consumption' => $faker->numberBetween(20, 500),
    ];
});
