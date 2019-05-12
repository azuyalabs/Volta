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
            name: 'name',
            title: () => i18n.t('fields.name.text'),
            sortField: 'name',
            width: '57%',
        },
        {
            name: 'manufacturer.attributes.name',
            title: i18n.t('fields.manufacturer.text'),
            width: '35%',
        },
        {
            name: '__slot:actions',
            title: '',
            width: '8%',
            titleClass: 'center aligned',
            dataClass: 'center aligned',
        },
    ];
};
