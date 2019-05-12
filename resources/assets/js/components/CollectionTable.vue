<template>
    <div>
        <!-- User Controls -->
        <div class="d-flex">
            <div class="p-2">
                <b-link
                    :href="model + '/create'"
                    class="btn btn-primary btn-sm text-uppercase"
                    title="Add a new Spool"
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
        >
            <template slot="name" slot-scope="row">
                <b-link :href="'/spools/' + row.item.id">{{ row.value }}</b-link>
            </template>

            <template slot="material" slot-scope="row"
                ><span class="text-uppercase">{{ row.item.material }}</span>
            </template>

            <template slot="diameter" slot-scope="row"
                >{{ row.item.diameter }}
            </template>

            <template slot="price" slot-scope="row"
                >{{ moneyFormat(row.item.unitPrice.volume) }}
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
                        :href="'/spools/' + row.item.id + '/edit'"
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

export default {
    props: {
        model: {
            type: String,
            required: true,
        },
    },

    data() {
        return {
            sortBy: 'name',
            sortDesc: false,
            fields: [
                { key: 'name', label: 'Name', sortable: true },
                { key: 'manufacturer', label: 'Manufacturer', sortable: true },
                { key: 'material', sortable: true },
                { key: 'diameter', sortable: true },
                { key: 'price', sortable: false },
                { key: 'actions', label: '' },
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
    },

    methods: {
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
    },
};
</script>
