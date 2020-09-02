const path = require('path');
const ExtractCss = require('mini-css-extract-plugin');
const autoprefixer = require('autoprefixer');
const IgnoreEmitPlugin = require('ignore-emit-webpack-plugin');
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");

module.exports = {

        entry: './index.js',
        output: {
            path: path.resolve(__dirname, 'assets'),
            filename: 'main.js',
            publicPath: './',
        },

        module: {

            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: [
                        'babel-loader',
                    ]

                },
                {
                    test: /\.scss$/,
                    use: [
                        {
                            loader: ExtractCss.loader,
                        },

                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true,
                                url: false,
                            },
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                plugins: () => [autoprefixer()],
                                sourceMap: true,
                            },
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true,
                            },
                        },
                    ],
                },
            ],
        },

    optimization: {
        minimizer: [
            new OptimizeCSSAssetsPlugin({
                cssProcessorPluginOptions: {
                    preset: ['default', { discardComments: { removeAll: true } }],
                }
            })
        ]
    },

        stats: 'minimal',

        plugins:[
            new ExtractCss({
                filename: 'css/dist.css',
            }),
            new IgnoreEmitPlugin(/main\.js.*$/)
        ],
};
