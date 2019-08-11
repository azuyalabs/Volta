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
import Echo from 'laravel-echo';
import VueI18n from 'vue-i18n';
import VueSVGIcon from 'vue-svgicon';
import Progress from 'vue-multiple-progress';

window.io = require('socket.io-client');

Vue.use(VueI18n);
Vue.use(VueSVGIcon);
Vue.use(Progress);

// Page specific components
// TODO: Eligible for dynamic import, but Laravel Mix v4 has some issues with dynamic imports, chunking.
Vue.component('Dashboard', require('./components/Dashboard/Dashboard').default);
Vue.component('Placeholder', require('./components/Dashboard/Placeholder').default);
Vue.component('Volta', require('./components/Dashboard/Volta').default);
Vue.component('Clock', require('./components/Dashboard/Clock').default);
Vue.component('SlicerReleases', require('./components/Dashboard/SlicerReleases').default);
Vue.component('FirmwareReleases', require('./components/Dashboard/FirmwareReleases').default);
Vue.component('Holidays', require('./components/Dashboard/Holidays').default);
Vue.component('Printer', require('./components/Dashboard/Printer').default);
Vue.component('Weather', require('./components/Dashboard/Weather').default);

const i18n = new VueI18n({
    locale: window.Volta.locale,
    fallbackLocale: 'en-US',
});

new Vue({
    i18n,

    el: '#dashboard',

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
