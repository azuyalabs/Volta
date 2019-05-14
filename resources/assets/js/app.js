import Vue from 'vue';
import axios from 'axios';
import Routes from './routes';
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

Vue.component('CollectionTable', require('./components/CollectionTable'));
Vue.component('IndexScreen', require('./components/IndexScreen'));
Vue.component('CreateScreen', require('./components/CreateScreen'));
Vue.component('apexchart', VueApexCharts);

require('bootstrap');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

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
        SlicerReleases: () =>
            import('./components/SlicerReleases' /* webpackChunkName: "js/app/SlicerReleases" */),
        CalibrationStatusCard: () =>
            import(
                './components/CalibrationStatusCard' /* webpackChunkName: "js/app/CalibrationStatusCard" */
            ),
        CollectionTableFilamentspools: () =>
            import(
                './components/CollectionTableFilamentspools' /* webpackChunkName: "js/app/CollectionTableFilamentspools" */
            ),
        CollectionTableMachines: () =>
            import(
                './components/CollectionTableMachines' /* webpackChunkName: "js/app/CollectionTableMachines" */
            ),
        GCode: () => import('./components/GCode' /* webpackChunkName: "js/app/GCode" */),
        ThreeDPrinterJobs: () =>
            import(
                './components/ThreeDPrinterJobs/ThreeDPrinterJobs' /* webpackChunkName: "js/app/ThreeDPrinterJobs/ThreeDPrinterJobs" */
            ),
        SuccessratePieChart: () =>
            import(
                './components/ThreeDPrinterJobs/SuccessratePieChart' /* webpackChunkName: "js/app/ThreeDPrinterJobs/SuccessratePieChart" */
            ),
        ActivityHistogram: () =>
            import(
                './components/ThreeDPrinterJobs/ActivityHistogram' /* webpackChunkName: "js/app/ThreeDPrinterJobs/ActivityHistogram" */
            ),
        ThreeDPrinterJobsHeatmap: () =>
            import(
                './components/ThreeDPrinterJobs/Heatmap' /* webpackChunkName: "js/app/ThreeDPrinterJobs/Heatmap" */
            ),
        ManufacturersTable: () =>
            import(
                './components/Manufacturers/ManufacturersTable' /* webpackChunkName: "js/app/Manufacturers/ManufacturersTable" */
            ),
        News: () => import('./components/News/News' /* webpackChunkName: "js/app/News/News" */),
        ThingiverseFeatured: () =>
            import(
                './components/ThingiverseFeatured/ThingiverseFeatured' /* webpackChunkName: "js/app/ThingiverseFeatured/ThingiverseFeatured" */
            ),
    },
});
