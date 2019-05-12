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

use App\Spool;
use Faker\Generator as Faker;

$factory->define(\App\SpoolCalibration::class, function (Faker $faker) {
    $type = ['linear_advance', 'diameter', 'extrusion'];

    $mType = $faker->randomElement($type);

    $measurements = '{}';
    if ($mType === 'linear_advance') {
        $measurements = '{"date": "' . $faker->dateTimeThisMonth()->format(DATE_ATOM) . '", "value": ' . $faker->numberBetween(
                10,
                80
            ) . '}';
    }

    return [
        'spool_id' => $faker->randomElement(Spool::all()->pluck('id')->all()),
        'calibrated_at' => '',
        'type' => $mType,
        'measurements' => $measurements
    ];
});
