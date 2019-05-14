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

export default i18n => {
    return [
        {
            key: 'name',
            label: i18n.t('fields.name.text'),
            sortable: true,
            class: 'manufacturers_column_name',
        },
        {
            key: 'country',
            label: i18n.t('fields.country.text'),
            sortable: true,
            class: 'manufacturers_column_country',
        },
        {
            key: 'supplies',
            label: i18n.t('fields.supplies.text'),
            sortable: false,
            class: 'manufacturers_column_supplies',
        },
        {
            key: 'product_count',
            label: i18n.t('fields.product_count.text'),
            sortable: true,
            class: 'manufacturers_column_product_count',
        },
        {
            key: 'actions',
            label: '',
            sortable: false,
            class: 'manufacturers_column_actions',
        },
    ];
};
