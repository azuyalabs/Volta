/*
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2019. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

export const messages = {
    'en-US': {
        index: {
            title: 'no manufacturers found| one manufacturer found | {count} manufacturers found',
            description:
                "Manage Volta's list of manufacturers here. Manufacturers are used to identify various other components such as Equipment, Filament Spools, etc.",
        },
        create: {
            title: 'Add a new Manufacturer',
        },
        edit: {
            title: 'Edit manufacturer `{name}`',
        },
        delete: {
            title: 'Delete manufacturer `{name}`',
        },

        equipment: 'Equipment',
        filament: 'Filament',
        no_data: 'Oops! No manufacturer records have been found',

        title: {
            refresh: 'Refresh',
            more_actions: 'More actions',
        },

        confirmations: {
            delete: 'Do you really want to delete this manufacturer?',
        },

        filter: {
            search: {
                label: 'Search',
                clear: 'Clear',
            },
            supplies: {
                label: 'Supplies...',
                option_all: 'All',
                option_filament: 'Filament',
                option_equipment: 'Equipment',
            },
            country: {
                label: 'Country',
                all: 'All',
            },
        },

        fields: {
            name: {
                text: 'Name',
                description: "The manufacturer's name (i.e. company name)",
            },
            website: {
                text: 'Website',
                description: 'The main website of the manufacturer.',
            },
            country: {
                text: 'Country',
                description: 'The country where the manufacturer is located.',
            },

            product_count: {
                text: 'Product Count',
            },

            is_filament_supplier: {
                text: 'Filament Supplier?',
                description: 'Is this manufacturer a producer of 3D printing filament?',
                tooltip: 'This manufacturer produces 3D printing filaments.',
            },

            is_equipment_supplier: {
                text: 'Equipment Supplier?',
                description: 'Is this manufacturer a producer of equipment?',
                tooltip:
                    'This manufacturer produces equipment such as 3D Printers, CNC machinery, etc.',
            },

            supplies: {
                text: 'Supplies...',
            },
        },
    },
};
