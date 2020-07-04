var path = require('path')

module.exports = {
  build: {
    env: {
      NODE_ENV: '"production"'
    },
    index: path.resolve(__dirname, '../elm/index.html'),
    assetsRoot: path.resolve(__dirname, '../elm'),
    assetsSubDirectory: 'static',
    assetsPublicPath: '/elm/',
    productionSourceMap: true,
    productionGzip: false,
    bundleAnalyzerReport: process.env.npm_config_report,
    // 下面定义要压缩哪些类型的文件
    productionGzipExtensions: ['js', 'css']
  },
  dev: {
    env: {
      NODE_ENV: '"development"'
    },
    port: 8000,
    assetsSubDirectory: 'static',
    assetsPublicPath: '/',
    context: [
      '/shopping',
      '/ugc',
      '/v1',
      '/v2',
      '/v3',
      '/v4',
      '/bos',
      '/member',
      '/promotion',
      '/eus',
      '/payapi',
      '/img'
    ],
    proxypath: 'http://cangdu.org:8001',
    cssSourceMap: false
  }
}
