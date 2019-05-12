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
    <index-screen
        :title="$t('index.title')"
        resource="products"
        :fields="fields"
        :sort-order="sortOrder"
    >
        <span slot="description" v-text="$t('index.description')" />
    </index-screen>
</template>

<script type="text/ecmascript-6">
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

}
</script>
