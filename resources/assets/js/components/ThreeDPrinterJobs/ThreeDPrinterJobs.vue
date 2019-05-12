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
    <div>
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
            <div class="p-2 card-title">{{ $t('main_title') }}</div>
            <div class="ml-auto p-2">
                <b-link href="#" @click.prevent="getData" :title="$t('title.refresh')">
                    <svgicon
                        icon="mini_refresh_circle"
                        class="mini_refresh_data"
                        :title="$t('title.refresh')"
                    ></svgicon>
                </b-link>
            </div>
        </div>

        <div v-if="collection.length">
            <!-- User Controls -->
            <div class="d-flex">
                <div class="p-2"></div>
                <div class="ml-auto p-2 d-inline-flex">
                    <b-form-group
                        :label="$t('filter.search.label')"
                        label-for="filterSearch"
                        label-size="sm"
                        class="mr-3"
                    >
                        <b-input-group>
                            <b-form-input
                                size="sm"
                                v-model="filterSearch"
                                :placeholder="$t('filter.search.label') + '...'"
                            />
                            <b-input-group-append>
                                <b-btn
                                    size="sm"
                                    :disabled="!filterSearch"
                                    @click="filterSearch = ''"
                                    >{{ $t('filter.search.clear') }}
                                </b-btn>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                    <b-form-group
                        :label="$t('filter.result.label')"
                        label-for="filterResult"
                        label-size="sm"
                        class="mr-3"
                    >
                        <b-form-radio-group
                            id="filterResult"
                            buttons
                            v-model="filterResult"
                            :options="resultFilterOptions"
                            name="filterResult"
                            size="sm"
                            button-variant="outline-primary"
                        />
                    </b-form-group>
                    <b-form-group
                        :label="$t('filter.printer.label')"
                        label-for="filterMachine"
                        label-size="sm"
                        class="mr-3"
                    >
                        <b-form-select
                            id="filterMachine"
                            v-model="filterMachine"
                            :options="resultMachineOptions"
                            @change="filterManufacturer = null"
                            size="sm"
                        >
                            <option slot="first" value="all"
                                >-- {{ $t('filter.printer.all') }} --</option
                            >
                        </b-form-select>
                    </b-form-group>
                </div>
            </div>

            <!-- Table -->
            <b-table
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :filter="filterFunction"
                :items="collection"
                :fields="fields"
                :current-page="currentPage"
                :per-page="perPage"
                @filtered="onFiltered"
                class="volta"
            >
                <template slot="name" slot-scope="row">
                    <status-indicator
                        v-if="row.item.status === 'success'"
                        positive
                        v-b-tooltip.hover
                        :title="$t('title.status_indicator.success')"
                    ></status-indicator>
                    <status-indicator
                        v-if="row.item.status === 'failed'"
                        negative
                        v-b-tooltip.hover
                        :title="$t('title.status_indicator.failed')"
                    ></status-indicator>
                    <status-indicator
                        v-if="row.item.status === 'in_progress'"
                        active
                        pulse
                        v-b-tooltip.hover
                        :title="$t('title.status_indicator.in_progress')"
                    ></status-indicator>
                    <div class="d-inline-block">
                        <div v-b-tooltip.hover :title="row.value" v-if="row.value.length > 30">
                            {{ row.value.replace(/(.{30})..+/, '$1&hellip;') }}
                        </div>
                        <div v-else>{{ row.value }}</div>
                        <div class="text-muted small">
                            {{ $t('job_id', { id: row.item.job_id }) }}
                        </div>
                    </div>
                </template>

                <template slot="started_at" slot-scope="row">
                    {{ dateFormat(row.item.started_at, 'L LTS') }}
                </template>

                <template slot="duration" slot-scope="row">
                    {{ formatPrintJobDuration(row.item.duration) }}
                    <div class="text-muted small" v-if="row.item.status === 'success'">
                        {{ $t('usage', { usage: formatFilamentUsage(row.item.details) }) }}
                    </div>
                </template>

                <template slot="machine" slot-scope="row">
                    <b-link :href="'/machines'">{{ row.item.machine.name }}</b-link>
                </template>

                <template slot="actions" slot-scope="row" v-if="row.item.status !== 'in_progress'">
                    <b-dropdown variant="link" size="sm" right no-caret>
                        <template slot="button-content">
                            <svgicon
                                v-b-tooltip.hover
                                :title="$t('title.more_actions')"
                                icon="actions"
                                class="action-icon-md"
                            ></svgicon>
                        </template>
                        <b-dropdown-item
                            @click.prevent="deleteItem(row.item.id)"
                            href="#"
                            :title="$t('title.delete', { name: row.item.name })"
                            >Delete
                        </b-dropdown-item>
                        <b-dropdown-divider />
                        <b-dropdown-item
                            v-if="row.item.status === 'failed'"
                            :title="$t('title.mark_as_successful')"
                            @click.prevent="toggleResult(row.item.id, 'success')"
                            >Mark as Successful
                        </b-dropdown-item>
                        <b-dropdown-item
                            v-if="row.item.status === 'success'"
                            :title="$t('title.mark_as_failed')"
                            @click.prevent="toggleResult(row.item.id, 'failed')"
                            >Mark as Failed
                        </b-dropdown-item>
                    </b-dropdown>
                </template>
            </b-table>

            <!-- Pagination -->
            <div class="d-flex align-items-center flex-column">
                <b-pagination
                    v-if="totalRows > perPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    v-model="currentPage"
                    class="my-0"
                ></b-pagination>
            </div>
        </div>

        <!-- No Data -->
        <div class="container-fluid" v-else-if="!isLoading">
            <div id="no-data">
                <svgicon icon="404"></svgicon>
                <div>{{ $t('no_data') }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import fieldDefs from './fieldDefs.js';

import '../../../../svg-icons/compiled/plus.js';
import '../../../../svg-icons/compiled/actions.js';
import '../../../../svg-icons/compiled/404.js';
import '../../../../svg-icons/compiled/mini_refresh_circle.js';

import { dateFormat, formatPrintJobDuration, numberFormat } from '../../../../js/helpers';
import { StatusIndicator } from 'vue-status-indicator';
import { HalfCircleSpinner } from 'epic-spinners';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    i18n: require('./i18n.js'),

    components: {
        StatusIndicator,
        HalfCircleSpinner,
        Loading,
    },

    props: {},

    data() {
        return {
            isLoading: false,
            fullPage: false,
            sortBy: 'started_at',
            sortDesc: true,
            fields: fieldDefs(this.$i18n),
            totalRows: 0,
            currentPage: 1,
            perPage: 10,
            collection: [],

            filterResult: 'all',
            filterMachine: 'all',
            filterSearch: '',
        };
    },

    mounted() {
        this.getData();
    },

    computed: {
        resultFilterOptions() {
            return [
                { text: this.$t('filter.result.option_all'), value: 'all' },
                { text: this.$t('filter.result.option_in_progress'), value: 'in_progress' },
                { text: this.$t('filter.result.option_success'), value: 'success' },
                { text: this.$t('filter.result.option_failed'), value: 'failed' },
            ];
        },

        resultMachineOptions() {
            return [...new Set(this.collection.map(item => item.machine.name))].sort().map(f => {
                return { text: f, value: f };
            });
        },
    },

    methods: {
        formatFilamentUsage(record) {
            let details = JSON.parse(record);

            if (details && details.filament_length > 0) {
                return numberFormat(details.filament_length / 1000);
            }

            return 0;
        },

        filterFunction(record) {
            return (
                (this.filterResult === 'all' || this.filterResult === record.status) &&
                (this.filterMachine === 'all' || record.machine.name === this.filterMachine) &&
                (this.filterSearch === '' ||
                    record.name.toLowerCase().indexOf(this.filterSearch.toLowerCase()) > -1 ||
                    record.job_id.toLowerCase().indexOf(this.filterSearch.toLowerCase()) > -1)
            );
        },

        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },

        deleteItem(id) {
            let conf = confirm(this.$t('confirmations.delete'));
            let index = this.collection.findIndex(x => x.id === id);

            if (conf === true) {
                axios
                    .delete('/api/threedprinterjobs/' + id)
                    .then(response => {
                        this.collection.splice(index, 1);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },

        toggleResult(id, value) {
            this.isLoading = true;
            axios
                .patch('/api/threedprinterjobs/' + id, {
                    status: value,
                })
                .then(response => {
                    this.getData();
                })
                .catch(error => {
                    console.log(error);
                });
        },

        getData: async function() {
            this.isLoading = true;
            try {
                const response = await axios.get('/api/threedprinterjobs');

                // Remap JSON:API data to simple array with objects as its elements
                let collectionData = response.data.data;
                this.collection = [];

                for (let i = 0; i < collectionData.length; i++) {
                    let o = {};
                    o.id = collectionData[i].id; // Need to fetch primary key

                    // Fetch all the attributes
                    let attr = collectionData[i].attributes;
                    for (let key in attr) {
                        if (attr.hasOwnProperty(key)) o[key] = attr[key];
                    }

                    this.collection.push(o);
                }
                this.isLoading = false;
            } catch (error) {
                console.log(error);
                return [];
            }
        },

        formatPrintJobDuration,
        dateFormat,
    },
};
</script>
