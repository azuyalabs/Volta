<!--
  - This file is part of the Volta Project.
  -
  - Copyright (c) 2018 - 2019. AzuyaLabs
  -
  - For the full copyright and license information, please view the LICENSE
  - file that was distributed with this source code.
  -
  - @author Sacha Telgenhof <me@sachatelgenhof.com>
  -->

<template>
    <div class="card card-metric">
        <loading
            :active.sync="isLoading"
            :can-cancel="false"
            :is-full-page="fullPage"
            :opacity="0.9"
        >
            <half-circle-spinner :animation-duration="1000" :size="30" color="#f5b180" />
        </loading>

        <!-- Card Header -->
        <div class="container-fluid row pr-0">
            <div class="card-title pl-2">
                {{ $tc('main_title', totalJobs, { count: totalJobs }) }}
            </div>
            <div class="ml-auto">
                <b-link href="#" @click.prevent="getData" :title="$t('refresh')">
                    <svgicon
                        icon="mini_refresh_circle"
                        class="mini_refresh_data"
                        :title="$t('refresh')"
                    ></svgicon>
                </b-link>
            </div>
        </div>

        <div class="card-body pt-0">
            <calendar-heatmap
                :values="values"
                :end-date="today"
                :tooltip-unit="$t('unit')"
                :range-color="color_range"
            />
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { CalendarHeatmap } from 'vue-calendar-heatmap';

import { HalfCircleSpinner } from 'epic-spinners';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import '../../../../svg-icons/compiled/mini_refresh_circle.js';

export default {
    i18n: require('./heatmap_i18n.js'),

    components: {
        CalendarHeatmap,
        HalfCircleSpinner,
        Loading,
    },

    data() {
        return {
            isLoading: false,
            fullPage: false,
            today: new Date(),
            values: [],
            color_range: ['#ebedf0', '#ffe5ca', '#f5b180', '#e77636', '#e14a0c', '#711f03'],
        };
    },

    computed: {
        totalJobs() {
            let total = 0;
            for (let i = 0; i < this.values.length; i++) {
                total += parseInt(this.values[i].count);
            }
            return total;
        },
    },

    mounted() {
        this.getData();
    },

    methods: {
        getData: async function() {
            this.isLoading = true;
            try {
                const response = await axios.get('/api/threedprinterjobs/activity');
                this.values = response.data;
                this.isLoading = false;
            } catch (error) {
                console.log(error);
                return [];
            }
        },
    },
};
</script>
<style>
svg.vch__wrapper {
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto',
        'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji',
        'Segoe UI Symbol' !important;
    line-height: 10px;
    text-transform: uppercase;
    font-weight: 900;
}
</style>
