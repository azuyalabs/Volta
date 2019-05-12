<template>
    <create-screen resource="manufacturers" :title="$t('edit.title')">
        <b-form
            class="mt-3"
            id="manufacturer"
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
                    placeholder="MakerMake Ltd."
                    class="col-md-8"
                    :class="{ 'is-invalid': errors.name }"
                >
                </b-form-input>
                <div v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</div>
            </b-form-group>
            <b-form-group
                id="website"
                label-for="website"
                label-class="control-label-v"
                horizontal
                :label="$t('fields.website.text')"
                :description="$t('fields.name.description')"
            >
                <b-form-input
                    id="website"
                    type="text"
                    v-model="form.website"
                    placeholder="https://www.makermake.com"
                    class="col-md-8"
                    :class="{ 'is-invalid': errors.website }"
                >
                </b-form-input>
                <div v-if="errors.website" class="invalid-feedback">{{ errors.website[0] }}</div>
            </b-form-group>
            <b-form-group
                id="country"
                label-for="country"
                label-class="control-label-v"
                horizontal
                :label="$t('fields.country.text')"
                :description="$t('fields.country.description')"
            >
                <b-form-select
                    id="country"
                    :options="countries"
                    required
                    v-model="form.country"
                    class="col-md-6"
                >
                </b-form-select>
            </b-form-group>

            <b-form-group
                id="_filament_supplier"
                label-for="filament_supplier"
                label-class="control-label-v"
                horizontal
                :description="$t('fields.is_filament_supplier.description')"
            >
                <b-form-checkbox
                    id="filament_supplier"
                    v-model="form.filament_supplier"
                    value="1"
                    unchecked-value="0"
                    >{{ $t('fields.is_filament_supplier.text') }}
                </b-form-checkbox>
            </b-form-group>

            <b-form-group
                id="_equipment_supplier"
                label-for="equipment_supplier"
                label-class="control-label-v"
                horizontal
                :description="$t('fields.is_equipment_supplier.description')"
            >
                <b-form-checkbox
                    id="equipment_supplier"
                    v-model="form.equipment_supplier"
                    value="1"
                    unchecked-value="0"
                    >{{ $t('fields.is_equipment_supplier.text') }}
                </b-form-checkbox>
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
                country: {
                    code: '',
                    name: '',
                },
                website: '',
                filament_supplier: 0,
                equipment_supplier: 0,
            },
            errors: [],
            success: false,
            countries: [],
            show: true,
        };
    },

    created() {
        axios.get('/api/meta/countries').then(response => {
            this.countries = response.data;
        });

        axios.get('/api/manufacturers/' + this.$route.params.id).then(response => {
            this.form = response.data.data.attributes;
        });
    },

    methods: {
        onSubmit(evt) {
            evt.preventDefault();

            axios
                .patch('/api/manufacturers/' + this.$route.params.id, this.form)
                .then(response => {
                    if (response.data.success) {
                        this.$router.push('/manufacturers');
                    }
                })
                .catch(error => {
                    console.log(error.response.data);
                    this.errors = error.response.data.errors;
                    this.success = false;
                });
        },

        onReset(evt) {
            evt.preventDefault();

            //this.clearForm();
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
