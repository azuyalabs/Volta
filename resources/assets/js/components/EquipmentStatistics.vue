<template>
    <div class="container" v-if="machines.count > 0">
        You own
        <strong
            ><a href="/machines">{{ pluralize(machines.count, 'machine') }}</a></strong
        >, with a total value of {{ moneyFormat(machines.value) }}
    </div>
    <div v-else>
        What is a maker without any tools?
        <!-- Go ahead and <a href="/machines/create">create</a> one
        right away! -->
    </div>
</template>

<script>
import { moneyFormat, numberFormat, pluralize } from '../helpers';
import axios from 'axios';

export default {
    components: {},

    props: {},

    data() {
        return {
            machines: {},
        };
    },
    created() {
        axios.get('/machines/stats').then(response => {
            this.machines = response.data;
        });
    },

    methods: {
        moneyFormat,
        numberFormat,
        pluralize,
    },
};
</script>
