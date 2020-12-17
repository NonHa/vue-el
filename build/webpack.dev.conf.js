// webpack.dev.conf.js，这里面在webpack.base.conf的基础上增加完善了开发环境下面的配置，主要包括下面几件事情：

// 将webpack的热重载客户端代码添加到每个entry对应的应用
// 合并基础的webpack配置
// 配置样式文件的处理规则，styleLoaders
// 配置Source Maps
// 配置webpack插件
var config = require('../config')
var webpack = require('webpack')
var merge = require('webpack-merge')
var utils = require('./utils')
var baseWebpackConfig = require('./webpack.base.conf')
var HtmlWebpackPlugin = require('html-webpack-plugin')

Object.keys(baseWebpackConfig.entry).forEach(function(name) {
  // 下面这个结果就是把webpack.base.conf.js中的入口entry改成如下配置
  // app: ['./build/dev-client','./src/main.js']
  baseWebpackConfig.entry[name] = ['./build/dev-client'].concat(baseWebpackConfig.entry[name])
})

module.exports = merge(baseWebpackConfig, {
  module: {
    loaders: utils.styleLoaders({
      sourceMap: config.dev.cssSourceMap
    })
  },
  // debtool是开发工具选项，用来指定如何生成sourcemap文件，cheap-module-eval-source-map此款soucemap文件性价比最高
  devtool: '#eval-source-map',
  plugins: [
    // DefinePlugin内置webpack插件，专门用来定义全局变量的，下面定义一个全局变量 process.env
    new webpack.DefinePlugin({
      'process.env': config.dev.env
    }),
    //根据模块调用次数，给模块分配ids，常被调用的ids分配更短的id，使得ids可预测，降低文件大小
    new webpack.optimize.OccurrenceOrderPlugin(),
    //热更新--无刷新实现代码更新
    new webpack.HotModuleReplacementPlugin(),
    // 当webpack编译错误的时候，来中端打包进程，防止错误代码打包到文件中，你还不知道
    new webpack.NoErrorsPlugin(),
    // 生成html 模板文件
    new HtmlWebpackPlugin({
      filename: 'index.html',
      template: 'index.html',
      favicon: 'yipiao-2.png',
      inject: true
      // 设置为true表示把所有的js文件都放在body标签的屁股
    })
  ]
})
