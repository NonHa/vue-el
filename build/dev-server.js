var config = require('../config')
if (!process.env.NODE_ENV) process.env.NODE_ENV = JSON.parse(config.dev.env.NODE_ENV)
var path = require('path')
var webpack = require('webpack')
var opn = require('opn')
var express = require('express')
var proxyMiddleware = require('http-proxy-middleware')
var webpackConfig = require('./webpack.dev.conf')

var port = process.env.PORT || config.dev.port

var server = express()
var compiler = webpack(webpackConfig)

var devMiddleware = require('webpack-dev-middleware')(compiler, {
  publicPath: webpackConfig.output.publicPath,
  stats: {
    colors: true,
    chunks: false
  }
})

var hotMiddleware = require('webpack-hot-middleware')(compiler)

compiler.plugin('complication', function(complication) {
  complication.plugin('html-webpack-plugin-after-emit', function(data, cb) {
    hotMiddleware.publish({
      action: 'reload'
    })
    cb()
  })
})

var context = config.dev.context
var proxypath = null
switch (process.env.NODE_ENV) {
    case 'local': proxypath = 'http://localhost:8001'; break
    case 'online': proxypath = 'http://elm.cangdu.org'; break
    default: proxypath = config.dev.proxypath
}

var options = {
  target: proxypath,
  changeOrigin: true
}
if (context.length) {
  server.use(proxyMiddleware(context, options))
}
// 具体来说，每当出现符合以下条件的请求时，它将把请求定位到你指定的索引文件(默认为/index.html)。
server.use(require('connect-history-api-fallback')())

server.use(devMiddleware)

server.use(hotMiddleware)

var staticPath = path.posix.join(config.dev.assetsPublicPath, config.dev.assetsSubDirectory)
server.use(staticPath, express.static('./static'))

module.exports = server.listen(port, function(err) {
  if (err) {
    console.log(err)
    return false
  }
  var uri = 'http://localhost:' + port
  console.log('Listening at' + uri + '\n')
  if (process.env.NODE_ENV !== 'testing') {
    opn(uri)
  }
})
