const mix = require('laravel-mix');
const path = require('path');
const del = require('del');



/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
//clear
del.sync(['public/media/*', 'public/excel/*']);

//media
mix.copyDirectory('resources/assets/media/', 'public/media/');
// mix.copyDirectory('resources/assets/excel/', 'public/excel/');

//JS - CSS
mix.js('resources/js/app.js', 'public/js').vue();
mix.sass('resources/js/src/assets/sass/style.vue.scss', 'public/css');

//Non-application pages [public/css/single-page/*]
mix.sass('resources/assets/sass/auth/base.scss', 'public/css/single-page/auth');

mix.webpackConfig({
    output: {
        chunkFilename: `js/[name].js?id=[chunkhash]`
    },
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.runtime.esm.js',
            '@': path.resolve(__dirname, 'resources/js/src/')
        }
    }
});
