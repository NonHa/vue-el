// 此配置文件是vue开发环境的wepack相关配置文件，主要用来处理css-loader和vue-style-loader
var path = require('path')
var config = require('../config')
// 引入extract-text-webpack-plugin插件，用来将css提取到单独的css文件中
var ExtractTextPlugin = require('extract-text-webpack-plugin')
// exports其实就是一个对象，用来导出方法的最终还是使用module.exports，此处导出assetsPath
exports.assetsPath = function(_path) {
  // 如果是生产环境assetsSubDirectory就是'static'，否则还是'static'
  var assetsSubDirectory = process.env.NODE_ENV === 'production' ? config.build.assetsSubDirectory : config.dev.assetsSubDirectory
  // path.join和path.posix.join的区别就是，前者返回的是完整的路径，后者返回的是完整路径的相对根路径
  // 也就是说path.join的路径是C:a/a/b/xiangmu/b，那么path.posix.join就是b
  return path.posix.join(assetsSubDirectory, _path)
}

exports.cssLoaders = function(options) {
  options = options || {}
  function generateLoaders(loaders) {
    var sourceLoader = loaders.map(function(loader) {
      var extraParamChar
      if (/\?/.test(loader)) {
        loader = loader.replace(/\?/, '-loader?')
        extraParamChar = '&'
      } else {
        loader = loader + '-loader'
        extraParamChar = '?'
      }
      // options是用来传递参数给loader的
      // minimize表示压缩，如果是生产环境就压缩css代码
      // minimize: process.env.NODE_ENV === 'production',
      // 是否开启cssmap，默认是false
      return loader + (options.sourceMap ? extraParamChar + 'sourceMap' : '')
    }).join('!')
    // 注意这个extract是自定义的属性，可以定义在options里面，
    // 主要作用就是当配置为true就把文件单独提取，false表示不单独提取，这个可以在使用的时候单独配置
    if (options.extract) {
      return ExtractTextPlugin.extract('vue-style-loader', sourceLoader)
    } else {
      return ['vue-style-loader', sourceLoader].join('!')
    }
  }

  return {
    css: generateLoaders(['css']),
    postcss: generateLoaders(['css']),
    less: generateLoaders(['css', 'less']),
    sass: generateLoaders(['css', 'sass?indentedSyntax']),
    scss: generateLoaders(['css', 'sass']),
    stylus: generateLoaders(['css', 'stylus']),
    styl: generateLoaders(['css', 'stylus'])
  }
}

// 下面这个主要处理import这种方式导入的文件类型的打包，上面的exports.cssLoaders是为这一步服务的
exports.styleLoaders = function(options) {
  var output = []
  // 下面就是生成的各种css文件的loader对象
  var loaders = exports.cssLoaders(options)
  for (var extension in loaders) {
    var loader = loaders[extension]
    output.push({
      // 把最终的结果都push到output数组中
      test: new RegExp('\\.' + extension + '$'),
      loader: loader
    })
  }
  return output
}
