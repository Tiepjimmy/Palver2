const mix = require('laravel-mix')
const path = require('path')
const del = require('del')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const prod = process.env.NODE_ENV === 'production'
const relativePath = prod === true ? '' : 'dev'
const publicPath = `../../public/${relativePath}`

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

mix.setPublicPath(`${publicPath}/`)

//clear
// del.sync([`${publicPath}/media/*`, `${publicPath}/excel/*`]);

//media
//mix.copyDirectory('resources/assets/media/', `${publicPath}/media/`);
//mix.copyDirectory('resources/assets/excel/', `${publicPath}/excel/`);

//JS - CSS
mix.js('src/app.js', `${publicPath}/js`).vue();
mix.sass('src/assets/sass/app.scss', `${publicPath}/css`);
mix.version();

//Non-application pages [public/css/single-page/*]
// mix.sass('resources/assets/sass/auth/base.scss', `${publicPath}/css/single-page/auth`);

mix.webpackConfig({
    plugins: [
        // Clearing public/js file -> bug on laravel-mix when we using version and files are not removed
        // eslint-disable-next-line no-undef
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: [
                prod === true ? 'js/*' : 'dev/*',
            ]
        })
    ],
    // entry: path.resolve(__dirname, 'resources/js/src/main.js'),
    output: {
        // Chunks in webpack
        publicPath: prod === true ? '/' : `/${  relativePath  }/`,
        chunkFilename: !prod ? 'js/[id].js' : 'js/[name].bundle.[chunkhash].js'
    },
    resolve: {
        extensions: ['.js', '.ts', '.vue', '.json'],
        alias: {
            'vue$': 'vue/dist/vue.runtime.esm.js',
            '@': path.resolve(__dirname, 'src')
        }
    },
    optimization: {
        // runtimeChunk: 'single',
        splitChunks: {
            chunks: 'initial',
            maxInitialRequests: Infinity,
            minSize: 0,
            cacheGroups: {
                vueVendor: {
                    test: /[\\/]node_modules[\\/](metronic|vuetify|vue-materia|portal-vue|bootstrap-vue|highlight-js)[\\/]/,
                    name: "js/vendor",
                },
                utilityVendor: {
                    test: /[\\/]node_modules[\\/](lodash|moment|moment-timezone|vue-i18n|formvalidation|vee-validate)[\\/]/,
                    name: "js/utility"
                },
            },
        },
    }
});
