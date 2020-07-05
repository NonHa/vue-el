// 生产环境构建脚本，也就是打包的时候需要的一些包的引入配置信息
require('shelljs/global')
env.NODE_ENV = 'production'

var path = require('path')
var config = require('../config')
// 打包开始提示对cli进行输出一个带spinner的文案，告诉用户正在打包中
var ora = require('ora')
var webpack = require('webpack')
var webpackConfig = require('./webpack.prod.conf')

var spinner = ora('building for production...')
spinner.start()
// 去除先前的打包,这个模块是用来清除之前的打的包，
// 因为在vue-cli中每次打包会生成不同的hash,每次打包都会生成新的文件，那就不对了，
// 我们要复盖原先的文件，因为hash不同复盖不了，所以要清除

var assertsPath = path.join(config.build.assetsRoot, config.build.assetsSubDirectory)
rm('-rf', assertsPath)
mkdir('-p', assertsPath)
cp('-R', 'static/*', assertsPath)

webpack(webpackConfig, function(err, stats) {
  spinner.stop()
  if (err) throw err
  process.stdout.write(stats.toString({
    colors: true,
    modules: false,
    children: false,
    chunks: false,
    chunkModules: false
  }) + '\n')
})
