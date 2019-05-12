<template>
    <tile :position="position">
        <section class="holidays__header">
            <h1 v-text="$t('title')" />
            <span
                class="holidays__header-country"
                v-if="holidays.length > 0"
                v-text="$t('providers.' + provider)"
            />
        </section>
        <section>
            <ul v-if="holidays.length > 0">
                <li v-for="holiday in holidays" class="holidays">
                    <span v-text="holiday.name" class="holidays__holiday-name" />
                    <span
                        v-text="
                            diffForHumans(holiday.date) +
                                ' (' +
                                dateFormat(holiday.date, 'MMMM Do') +
                                ')'
                        "
                        class="holidays__holiday-date"
                    />
                </li>
            </ul>
            <div v-else class="content-center"><span v-text="$t('no_holidays')" /></div>
        </section>
    </tile>
</template>

<script>
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import { dateFormat, diffForHumans } from '../../helpers';
import axios from 'axios';

export default {
    i18n: {
        messages: {
            'en-US': {
                title: 'Upcoming Holidays',
                no_holidays: 'No upcoming holidays (yet)',
                providers: {
                    JP: 'Japan',
                    NL: 'Netherlands',
                    FR: 'France',
                    US: 'United States',
                },
            },
        },
    },

    components: {
        Tile,
    },

    mixins: [saveState],

    props: ['position'],

    data() {
        return {
            holidays: [],
            provider: '',
        };
    },

    created() {
        // Nudge Volta to fetch the upcoming holidays
        if (_.isEmpty(this.holidays)) {
            axios.post('/api/dashboard/update/holidays');
        }

        this.$root.echo
            .channel('holidays.' + window.Volta.country)
            .listen('Holidays.HolidaysFetched', response => {
                this.holidays = response.holidays;
                this.provider = response.provider;
            });
    },

    methods: {
        dateFormat,
        diffForHumans,

        getSaveStateConfig() {
            return {
                cacheKey: 'holidays',
            };
        },
    },
};
</script>
