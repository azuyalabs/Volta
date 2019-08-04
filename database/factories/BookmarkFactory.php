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
use App\Machine;
use App\Product;
use App\Bookmark;
use App\FilamentSpool;
use Faker\Generator as Faker;

$factory->define(Bookmark::class, static function (Faker $faker) {
    $user_id = $faker->randomElement(User::all()->pluck('id')->toArray());

    $model = $faker->randomElement([FilamentSpool::class, Machine::class]);

    return [
        'user_id'           => $user_id,
        'bookmarkable_id'   => $faker->randomElement($model::has('user')->pluck('id')->toArray()),
        'bookmarkable_type' => $faker->randomElement([FilamentSpool::class, Product::class, Machine::class]),
    ];
});
