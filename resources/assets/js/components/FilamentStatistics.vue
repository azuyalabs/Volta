<template>
    <div class="container" v-if="spools.count > 0">
        <div>
            You have <strong>{{ numberFormat(spools.count, 0) }}</strong>
            <a href="/spools">spools</a> in stock, with a total weight of
            {{ numberFormat(spools.weight / 1000) }} kg and a value of
            {{ moneyFormat(spools.value) }}
        </div>
    </div>
    <div v-else>
        No filaments yet? Go ahead and <a href="/spools/create">register</a> yours right away!
    </div>
</template>

<script>
import { moneyFormat, numberFormat } from '../helpers';
import axios from 'axios';

export default {
    components: {},

    props: {},

    data() {
        return {
            spools: {
                count: 0,
                weight: 0,
                value: 0,
            },
            release_name: null,
            release_date: null,
        };
    },
    created() {
        axios.get('/spools/stats').then(response => {
            this.spools = response.data;
        });
    },

    methods: {
        moneyFormat,
        numberFormat,
    },
};
</script>
