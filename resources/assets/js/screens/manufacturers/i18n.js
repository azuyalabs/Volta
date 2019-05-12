export const messages = {
    'en-US': {
        index: {
            title: 'Manufacturers',
            description:
                "Manage Volta's list of manufacturers here. Manufacturers are used to identify various other components such as Equipment, Filament Spools, etc.",
        },
        create: {
            title: 'Add Manufacturer',
        },
        edit: {
            title: 'Edit Manufacturer',
        },
        equipment: 'Equipment',
        filament: 'Filament',
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
