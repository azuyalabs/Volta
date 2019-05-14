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
            <div class="p-2 card-title">
                {{ $tc('index.title', this.totalRows, { count: this.totalRows }) }}
            </div>
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
                <div class="p-2">
                    <b-link
                        href="/manufacturers/create"
                        class="btn btn-primary btn-sm text-uppercase"
                        :title="$t('create.title')"
                    >
                        <svgicon icon="plus" class="button-icon-sm" color="#fff"></svgicon>
                        add
                    </b-link>
                </div>
                <div class="ml-auto p-2 d-inline-flex">
                    <b-form-group
                        :label="$t('filter.search.label')"
                        label-for="filter_search"
                        label-size="sm"
                        class="mr-3"
                    >
                        <b-input-group>
                            <b-form-input
                                id="filter_search"
                                size="sm"
                                v-model="filter.search"
                                :placeholder="$t('filter.search.label') + '...'"
                            />
                            <b-input-group-append>
                                <b-btn
                                    size="sm"
                                    :disabled="!filter.search"
                                    @click="filter.search = ''"
                                    >{{ $t('filter.search.clear') }}
                                </b-btn>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                    <b-form-group
                        :label="$t('filter.supplies.label')"
                        label-for="filter_supplies"
                        label-size="sm"
                        class="mr-3"
                    >
                        <b-form-radio-group
                            id="filter_supplies"
                            buttons
                            v-model="filter.supplies"
                            :options="suppliesFilterOptions"
                            size="sm"
                            button-variant="outline-primary"
                        />
                    </b-form-group>
                    <b-form-group
                        :label="$t('filter.country.label')"
                        label-for="filter_country"
                        label-size="sm"
                        class="mr-3"
                    >
                        <b-form-select
                            id="filter_country"
                            v-model="filter.country"
                            :options="countryFilterOptions"
                            size="sm"
                        >
                            <option slot="first" value="all"
                                >-- {{ $t('filter.country.all') }} --
                            </option>
                        </b-form-select>
                    </b-form-group>
                </div>
            </div>

            <!-- Table -->
            <b-table
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :filter-function="filterFunction"
                :filter="filter"
                :items="collection"
                :fields="fields"
                :current-page="currentPage"
                :per-page="perPage"
                @filtered="onFiltered"
                class="volta"
            >
                <template slot="supplies" slot-scope="row">
                    <b-badge
                        class="text-uppercase"
                        variant="primary"
                        v-b-tooltip.hover
                        :title="$t('fields.is_filament_supplier.tooltip')"
                        v-if="row.item.filament_supplier == 1"
                        >{{ $t('filament') }}
                    </b-badge>
                    <b-badge
                        class="text-uppercase"
                        variant="info"
                        v-b-tooltip.hover
                        :title="$t('fields.is_equipment_supplier.tooltip')"
                        v-if="row.item.equipment_supplier == 1"
                        >{{ $t('equipment') }}
                    </b-badge>
                </template>
                <template slot="actions" slot-scope="row">
                    <div v-if="row.item.status !== 'in_progress'">
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
                                :href="'/manufacturers/' + row.item.id + '/edit'"
                                :title="$t('edit.title', { name: row.item.name })"
                                >Edit
                            </b-dropdown-item>
                            <b-dropdown-item
                                @click.prevent="deleteItem(row.item.id)"
                                href="#"
                                :title="$t('delete.title', { name: row.item.name })"
                                >Delete
                            </b-dropdown-item>
                        </b-dropdown>
                    </div>
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

        <!-- Modal Component -->
        <b-modal id="modal-center" centered :title="$t('create.title')">
            <p class="my-4">Vertically centered modal!</p>
        </b-modal>
    </div>
</template>

<script>
import axios from 'axios';
import fieldDefs from './fieldDefs.js';

import '../../../../svg-icons/compiled/plus.js';
import '../../../../svg-icons/compiled/actions.js';
import '../../../../svg-icons/compiled/404.js';
import '../../../../svg-icons/compiled/mini_refresh_circle.js';

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
            filter: {
                search: '',
                country: 'all',
                supplies: 'all',
            },
        };
    },

    mounted() {
        this.getData();
    },

    computed: {
        suppliesFilterOptions() {
            return [
                { text: this.$t('filter.supplies.option_all'), value: 'all' },
                { text: this.$t('filter.supplies.option_filament'), value: 'filament' },
                { text: this.$t('filter.supplies.option_equipment'), value: 'equipment' },
            ];
        },

        countryFilterOptions() {
            return [...new Set(this.collection.map(item => item.country))].sort().map(f => {
                return { text: f, value: f };
            });
        },
    },

    methods: {
        filterFunction(record) {
            return (
                (this.filter.supplies === 'all' ||
                    (this.filter.supplies === 'equipment' && record.equipment_supplier === 1) ||
                    (this.filter.supplies === 'filament' && record.filament_supplier === 1)) &&
                (this.filter.country === 'all' || record.country === this.filter.country) &&
                (this.filter.search === '' ||
                    record.name.toLowerCase().indexOf(this.filter.search.toLowerCase()) > -1)
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
                    .delete('/api/manufacturers/' + id)
                    .then(response => {
                        this.collection.splice(index, 1);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },

        getData: async function() {
            this.isLoading = true;
            try {
                const response = await axios.get('/api/manufacturers');

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

                        // Apply name code -> name mapping based on meta element
                        if (collectionData[i].hasOwnProperty('meta')) {
                            let meta = collectionData[i]['meta'];
                            if (meta.hasOwnProperty(key + '.name') && meta[key + '.name']) {
                                o[key] = meta[key + '.name'];
                            }
                        }
                    }

                    this.collection.push(o);
                }

                this.totalRows = collectionData.length;
                this.isLoading = false;
            } catch (error) {
                console.log(error);
                return [];
            }
        },
    },
};
</script>
