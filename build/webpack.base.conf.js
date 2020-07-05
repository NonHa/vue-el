var path = require('path')
// // 生产和开发环境的相关属性
var config = require('../config')
var utils = require('./utils')
var projectRoot = path.resolve(__dirname, '../')

var env = process.env.NODE_ENV

var cssSourceMapDev = (env === 'development' && config.dev.cssSourceMap)
var cssSourceMapProd = (env === 'production' && config.build.productionSourceMap)
var useCssSourceMap = cssSourceMapDev || cssSourceMapProd
// 这一句话表示如何生成map文
function resolve(dir) {
  return path.join(__dirname, dir)
}
module.exports = {
  entry: {
     // 入口文件是src目录下的main.js
    app: './src/main.js'
  },
  output: {
    // 路径是config目录下的index.js中的build配置中的assetsRoot，也就是elm目录
    path: config.build.assetsRoot,
    // 上线地址，也就是真正的文件引用路径，如果是production生产环境
    publicPath: process.env.NODE_ENV === 'production' ? config.build.assetsPublicPath : config.dev.assetsPublicPath,
    filename: '[name].js'
  },
  chainWebpack: (config) => {
    // /后面的$符号指精确匹配，
    // 也就是说只能使用 import vuejs from "vue"
    // 这样的方式导入vue.esm.js文件，不能在后面跟上 vue/vue.js
    config.resolve.alias
      .set('vue$', resolve('vue/dist/vue.common.js'))
      .set('src', resolve('../src'))
      .set('components', resolve('../src/components'))
      .set('assets', resolve('../src/assets'))
  },
  resolve: {
    // resolve是webpack的内置选项，顾名思义，决定要做的事情，也就是说当使用 import "jquery"，
    // 该如何去执行这件事情就是resolve配置项要做的，
    // import jQuery from "./additional/dist/js/jquery"
    // 这样会很麻烦，可以起个别名简化操作
    extensions: ['', '.js', '.vue', '.less', '.css', '.scss'],
    fallback: [path.join(__dirname, '../node_modules')]
  },
  resolveLoader: {
    fallback: [path.join(__dirname, '../node_modules')]
  },
  module: {
    loaders: [
      {
        test: /\.vue$/,
        loader: 'vue'
      }, {
        test: /\.js$/,
        loader: 'babel',
        include: projectRoot,
        exclude: /node_modules/,
        query:{
          presets:['es2015']
        }
      }, {
        test: /\.json$/,
        loader: 'json'
      }, {
        test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
        loader: 'url',
        query: {
          limit: 10000,
          name: utils.assetsPath('img/[name].[ext]')
        }
      }, {
        test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
        loader: 'url',
        query: {
          limit: 10000,
          name: utils.assetsPath('fonts/[name].[hash:7].[ext]')
        }
      }
    ]
  },
  vue: {
    loaders: utils.cssLoaders({
      sourceMap: useCssSourceMap
    }),
    postcss: [
      require('autoprefixer')({
        browsers: [
          'Android >= 4.4',
          'iOS >= 8'
        ]
      })
    ]
  }
}
