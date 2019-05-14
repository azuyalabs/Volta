let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')

    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/error.scss', 'public/css')

    .js('resources/js/dashboard.js', 'public/js')
    .postCss('resources/css/dashboard.css', 'public/css')

    .version()
    .options({
        processCssUrls: false,
        postCss: [require('postcss-easy-import')],
    });

mix.extract([
    'vue',
    'axios',
    'moment',
    'moment-duration-format',
    'moment-timezone',
    'laravel-echo',
    'epic-spinners',
    'dinero.js',
    'mathjs',
    'socket.io-client',
    'vue-calendar-heatmap',
    'vue-i18n',
    'vue-router',
    'vuetable-2',
]);
