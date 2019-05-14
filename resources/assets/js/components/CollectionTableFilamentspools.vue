<template>
    <div>
        <!-- User Controls -->
        <div class="d-flex">
            <div class="p-2">
                <b-link
                    href="/spools/create"
                    class="btn btn-primary btn-sm text-uppercase"
                    title="Add a new Spool"
                >
                    <svgicon icon="plus" class="button-icon-sm" color="#fff"></svgicon>
                    add
                </b-link>
            </div>
            <div class="ml-auto p-2 d-inline-flex">
                <b-form-group
                    label="Material"
                    label-for="filter_material"
                    label-size="sm"
                    class="mr-3"
                >
                    <b-form-select
                        id="filter_material"
                        v-model="filter.material"
                        :options="materialFilterOptions"
                        size="sm"
                    >
                        <option slot="first" value="all">-- All --</option>
                    </b-form-select>
                </b-form-group>
                <b-form-group label="Manufacturer" label-for="filter_manufacturer" label-size="sm">
                    <b-form-select
                        id="filter_manufacturer"
                        v-model="filter.manufacturer"
                        :options="manufacturerFilterOptions"
                        size="sm"
                    >
                        <option slot="first" value="all">-- All --</option>
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
            <template slot="name" slot-scope="row">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="32"
                    height="32"
                    viewBox="0 0 24 24"
                    :fill="row.item.color_value"
                    stroke="silver"
                    stroke-width="1"
                    class="color-swatch"
                    v-b-tooltip.hover
                    :title="row.item.color"
                >
                    <circle cx="12" cy="12" r="10"></circle>
                </svg>
                <div class="d-inline-block">
                    <div>
                        <b-link :href="'/spools/' + row.item.id">{{ row.value }}</b-link>
                    </div>
                    <div class="text-muted small">{{ row.item.manufacturer }}</div>
                </div>
            </template>

            <template slot="material" slot-scope="row">
                <div class="d-inline-block">
                    <div class="text-uppercase">{{ row.item.material }}</div>
                    <div class="text-muted small">
                        {{ row.item.diameter }} mm / {{ row.item.density }} g/cm<sup>3</sup>
                    </div>
                </div>
            </template>

            <template slot="price" slot-scope="row"
                >{{ moneyFormat(row.item.unit_price.kilogram.amount) }}
            </template>

            <template slot="usage" slot-scope="row">
                <div class="d-inline-block">
                    <vm-progress
                        class="filament_spool"
                        :percentage="spoolUsage(row.item)"
                        :stroke-width="10"
                        :show-text="false"
                        v-b-tooltip.hover
                        :title="
                            numberFormat(row.item.length.capacity - row.item.length.usage) +
                                ' m remaining'
                        "
                    />
                    <div class="text-muted small">
                        {{ numberFormat(spoolUsage(row.item), 1) + '% used' }}
                    </div>
                </div>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="usage-alert"
                    v-if="alertUsage(row.item)"
                    v-b-tooltip.hover
                    :title="
                        'You are soon running out of ' +
                            row.item.manufacturer +
                            ' ' +
                            row.item.color +
                            '! Please consider getting a new spool.'
                    "
                >
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12" y2="16"></line>
                </svg>
            </template>

            <template slot="actions" slot-scope="row">
                <b-dropdown variant="link" size="sm" right no-caret>
                    <template slot="button-content">
                        <svgicon
                            v-b-tooltip.hover
                            title="More actions"
                            icon="actions"
                            class="action-icon-md"
                        ></svgicon>
                    </template>
                    <b-dropdown-item
                        :href="'/spools/' + row.item.id + '/edit'"
                        :title="'Edit filament spool `' + row.item.name + '`'"
                        >Edit
                    </b-dropdown-item>
                    <b-dropdown-item
                        @click.stop="deleteInstance(row.item.id)"
                        href="#"
                        :title="'Delete filament spool `' + row.item.name + '`'"
                        >Delete
                    </b-dropdown-item>
                    <b-dropdown-item
                        :href="'/spools/' + row.item.id + '/duplicate'"
                        :title="'Duplicate filament spool `' + row.item.name + '`'"
                        >Duplicate
                    </b-dropdown-item>
                    <b-dropdown-item
                        v-if="!isEmpty(row.item)"
                        :href="'/spools/' + row.item.id + '/empty'"
                        :title="'Mark filament spool `' + row.item.name + '` as empty'"
                        >Mark as Empty
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
</template>

<script>
import axios from 'axios';

import '../../../svg-icons/compiled/plus.js';
import '../../../svg-icons/compiled/details.js';
import '../../../svg-icons/compiled/actions.js';
import { moneyFormat, numberFormat } from '../helpers';

export default {
    props: {},

    data() {
        return {
            sortBy: 'name',
            sortDesc: false,
            fields: [
                { key: 'name', label: 'Name', sortable: true },
                { key: 'material', sortable: true },
                { key: 'price', label: 'Price per kg', sortable: false },
                { key: 'usage', label: 'Usage', sortable: false },
                { key: 'actions', label: '' },
            ],
            totalRows: 0,
            currentPage: 1,
            perPage: 10,
            collection: [],
            filter: {
                material: 'all',
                manufacturer: 'all',
            },
        };
    },

    mounted() {
        this.getCollection();
    },

    computed: {
        manufacturerFilterOptions() {
            return [...new Set(this.collection.map(item => item.manufacturer))].sort().map(f => {
                return { text: f, value: f };
            });
        },

        materialFilterOptions() {
            return [...new Set(this.collection.map(item => item.material))].sort().map(f => {
                return { text: f.toUpperCase(), value: f };
            });
        },
    },

    methods: {
        filterFunction(record) {
            return (
                (this.filter.material === 'all' || this.filter.material === record.material) &&
                (this.filter.manufacturer === 'all' ||
                    record.manufacturer === this.filter.manufacturer)
            );
        },

        spoolUsage(spool) {
            return +((spool.length.usage / spool.length.capacity) * 100).toFixed(2);
        },

        alertUsage(spool) {
            return this.spoolUsage(spool) >= 90 && this.spoolUsage(spool) < 100;
        },

        isEmpty(spool) {
            return this.spoolUsage(spool) === 100;
        },

        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },

        deleteInstance(id) {
            let conf = confirm('Do you really want to delete this filament spool?');
            let index = this.collection.findIndex(x => x.id === id);

            if (conf === true) {
                axios
                    .delete('/api/filamentspools/' + id)
                    .then(response => {
                        this.collection.splice(index, 1);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        getCollection: async function() {
            try {
                const response = await axios.get('/api/filamentspools');

                // Remap JSON:API data to simple array with objects as its elements
                let collectionData = response.data.data;

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
            } catch (error) {
                console.log(error);
                return [];
            }
        },

        moneyFormat,
        numberFormat,
    },
};
</script>
