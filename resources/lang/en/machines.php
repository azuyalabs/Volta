<?php

return [
    'section' => 'Equipment',

    // Model
    'model_name'  => 'Machine|Machines',
    'model_count' => '{1} :value machine|[2,*] :value machines',

    // Fields
    'name'               => 'Name',
    'make'               => 'Make',
    'model'              => 'Model',
    'acquisition_cost'   => 'Acquisition Cost',
    'residual_value'     => 'Residual Value',
    'maintenance_cost'   => 'Maintenance Cost',
    'lifespan'           => 'Lifespan',
    'operating_hours'    => 'Operating Hours',
    'energy_consumption' => 'Energy Consumption',
    'type'               => 'Type',
    'user_id'            => 'User Id',
    'costperhour'        => 'Cost per hour',

    // Titles/sentences
    'add_machine'             => 'Add a new Machine',
    'add_machine_subtitle'    => 'The more machines the better. Increase your productivity!',
    'update_machine_subtitle' => 'Update the details of your marvelous <strong>:manufacturer_name :model_name</strong>.',
    'index_machine_subtitle'  => [
        'part1' => 'Your collection of awesome maker equipment. Currently you own ',
        'part2' => '{1} <strong>:machine_count</strong> machine with a value of |[2,*] <strong>:machine_count</strong> machines with a value of '
    ],


];
