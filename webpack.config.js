const path = require('path');

// include the js minification plugin
const TerserPlugin = require("terser-webpack-plugin");

// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const BundleAnalyzerPlugin =
    require("webpack-bundle-analyzer").BundleAnalyzerPlugin


module.exports = {
    entry: ['./resources/js/app.js', './resources/css/app.scss'],
    output: {
        filename: './build/js/app.min.js',
        path: path.resolve(__dirname),
        publicPath: '/'
    },
    module: {
        rules: [
            // perform js babelization on all .js files
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: ['babel-preset-env']
                    }
                }
            },
            // compile all .scss files to plain old css
            {
                test: /\.(sass|scss)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        // Use the css-loader to parse and minify CSS imports.
                        loader: 'css-loader',
                        options: {
                            sourceMap: true,
                            url: false,
                        }
                    }, 
                    'sass-loader'
                ]
            }
        ],
    },
    plugins: [
        // extract css into dedicated file
        new MiniCssExtractPlugin({
            filename: './build/css/app.min.css'
        }),
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: ['./build/js/*', './build/css/*']
        }),
        new CopyWebpackPlugin(
            {
                patterns: [
                    {from: './resources/images', to: './build/images'},
                    {from: './resources/css/fonts', to: './build/fonts'},
                ]
            }
        ),
        new BundleAnalyzerPlugin()
    ],
    optimization: {
        minimizer: [
            // enable the js minification plugin
            new TerserPlugin(),
            // enable the css minification plugin
            new CssMinimizerPlugin(),
        ]
    }
};