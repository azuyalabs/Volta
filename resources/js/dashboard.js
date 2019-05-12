import Echo from 'laravel-echo';
import Vue from 'vue';
import VueI18n from 'vue-i18n';
import VueSVGIcon from 'vue-svgicon';
import Progress from 'vue-multiple-progress';

window.io = require('socket.io-client');

Vue.use(VueI18n);
Vue.use(VueSVGIcon);
Vue.use(Progress);

// Import Vue Components
Vue.component('Dashboard', require('./components/Dashboard/Dashboard.vue'));
Vue.component('Placeholder', require('./components/Dashboard/Placeholder.vue'));
Vue.component('Volta', require('./components/Dashboard/Volta.vue'));
Vue.component('SlicerReleases', require('./components/Dashboard/SlicerReleases.vue'));
Vue.component('FirmwareReleases', require('./components/Dashboard/FirmwareReleases.vue'));
Vue.component('Holidays', require('./components/Dashboard/Holidays.vue'));
Vue.component('Printer', require('./components/Dashboard/Printer.vue'));
Vue.component('Weather', require('./components/Dashboard/Weather.vue'));
Vue.component('Clock', require('./components/Dashboard/Clock'));

const i18n = new VueI18n({
    locale: window.Volta.locale,
    fallbackLocale: 'en-US',
});

new Vue({
    i18n,

    el: '#dashboard',

    components: {},

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
