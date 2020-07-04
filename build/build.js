var shell = require('shelljs')
process.env.NODE_ENV = 'production'

var path = require('path')
var config = require('../config')
var ora = require('ora')
var webpack = require('webpack')
var webpackConfig = require('./webpack.base.conf')

var spinner = ora('building for production...')
spinner.start()

var assertsPath = path.join(config.build.assetsRoot, config.build.assetsSubDirectory)
shell.rm('-rf', assertsPath)
shell.mkdir('-p', assertsPath)
shell.cp('-R', 'static/*', assertsPath)

webpack(webpackConfig, function(err, state) {
  spinner.stop()
  if (err) throw err
  process.stdout.write(state.toString({
    colors: true,
    modules: false,
    children: false,
    chunks: false,
    chunkModules: false
  }) + '\n')
})
