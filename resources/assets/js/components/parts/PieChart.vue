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
            <vc-donut
                :sections="sections"
                :size="32"
                unit="%"
                :thickness="20"
                :total="parseInt(totalJobs)"
                hasLegend
                legendPlacement="right"
                ><span class="chart-donut-center-text">{{ ratio }}%</span>
            </vc-donut>
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
    i18n: require('./piechart_i18n.js'),

    components: {
        HalfCircleSpinner,
        Loading,
    },

    data() {
        return {
            isLoading: false,
            fullPage: false,
            totalJobs: 1,
            sections: [],
        };
    },

    mounted() {
        this.getData();
    },

    computed: {
        ratio: function() {
            let successRate;
            let successValue = 0;

            for (let i = 0; i < this.sections.length; i++) {
                if (this.sections[i] && this.sections[i].label === 'Success') {
                    successValue = this.sections[i].value;
                }
            }

            successRate = Math.round((successValue / this.totalJobs) * 100);

            return successRate;
        },
    },

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
