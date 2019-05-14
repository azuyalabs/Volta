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
            <div class="card-title pl-2">{{ $t('main_title') }}</div>
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

        <!-- class="mini_refresh_data" -->
        <!-- Main Body -->
        <div class="card-body pt-0">
            <apexchart type="bar" height="350" :options="chartOptions" :series="series" />
        </div>

        <!-- Card Footer -->
        <div class="footer-text">
            {{ $t('footer_text') }}
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { HalfCircleSpinner } from 'epic-spinners';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import '../../../../svg-icons/compiled/mini_refresh_circle.js';

export default {
    i18n: require('./successrate_piechart_i18n.js'),

    components: {
        HalfCircleSpinner,
        Loading,
    },

    data() {
        return {
            isLoading: false,
            fullPage: false,
            totalJobs: 1,

            series: [
                {
                    name: 'SUCCESS',
                    data: [44, 55, 41, 67, 22, 43, 4, 55, 41, 67, 22, 43],
                },
                {
                    name: 'FAILED',
                    data: [13, 23, 20, 8, 13, 27, 13, 23, 20, 8, 13, 27],
                },
            ],

            chartOptions: {
                chart: {
                    fontFamily: 'Poppins, Arial, sans-serif',
                    stacked: true,
                    toolbar: {
                        show: false,
                    },
                    zoom: {
                        enabled: true,
                    },
                },
                responsive: [
                    {
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0,
                            },
                        },
                    },
                ],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '90%',
                    },
                },

                xaxis: {
                    type: 'datetime',
                    categories: [
                        '01/01/2011',
                        '02/01/2011',
                        '03/01/2011',
                        '04/01/2011',
                        '05/01/2011',
                        '06/01/2011',
                        '07/01/2011',
                        '08/01/2011',
                        '09/01/2011',
                        '10/01/2011',
                        '11/01/2011',
                        '12/01/2011',
                    ],
                },
                legend: {
                    position: 'right',
                    offsetY: 40,
                },
                fill: {
                    opacity: 1,
                },
                tooltip: {
                    enabled: false,
                },
            },
        };
    },

    mounted() {
        this.getData();
    },

    computed: {},

    methods: {
        getData: async function() {
            this.isLoading = true;
            try {
                const response = await axios.get('/api/threedprinterjobs/success_rate');

                this.totalJobs = 0;
                this.sections = [];

                if (response.data.length > 0) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.totalJobs += parseInt(response.data[i]['value']);
                        let data = { value: parseInt(response.data[i]['value']) };

                        data.color =
                            response.data[i]['status'] === 'success' ? '#4bd28f' : '#ff4d4d';
                        data.label =
                            response.data[i]['status'] === 'success'
                                ? this.$t('labels.success')
                                : this.$t('labels.failed');

                        this.sections.push(data);
                    }
                } else {
                    this.totalJobs = 1;
                }

                this.isLoading = false;
            } catch (error) {
                console.log(error);
                return [];
            }
        },
    },
};
</script>
