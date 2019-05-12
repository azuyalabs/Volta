<template>
    <span>{{ formattedValue }}</span>
</template>

<script>
import { moneyFormat } from '../../helpers';

export default {
    props: {
        value: {
            required: true,
            type: [Number, String],
            default: 0,
        },
        currency: {
            required: true,
            type: [String],
            default: 'USD',
        },
    },

    data() {
        return {
            formattedValue: '',
        };
    },

    methods: {
        moneyFormat,
    },

    created() {
        this.formattedValue = moneyFormat(this.value, this.currency);
    },
};
</script>
