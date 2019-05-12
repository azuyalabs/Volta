<?php

return [
    'section' => 'Preferences',
    'subtitle' => 'There are a variety of settings available to adjust Volta to your liking. Use the navigation on the left to select a specific component.',

    'refresh_note' => 'Changes made to your preferences are not automatically forwarded to your Volta Dashboard. Please manually refresh the Dashboard after you made changes.',

    'components' => [
        'volta' => 'Volta',
        'dashboard' => 'Dashboard',
    ],

    'clock' => [
        'name' => 'Clock',
        'text' => 'The longest time is neither an hour nor a day... Use the below settings to control how the clock widget is shown on your Volta Dashboard.',

        'type' => [
            'name' => 'Clock Type',
            'description' => 'View your clock as digital or analog',
            'type_values' => [
                'analog' => 'Analog',
                'digital' => 'Digital'
            ],
        ]
    ],

    'weather' => [
        'name' => 'Weather',
        'text' => 'Exterior humidity and temperature can attribute to a good or bad 3D print. Use the below settings to control how the weather widget is shown on your Volta Dashboard.',

        'system_of_measure' => [
            'name' => 'System of Measurement',
            'description' => 'Temperature and wind speed will be shown in Celsius and m/s for the Metric system. For the Imperial system Fahrenheit and m/h (miles per hour) are used.',
            'type_values' => [
                'metric' => 'Metric',
                'imperial' => 'Imperial'
            ],
        ]
    ],

];
