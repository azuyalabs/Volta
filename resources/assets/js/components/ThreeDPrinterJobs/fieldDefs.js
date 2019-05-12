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
            label: i18n.t('fields.name'),
            sortable: true,
            class: 'machine_jobs_column_name',
        },
        {
            key: 'machine',
            label: i18n.t('fields.machine'),
            sortable: false,
            class: 'machine_jobs_column_machine',
        },
        {
            key: 'started_at',
            label: i18n.t('fields.started_at'),
            sortable: true,
            class: 'machine_jobs_column_start',
        },
        {
            key: 'duration',
            label: i18n.t('fields.duration'),
            sortable: true,
            class: 'machine_jobs_column_duration text-right',
        },
        {
            key: 'actions',
            label: '',
            sortable: false,
            class: 'machine_jobs_column_actions',
        },
    ];
};
