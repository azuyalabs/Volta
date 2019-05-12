import Vue from 'vue';
import axios from 'axios';
import Routes from './routes';
import VueRouter from 'vue-router';

import BootstrapVue from 'bootstrap-vue';
import 'vue-awesome/icons';
import FilamentStatistics from './components/FilamentStatistics';
import EquipmentStatistics from './components/EquipmentStatistics';
import SlicerReleases from './components/SlicerReleases';
import CalibrationStatusCard from './components/CalibrationStatusCard';

import CollectionTableFilamentspools from './components/CollectionTableFilamentspools';
import CollectionTableMachines from './components/CollectionTableMachines';

import ThreeDPrinterJobs from './components/ThreeDPrinterJobs/ThreeDPrinterJobs';

import GCode from './components/GCode';
import VueI18n from 'vue-i18n';
import VueSVGIcon from 'vue-svgicon';
import Progress from 'vue-multiple-progress';

import Donut from 'vue-css-donut-chart';
import 'vue-css-donut-chart/dist/vcdonut.css';

Vue.use(Donut);

Vue.component('CollectionTable', require('./components/CollectionTable'));

Vue.component('IndexScreen', require('./components/IndexScreen'));
Vue.component('CreateScreen', require('./components/CreateScreen'));

Vue.component('HeatMap', require('./components/parts/HeatMap'));
Vue.component('PieChart', require('./components/parts/PieChart'));

require('bootstrap');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(VueI18n);
Vue.use(VueSVGIcon);
Vue.use(Progress);

//window.Popper = require('popper.js').default;

const router = new VueRouter({
    routes: Routes,
    mode: 'history',
    base: '/' + 'new' + '/',
});

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

// setup locale info for root Vue instance
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

new Vue({
    el: '#volta',

    router,

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

    components: {
        FilamentStatistics,
        EquipmentStatistics,
        SlicerReleases,
        CalibrationStatusCard,
        CollectionTableFilamentspools,
        CollectionTableMachines,
        GCode,
        ThreeDPrinterJobs,
    },
});
