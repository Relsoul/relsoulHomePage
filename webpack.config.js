const webpack=require("webpack");

module.exports={
    entry:"./front-dev/vue/main.js",
    externals:{
        "jquery" : "jQuery",
        "Vue":"Vue",
        "VueRouter":"VueRouter"
    },
    output:{
        filename:"main.js",
    },
    module:{
        loaders:[
            {test:/\.vue$/,loader:"vue-loader"},
            {test:/\.js$/,loader:"babel-loader",exclude: /node_modules/},
        ],
    },
    vue:{
        loaders:{
            js:"babel",
            html: 'raw'
        }
    },
    //devtool: 'source-map',
    plugins: [
        //压缩打包的文件
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                //supresses warnings, usually from module minification
                warnings: false,
                pure_funcs: [ 'console.log' ] //去除console.log 参考 http://stackoverflow.com/questions/20092466/can-uglify-js-remove-the-console-log-statements
            }
        }),
/*        //允许错误不打断程序
        new webpack.NoErrorsPlugin(),
        //把指定文件夹xia的文件复制到指定的目录
        new TransferWebpackPlugin([
            {from: 'www'}
        ], path.resolve(__dirname,"src"))*/
    ]
};
