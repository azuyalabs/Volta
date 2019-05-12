<template>
    <div>
        <div class="row">
            <div class="col-md-12 d-flex">
                <h1 class="display-5">{{ this.title }}</h1>
            </div>
            <p class="col-md-12 text-muted text-uppercase small">
                <slot name="description" />
            </p>
        </div>
        <div class="card-collection card">
            <div class="card-body">
                <filter-bar :resource="resource"></filter-bar>
                <vuetable
                    ref="vuetable"
                    :api-url="'/api/' + resource"
                    :fields="fields"
                    data-path="resourcedata"
                    :append-params="moreParams"
                    pagination-path="pagination"
                    :http-options="http_options"
                    :sort-order="sortOrder"
                    @vuetable:pagination-data="onPaginationData"
                >
                    <template slot="actions" slot-scope="props">
                        <b-dropdown variant="link" size="sm" no-caret>
                            <template slot="button-content">
                                <svgicon
                                    v-b-tooltip.hover
                                    :title="$t('actions.more')"
                                    icon="actions"
                                    class="action-icon-md"
                                ></svgicon>
                            </template>
                            <b-dropdown-item
                                :href="resource + '/' + props.rowData.id + '/edit'"
                                :title="
                                    $t('actions.edit_resource', {
                                        resource: $tc('resources.' + resource, 1),
                                        name: props.rowData.name,
                                    })
                                "
                                >Edit
                            </b-dropdown-item>
                            <b-dropdown-item
                                @click.stop="deleteInstance(props.rowData.id, props.rowIndex)"
                                href="#"
                                :title="
                                    $t('actions.delete_resource', {
                                        resource: $tc('resources.' + resource, 1),
                                        name: props.rowData.name,
                                    })
                                "
                                >Delete
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>

                    <template slot="custom_field_1" slot-scope="props">
                        <slot name="custom_1" v-bind:data="props.rowData"></slot>
                    </template>
                </vuetable>
                <div class="d-flex">
                    <vuetable-pagination-info ref="paginationInfo" />
                    <vuetable-pagination
                        class="ml-auto"
                        ref="pagination"
                        @vuetable-pagination:change-page="onChangePage"
                        :css="css.pagination"
                    ></vuetable-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vuetable from 'vuetable-2/src/components/Vuetable';
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination';
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo';
import FilterBar from './parts/FilterBar';
import axios from 'axios';

import Vue from 'vue';
import VueEvents from 'vue-events';

Vue.use(VueEvents);

export default {
    props: ['resource', 'title', 'fields', 'sort-order'],

    components: {
        Vuetable,
        VuetablePagination,
        VuetablePaginationInfo,
        FilterBar,
    },

    /**
     * The component's data.
     */
    data() {
        return {
            filterText: '',
            moreParams: {},
            http_options: {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                },
            },
            css: {
                table: {
                    ascendingIcon: 'glyphicon glyphicon-chevron-up',
                    descendingIcon: 'glyphicon glyphicon-chevron-down',
                },
                pagination: {
                    infoClass: 'pull-left',
                    wrapperClass: 'vuetable-pagination pull-right',
                    activeClass: 'btn-primary',
                    disabledClass: 'disabled',
                    pageClass: 'btn',
                    linkClass: 'btn',
                    icons: {
                        first: '',
                        prev: '',
                        next: '',
                        last: '',
                    },
                },
            },
        };
    },

    /**
     * Prepare the component.
     */
    mounted() {
        document.title = this.title + ' - Volta';

        this.$events.$on('filter-set', eventData => this.onFilterSet(eventData));
        this.$events.$on('filter-reset', e => this.onFilterReset());
    },

    methods: {
        transform: function(data) {
            let transformed = {};

            transformed.pagination = {
                total: data.meta.total,
                per_page: data.meta.per_page,
                current_page: data.meta.current_page,
                last_page: data.meta.last_page,
                next_page_url: data.meta.next_page_url,
                prev_page_url: data.meta.prev_page_url,
                from: data.meta.from,
                to: data.meta.to,
            };

            transformed.resourcedata = [];

            // Remap JSON:API data to simple array with objects as its elements
            let collectionData = data.data;

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
                transformed.resourcedata.push(o);
            }

            return transformed;
        },

        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData);
            this.$refs.paginationInfo.setPaginationData(paginationData);
        },

        onChangePage(page) {
            this.$refs.vuetable.changePage(page);
        },

        onFilterSet(filterText) {
            this.moreParams = {
                filter: filterText,
            };
            Vue.nextTick(() => this.$refs.vuetable.refresh());
        },

        onFilterReset() {
            this.moreParams = {};
            Vue.nextTick(() => this.$refs.vuetable.refresh());
        },

        deleteInstance(id) {
            let conf = confirm(
                this.$t('confirm.delete', { resource: this.$tc('resources.' + this.resource, 1) })
            );

            if (conf === true) {
                axios
                    .delete('/api/' + this.resource + '/' + id)
                    .then(response => {
                        this.moreParams = {};
                        Vue.nextTick(() => this.$refs.vuetable.reload());
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
    },
};
</script>
