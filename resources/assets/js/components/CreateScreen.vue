<template>
    <div>
        <div class="row">
            <div class="col-md-12 d-flex">
                <h1 class="display-5">{{ title }}</h1>
                <div class="ml-auto">
                    <b-button variant="secondary" :to="'/' + resource">
                        <svgicon icon="details" class="button-icon" />
                        {{ $t('actions.back') }}
                    </b-button>
                </div>
            </div>
        </div>
        <div class="card-collection card mt-3">
            <div class="card-body">
                <slot name="form" />
            </div>
        </div>
    </div>
</template>

<script>
import '../../../svg-icons/compiled/details.js';

export default {
    props: ['resource', 'title'],

    mounted() {
        document.title = this.title + ' - Volta';
    },
};
</script>
