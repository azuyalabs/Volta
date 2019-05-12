<template>
    <div class="d-flex">
        <div class="p-2">
            <b-link
                :href="resource + '/create'"
                class="btn btn-primary btn-sm text-uppercase"
                :title="$t('actions.add_resource', { resource: $tc('resources.' + resource, 1) })"
            >
                <svgicon icon="plus" class="button-icon-sm" color="#fff"></svgicon>
                {{ $t('actions.add') }}
            </b-link>
        </div>
        <div class="ml-auto p-2">
            <b-form-group horizontal>
                <b-input-group>
                    <b-form-input
                        v-model="filterText"
                        :placeholder="$t('actions.search_ellipsis')"
                    />
                    <b-input-group-append>
                        <b-btn :disabled="!filterText" @click="resetFilter"
                            >{{ $t('actions.clear') }}
                        </b-btn>
                    </b-input-group-append>
                </b-input-group>
            </b-form-group>
        </div>
    </div>
</template>

<script>
export default {
    props: ['resource'],

    data() {
        return {
            filterText: '',
        };
    },

    watch: {
        filterText: function() {
            this.$events.fire('filter-set', this.filterText);
        },
    },

    methods: {
        resetFilter() {
            this.filterText = '';
            this.$events.fire('filter-reset');
        },
    },
};
</script>
