<template>
    <div>
        <!-- User Controls -->
        <div class="d-flex">
            <div class="p-2">
                <b-link
                    href="/machines/create"
                    class="btn btn-primary btn-sm text-uppercase"
                    title="Add a new Machine"
                >
                    <svgicon icon="plus" class="button-icon-sm" color="#fff"></svgicon>
                    add
                </b-link>
            </div>
            <div class="ml-auto p-2">
                <b-form-group horizontal>
                    <b-input-group>
                        <b-form-input v-model="filter" placeholder="Search..." />
                        <b-input-group-append>
                            <b-btn :disabled="!filter" @click="filter = ''">Clear</b-btn>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </div>
        </div>

        <!-- Table -->
        <b-table
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            :filter="filter"
            :items="collection"
            :fields="fields"
            :current-page="currentPage"
            :per-page="perPage"
            @filtered="onFiltered"
            class="volta"
        >
            <template slot="name" slot-scope="row">
                <b-link @click.stop="row.toggleDetails">{{ row.value }}</b-link>
            </template>

            <template slot="hourlyRate" slot-scope="row"
                >{{ moneyFormat(row.value) }}
            </template>

            <template slot="details" slot-scope="row">
                <b-link @click.stop="row.toggleDetails" title="View more details">
                    <svgicon
                        icon="details"
                        class="action-icon-sm"
                        :class="{ 'svg-right': row.detailsShowing }"
                    ></svgicon>
                </b-link>
            </template>

            <template slot="actions" slot-scope="row">
                <b-dropdown variant="link" size="sm" no-caret>
                    <template slot="button-content">
                        <svgicon
                            v-b-tooltip.hover
                            title="More actions"
                            icon="actions"
                            class="action-icon-md"
                        ></svgicon>
                    </template>
                    <b-dropdown-item
                        :href="'/machines/' + row.item.id + '/edit'"
                        :title="'Edit machine `' + row.item.name + '`'"
                        >Edit
                    </b-dropdown-item>
                    <b-dropdown-item
                        @click.stop="deleteInstance(row.item.id)"
                        href="#"
                        :title="'Delete machine `' + row.item.name + '`'"
                        >Delete
                    </b-dropdown-item>
                </b-dropdown>
            </template>

            <template slot="extra" slot-scope="row">
                <b-badge
                    pill
                    variant="success"
                    v-if="row.item.reference_id"
                    v-b-tooltip.hover
                    title="Paired with OctoPrint"
                    >OctoPrint
                </b-badge>
            </template>
            <template slot="status" slot-scope="row">
                <status-indicator
                    v-if="isActive(row.item)"
                    active
                    v-b-tooltip.hover
                    title="Ready"
                ></status-indicator>
                <status-indicator
                    v-if="isRunning(row.item)"
                    positive
                    pulse
                    v-b-tooltip.hover
                    title="Printing in progress..."
                ></status-indicator>
                <status-indicator
                    v-if="isPaused(row.item)"
                    intermediary
                    v-b-tooltip.hover
                    title="Paused"
                ></status-indicator>
                <status-indicator
                    v-if="isOffline(row.item)"
                    negative
                    v-b-tooltip.hover
                    title="Offline / Disconnected"
                ></status-indicator>
                <status-indicator
                    v-if="isUnknown(row.item)"
                    v-b-tooltip.hover
                    title="Unknown"
                ></status-indicator>
            </template>

            <template slot="row-details" slot-scope="row">
                <b-card class="collection-row-detail">
                    <div class="d-flex justify-content-start">
                        <div class="p-2">
                            <table class="table detail-table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Lifespan</th>
                                        <td>{{ row.item.lifespan }} years</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Operating Hours</th>
                                        <td>{{ row.item.operating_hours }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Energy Consumption</th>
                                        <td>{{ row.item.energy_consumption }} W</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="p-2 pl-4">
                            <table class="table detail-table">
                                <tr class="money">
                                    <th>Acquisition Cost</th>
                                    <td>{{ moneyFormat(row.item.acquisition_cost) }}</td>
                                </tr>
                                <tr class="money">
                                    <th scope="row">Residual Value</th>
                                    <td>{{ moneyFormat(row.item.residual_value) }}</td>
                                </tr>
                                <tr class="money">
                                    <th scope="row">Maintenance Cost</th>
                                    <td>{{ moneyFormat(row.item.maintenance_cost) }}</td>
                                </tr>
                                <tr class="money">
                                    <th scope="row">Total Lifetime Cost</th>
                                    <th class="footer">
                                        {{ moneyFormat(row.item.lifetime_cost) }}
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </b-card>
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

import '../../../svg-icons/compiled/square_down.js';
import '../../../svg-icons/compiled/plus.js';
import '../../../svg-icons/compiled/details.js';
import '../../../svg-icons/compiled/delete.js';
import '../../../svg-icons/compiled/edit.js';
import '../../../svg-icons/compiled/actions.js';
import { moneyFormat } from '../helpers';

import { StatusIndicator } from 'vue-status-indicator';

export default {
    components: {
        StatusIndicator,
    },

    props: {},

    data() {
        return {
            sortBy: 'name',
            sortDesc: false,
            fields: [
                { key: 'details', label: '' },
                { key: 'name', label: 'Name', sortable: true },
                { key: 'model', sortable: true },
                {
                    key: 'hourlyRate',
                    label: 'Cost per hour',
                    sortable: false,
                },
                { key: 'actions', label: '' },
                { key: 'extra', label: '' },
                { key: 'status', label: 'Status', class: 'text-center' },
            ],
            filter: null,
            totalRows: 0,
            currentPage: 1,
            perPage: 5,
            collection: [],
        };
    },

    mounted() {
        this.getCollection();

        setInterval(this.getCollection, 20 * 1000);
    },

    methods: {
        isActive(machine) {
            return !!(
                machine.reference_id &&
                ['cancelling', 'operational', 'finishing'].includes(machine.status)
            );
        },

        isRunning(machine) {
            return !!(machine.reference_id && ['printing', 'resuming'].includes(machine.status));
        },

        isPaused(machine) {
            return !!(machine.reference_id && ['paused', 'pausing'].includes(machine.status));
        },

        isOffline(machine) {
            return !!(machine.reference_id && machine.status === 'offline');
        },

        isUnknown(machine) {
            return !!(machine.reference_id && !machine.status);
        },

        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },

        deleteInstance(id) {
            let conf = confirm('Do you really want to delete this machine?');
            let index = this.collection.findIndex(x => x.id === id);

            if (conf === true) {
                axios
                    .delete('/api/machines/' + id)
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
                const response = await axios.get('/api/machines');

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
            } catch (error) {
                console.log(error);
                return [];
            }
        },

        moneyFormat,
    },
};
</script>
