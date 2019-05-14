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

return [
    'section' => 'Equipment',

    // Model
    'model_name' => 'Manufacturer|Manufacturers',
    'model_count' => '{1} :value manufacturer|[2,*] :value manufacturer',

    // Fields
    'name' => 'Name',
    'website' => 'Website',
    'country' => 'Country',
    'filament_supplier' => 'Filament Supplier?',
    'equipment_supplier' => 'Equipment Supplier?',

    // Titles/sentences
    'add_manufacturer' => 'Add a new Manufacturer',
    'add_manufacture_subtitle' => 'Manufacturer records in Volta are used to identify various other components such as Equipment, Filament Spools, etc.',
    'edit_manufacturer' => 'Edit Manufacturer',
    'edit_manufacture_subtitle' => 'Update the details of <strong>:manufacturer_name</strong> here.',
    'index_manufacturer_subtitle' => 'Manage Volta\'s list of manufacturers here. Manufacturers are used to identify various other components such as Equipment, Filament Spools, etc.',

    // Flash messages
    'flash_manufacturer_added' => 'The manufacturer has been added successfully',
    'flash_manufacturer_updated' => 'The manufacturer has been updated successfully',

    // Field Help Blocks
    'nameHelpBlock' => 'The manufacturer\'s name (i.e. company name)',
    'websiteHelpBlock' => 'The manufacturer\'s official website',
    'countryHelpBlock' => 'The country where the manufacturer is located.',
    'filament_supplierHelpBlock' => 'Is this manufacturer a producer of 3D printing filament?',
    'equipment_supplierHelpBlock' => 'Is this manufacturer a producer of equipment?',
];
