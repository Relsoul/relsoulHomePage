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
    }
};