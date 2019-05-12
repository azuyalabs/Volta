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
        main_title: 'Print Job History',
        job_id: 'Job ID: {id}',
        usage: 'Filament: {usage}m',
        no_data: "Uhm... you haven't printed anything yet. Guess it's about time, isn't it?",

        title: {
            refresh: 'Refresh',
            delete: 'Delete print job `{name}`',
            more_actions: 'More actions',
            mark_as_successful: 'Mark Print Job as successful',
            mark_as_failed: 'Mark Print Job as failed',

            status_indicator: {
                success: 'Success',
                failed: 'Failed',
                in_progress: 'Printing in progress',
            },
        },

        confirmations: {
            delete: 'Do you really want to delete this print job?',
        },

        filter: {
            search: {
                label: 'Search',
                clear: 'Clear',
            },
            result: {
                label: 'Result',
                option_all: 'All',
                option_success: 'Successful',
                option_failed: 'Failed',
                option_in_progress: 'In Progress',
            },
            printer: {
                label: 'Printer',
                all: 'All',
            },
        },

        fields: {
            name: 'Name',
            machine: 'Printer',
            started_at: 'Started at',
            duration: 'Print Time',
        },
    },
};
