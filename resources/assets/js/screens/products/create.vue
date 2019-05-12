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
    <create-screen resource="products" :title="$t('create.title')">
        <b-form
            class="mt-3"
            id="product"
            @submit="onSubmit"
            @reset="onReset"
            slot="form"
            v-if="show"
        >
            <b-form-group
                id="name"
                label-for="name"
                label-class="control-label-v"
                horizontal
                :label="$t('fields.name.text')"
                :description="$t('fields.name.description')"
            >
                <b-form-input
                    id="name"
                    type="text"
                    v-model="form.name"
                    required
                    placeholder="Product name"
                    class="col-md-8"
                    :class="{ 'is-invalid': errors.name }"
                >
                </b-form-input>
                <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
            </b-form-group>

            <b-form-group
                id="manufacturer"
                label-for="manufacturer"
                label-class="control-label-v"
                horizontal
                :label="$t('fields.manufacturer.text')"
                :description="$t('fields.manufacturer.description')"
            >
                <b-form-select
                    id="manufacturer"
                    :options="manufacturers"
                    required
                    v-model="form.manufacturer"
                    class="col-md-6"
                >
                </b-form-select>
            </b-form-group>

            <div class="form-group mt-5 row justify-content-end">
                <div class="col-md-offset-4 col-md-4">
                    <b-button type="submit" variant="primary">{{ $t('actions.submit') }}</b-button>
                    <b-button type="reset" variant="danger">{{ $t('actions.reset') }}</b-button>
                </div>
            </div>
        </b-form>
    </create-screen>
</template>

<script>
import axios from 'axios';

export default {
    i18n: require('./i18n.js'),

    data() {
        return {
            form: {
                name: '',
                manufacturer: '',
                class: 'machine',
            },
            errors: [],
            success: false,
            manufacturers: [],
            show: true,
        };
    },

    created() {
        axios.get('/api/meta/manufacturers').then(response => {
            this.manufacturers = response.data;
        });
    },

    methods: {
        onSubmit(evt) {
            evt.preventDefault();

            axios
                .post('/api/products', this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$router.push('/products');
                    }
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    this.success = false;
                });
        },

        onReset(evt) {
            evt.preventDefault();

            this.clearForm();
            this.errors = [];
            this.success = true;

            /* Trick to reset/clear native browser form validation state */
            this.show = false;
            this.$nextTick(() => {
                this.show = true;
            });
        },

        clearForm() {
            for (let key in this.form) {
                this.form[key] = null;
            }
        },
    },
};
</script>
