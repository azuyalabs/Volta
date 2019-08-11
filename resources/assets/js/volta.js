/*
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2019. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

import Vue from 'vue';
import axios from 'axios';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import VueI18n from 'vue-i18n';
import VueSVGIcon from 'vue-svgicon';
import Progress from 'vue-multiple-progress';
import Donut from 'vue-css-donut-chart';
import 'vue-css-donut-chart/dist/vcdonut.css';
import VueApexCharts from 'vue-apexcharts';

Vue.use(Donut);
Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(VueI18n);
Vue.use(VueSVGIcon);
Vue.use(Progress);

// Common Components
Vue.component('CollectionTable', require('./components/CollectionTable'));
Vue.component('IndexScreen', require('./components/IndexScreen'));
Vue.component('CreateScreen', require('./components/CreateScreen'));
Vue.component('apexchart', VueApexCharts);

// Page specific components
// TODO: Eligible for dynamic import, but Laravel Mix v4 has some issues with dynamic imports, chunking.
Vue.component(
    'CollectionTableFilamentspools',
    require('./components/CollectionTableFilamentspools').default
);
Vue.component('SlicerReleases', require('./components/SlicerReleases').default);
Vue.component('CalibrationStatusCard', require('./components/CalibrationStatusCard').default);
Vue.component('CollectionTableMachines', require('./components/CollectionTableMachines').default);
Vue.component('GCode', require('./components/GCode').default);
Vue.component(
    'ThreeDPrinterJobs',
    require('./components/ThreeDPrinterJobs/ThreeDPrinterJobs').default
);
Vue.component(
    'SuccessratePieChart',
    require('./components/ThreeDPrinterJobs/SuccessratePieChart').default
);
Vue.component(
    'ActivityHistogram',
    require('./components/ThreeDPrinterJobs/ActivityHistogram').default
);
Vue.component(
    'ThreeDPrinterJobsHeatmap',
    require('./components/ThreeDPrinterJobs/Heatmap').default
);
Vue.component(
    'ManufacturersTable',
    require('./components/Manufacturers/ManufacturersTable').default
);
Vue.component('News', require('./components/News/News').default);
Vue.component(
    'ThingiverseFeatured',
    require('./components/ThingiverseFeatured/ThingiverseFeatured').default
);

require('bootstrap');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const numberFormats = {
    'en-US': {
        currency: {
            style: 'currency',
            currency: 'USD',
        },
    },
    'ja-JP': {
        currency: {
            style: 'currency',
            currency: 'JPY',
            currencyDisplay: 'symbol',
        },
    },
};

// Setup locale info for root Vue instance
const i18n = new VueI18n({
    locale: window.Volta.locale,
    messages: {
        'en-US': {
            actions: {
                back: 'Back',
                submit: 'Submit',
                reset: 'Reset',
                more: 'More actions',
                add: 'Add',
                clear: 'Clear',
                search_ellipsis: 'Search...',
                add_resource: 'Add a new {resource}',
                edit_resource: 'Edit {resource} `{name}`',
                delete_resource: 'Delete {resource} `{name}`',
            },
            confirm: {
                delete: 'Do you really want to delete this {resource}?',
            },
            resources: {
                manufacturers: 'manufacturer | manufacturers',
                products: 'product | products',
            },
        },
    },
    numberFormats,
});

Vue.filter('uppercase_first', function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

// Vue Instance
new Vue({
    el: '#volta',

    i18n,

    data() {
        return {
            dismissCountDown: 0,
        };
    },

    methods: {
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown;
        },
    },
});
