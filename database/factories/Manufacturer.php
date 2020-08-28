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

use App\Manufacturer;
use Faker\Generator as Faker;

$factory->define(Manufacturer::class, function (Faker $faker) {
    return [
        'name'               => $faker->company,
        'slug'               => $faker->slug,
        'country'            => $faker->countryCode,
        'website'            => $faker->url,
        'filament_supplier'  => $faker->boolean,
        'equipment_supplier' => $faker->boolean,
    ];
});
