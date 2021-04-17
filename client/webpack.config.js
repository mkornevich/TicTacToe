const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = {
    mode: "development",
    entry: path.resolve(__dirname, 'src/app/main.js'),
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: '[name].[contenthash].bundle.js'
    },
    module: {
        rules: [
            {
                test: /\.m?js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                        plugins: ['@babel/plugin-proposal-class-properties']
                    }
                }
            },
            {
                test: /\.s[ac]ss$/i,
                //use: ["style-loader", "css-loader", "sass-loader"],
                use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
            },
            {
                test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                use: 'file-loader?name=[name].[ext]&outputPath=fonts/'
            },
            {
                test: /\.(jpg|png)$/,
                use: 'file-loader?name=[name].[ext]&outputPath=img/'
            }
        ]
    },
    plugins: [
        new HtmlWebpackPlugin({
            template: path.resolve(__dirname, 'src/index.html'),
        }),
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: "[name].[contenthash].css"
        }),
        new CopyWebpackPlugin({
            patterns: [
                {
                    from: path.resolve(__dirname, 'src/img'),
                    to: 'img'
                }
            ],

        })
    ],
    devServer: {
        contentBase: path.resolve(__dirname, 'dist'),
        port: 9000,
        open: true
    }
};