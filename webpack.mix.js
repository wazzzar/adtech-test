const mix = require('laravel-mix');
require('vue-loader');
const webpack = require('webpack');

mix.js('resources/js/app.js', 'public/build/js')
    .vue({ version: 3 })
    .postCss('resources/css/app.css', 'public/build/css')
    .webpackConfig({
        plugins: [
            new webpack.DefinePlugin({
                __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: 'false',
                __VUE_OPTIONS_API__: 'true',
            }),
        ],
    });
