<?php

declare(strict_types=1);

return [
    'section'    => 'Profile',
    'model_name' => 'Profile|Profiles',

    'subtitle' => 'Change your settings here',

    'currency'  => 'Main Currency',
    'api_token' => 'API Token',
    'language'  => 'Language',
    'country'   => 'Country',
    'city'      => 'City',

    // Field Help Blocks
    'apiTokenHelpBlock' => 'This API Token can be used when you would like other applications to communicate with Volta',
    'languageHelpBlock' => 'At the moment only English is supported. In the future other translations will be made available.',
    'currencyHelpBlock' => 'The default currency for your business in Volta',
    'countryHelpBlock'  => 'Your location on this rock. The country field is used to display related content such as public holidays.',
    'cityHelpBlock'     => 'The city field is used for retrieving your local weather, which will be displayed on the Dashboard.',
];
