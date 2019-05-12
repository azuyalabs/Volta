<?php

return [

    // Model
    'model_name' => 'Filament Spool|Filament Spools',
    'model_count' => '{1} :value spool|[2,*] :value spools',

    // Fields
    'name' => 'Name',
    'brand' => 'Brand',
    'material' => 'Material',
    'purchase_price' => 'Purchase Price',
    'weight' => 'Weight',
    'diameter' => 'Diameter',
    'density' => 'Density',
    'color' => 'Color',
    'color_value' => 'Color Value',
    'user_id' => 'User Id',
    'priceperweight' => 'Price per kg',
    'priceperlength' => 'Price per m',
    'pricepervolume' => 'Price per cm<sup>3</sup>',
    'priceperkilogram' => 'Price per kg',
    'length' => 'Length',
    'usage' => 'Consumption',

    // Titles/sentences
    'add_spool' => 'Add a new Filament Spool',
    'add_spool_subtitle' => 'As you can\'t have never enough filament!',
    'update_spool_subtitle' => 'Update the details of the splendid <strong>:manufacturer_name :spool_name</strong> filament.',
    'index_spool_subtitle' => [
        'part1' => 'Your stockpile of 3D Printer Filament Spools. Currently you have ',
        'part2' => '{1} <strong>:spool_count</strong> spools|[2,*] <strong>:spool_count</strong> spools with a value of '
    ],

    // Field Help Blocks
    'nameHelpBlock' => 'A unique, good name to remember this filament spool',
    'manufacturer_idHelpBlock' => 'The manufacturer (or brand) of this filament spool',
    'materialHelpBlock' => 'The type of plastic of this filament spool',
    'purchase_priceHelpBlock' => 'The price of this spool when purchased or acquired',
    'weightHelpBlock' => 'The net weight of the filament spool (in grams)',
    'diameterHelpBlock' => 'The filament diameter (in mm) as given by the manufacturer',
    'densityHelpBlock' => 'The filament density (in g/cm<sup>3</sup>) as given by the manufacturer',
    'colorHelpBlock' => 'The color (name) as identified by the manufacturer',
    'colorvalueHelpBlock' => 'The hexadecimal number of the filament color',
    'usageHelpBlock' => 'The amount of filament consumed (in meters) as of now'
];
