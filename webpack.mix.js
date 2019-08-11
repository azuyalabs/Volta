const mix = require('laravel-mix');

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

mix.js('resources/assets/js/volta.js', 'public/js')
    .sass('resources/assets/sass/volta.scss', 'public/css')
    .sass('resources/assets/sass/error.scss', 'public/css')

    .js('resources/js/dashboard.js', 'public/js')
    .sass('resources/css/dashboard/dashboard.scss', 'public/css')

    .version();
