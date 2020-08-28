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

use Faker\Generator as Faker;
use Spatie\ModelStatus\Status;

$factory->define(Status::class, function (Faker $faker) {
    return [
        'name'       => $faker->randomElement(['printing', 'offline', 'finishing', 'cancelling', 'resuming']),
        'model_type' => $faker->randomElement(['App\Machine', 'App\FilamentSpool']),
        'model_id'   => $faker->numberBetween(1, 1000),
    ];
});
