import Echo from 'laravel-echo';
import Vue from 'vue';
import VueI18n from 'vue-i18n';
import VueSVGIcon from 'vue-svgicon';
import Progress from 'vue-multiple-progress';

window.io = require('socket.io-client');

Vue.use(VueI18n);
Vue.use(VueSVGIcon);
Vue.use(Progress);

const i18n = new VueI18n({
    locale: window.Volta.locale,
    fallbackLocale: 'en-US',
});

new Vue({
    i18n,

    el: '#dashboard',

    components: {
        Dashboard: () =>
            import('./components/Dashboard/Dashboard' /* webpackChunkName: "js/dashboard/Dashboard" */),
        Placeholder: () =>
            import('./components/Dashboard/Placeholder' /* webpackChunkName: "js/dashboard/Placeholder" */),
        Volta: () =>
            import('./components/Dashboard/Volta' /* webpackChunkName: "js/dashboard/Volta" */),
        Clock: () =>
            import('./components/Dashboard/Clock' /* webpackChunkName: "js/dashboard/Clock" */),
        SlicerReleases: () =>
            import('./components/Dashboard/SlicerReleases' /* webpackChunkName: "js/dashboard/SlicerReleases" */),
        FirmwareReleases: () =>
            import('./components/Dashboard/FirmwareReleases' /* webpackChunkName: "js/dashboard/FirmwareReleases" */),
        Holidays: () =>
            import('./components/Dashboard/Holidays' /* webpackChunkName: "js/dashboard/Holidays" */),
        Printer: () =>
            import('./components/Dashboard/Printer' /* webpackChunkName: "js/dashboard/Printer" */),
        Weather: () =>
            import('./components/Dashboard/Weather' /* webpackChunkName: "js/dashboard/Weather" */),
    },

    created() {
        let options = {
            broadcaster: 'socket.io',
            host: window.Volta.local ? window.location.hostname + ':6001' : { path: '/socket.io' },
        };

        if (typeof window.io !== 'undefined') {
            this.echo = new Echo(options);
        }
    },
});
