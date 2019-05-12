<template>
    <index-screen
        :title="$t('index.title')"
        resource="manufacturers"
        :fields="fields"
        :sort-order="sortOrder"
    >
        <span slot="description" v-text="$t('index.description')" />

        <template slot="custom_1" slot-scope="rowData">
            <b-badge
                class="text-uppercase"
                variant="primary"
                v-b-tooltip.hover
                :title="$t('fields.is_filament_supplier.tooltip')"
                v-if="rowData.data.filament_supplier == 1"
                >{{ $t('filament') }}
            </b-badge>

            <b-badge
                class="text-uppercase"
                variant="info"
                v-b-tooltip.hover
                :title="$t('fields.is_equipment_supplier.tooltip')"
                v-if="rowData.data.equipment_supplier == 1"
                >{{ $t('equipment') }}
            </b-badge>
        </template>
    </index-screen>
</template>

<script>
import fieldDefs from './fieldDefs.js';

export default {
    i18n: require('./i18n.js'),

    data() {
        return {
            sortOrder: [
                {
                    field: 'name',
                    direction: 'asc',
                },
            ],
            fields: fieldDefs(this.$i18n),
        };
    },
};
</script>
