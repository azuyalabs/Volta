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

use App\Machine;
use App\MachineJobStatus;
use App\MachineJobType;
use App\User;
use Faker\Generator as Faker;

$factory->define(\App\MachineJob::class, function (Faker $faker) {
    return [
        'job_id'     => $faker->ean13.'abc',
        'user_id'    => $faker->randomElement(User::all()->pluck('id')->toArray()),
        'machine_id' => $faker->randomElement(Machine::all()->pluck('id')->toArray()),
        'name'       => $faker->word . '.' . $faker->lexify('???'),
        'status'     => $faker->randomElement([MachineJobStatus::SUCCESS, MachineJobStatus::FAILED]),
        'duration'   => $faker->numberBetween(0, 100000),
        'started_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        'type'       => $faker->randomElement([MachineJobType::THREE_D_PRINTER, MachineJobType::LASER, MachineJobType::ROUTER]),
        'details'    => \json_encode($faker->shuffleArray([$faker->word, $faker->word, $faker->word]))
    ];
});
