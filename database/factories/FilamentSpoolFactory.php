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
use App\Manufacturer;
use App\FilamentSpool;
use Faker\Generator as Faker;

$factory->define(FilamentSpool::class, function (Faker $faker) {
    $material = $faker->randomElement(['pla', 'abs', 'pet']);
    $color = $faker->colorName;
    $manufacturers = Manufacturer::IsFilamentSupplier()->get();

    $weight = $faker->numberBetween(500, 3000);
    $diameter = $faker->randomElement([1.75, 2.85, 2.90, 3.00]);
    $density = $faker->randomElement([1.04, 1.05, 1.25, 1.24, 1.30]);

    return [
        'name' => $faker->randomElement($manufacturers->pluck('name')->all()) . ' ' . $color . ' ' . \strtoupper($material),
        'material' => $material,
        'purchase_price' => $faker->numberBetween(10000, 70000),
        'weight' => $weight,
        'diameter' => $diameter,
        'density' => $density,
        'color' => $color,
        'color_value' => $faker->hexColor,
        'usage' => $faker->randomFloat(2, 1, ($weight / $density) / (M_PI * (($diameter / 2) ** 2))),

        'user_id' => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'manufacturer_id' => $faker->randomElement($manufacturers->pluck('id')->all()),
    ];
});
