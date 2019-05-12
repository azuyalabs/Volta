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

use Cknow\Money\Money;
use Faker\Generator as Faker;

$factory->define(\App\UserProfile::class, function (Faker $faker) {
    $preferences['dashboard']['clock']['type'] = $faker->randomElement(['analog', 'digital']);
    $preferences['dashboard']['weather']['system_of_measure'] = $faker->randomElement(['metric', 'imperial']);

    return [
        'currency' => $faker->randomElement(Money::getCurrencies()),
        'language' => $faker->randomElement(['en-US', 'ja-JP']),
        'country' => $faker->countryCode,
        'city' => $faker->city,
        'preferences' => \json_encode($preferences),
    ];
});
