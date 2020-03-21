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

use App\Manufacturer;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $class = ['machine', 'filament'];

    return [
        'name'            => $faker->domainWord,
        'slug'            => $faker->slug,
        'class'           => $faker->randomElement($class),
        'manufacturer_id' => $faker->randomElement(Manufacturer::all()->pluck('id')->all()),
    ];
});
