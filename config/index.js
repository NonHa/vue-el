var path = require('path')

module.exports = {
  build: {
    // 修改环境为生产环境
    env: {
      NODE_ENV: '"production"'
    },
    // index 即打包后生成启动首页 index.html
    index: path.resolve(__dirname, '../elm/index.html'),
    // 打包后 生成的资源存根目录
    assetsRoot: path.resolve(__dirname, '../elm'),
    // 资源子目录
    assetsSubDirectory: 'static',
    // 这个是通过http服务器运行的url 路径 一般都是根路径
    assetsPublicPath: '/elm/',
    // 设置成false 打包的体积会减小 80%
    productionSourceMap: true,
    // 是否开启Gzip 压缩
    productionGzip: false,
    bundleAnalyzerReport: process.env.npm_config_report,
    // 下面定义要压缩哪些类型的文件
    productionGzipExtensions: ['js', 'css']
  },
  dev: {
    env: {
      NODE_ENV: '"development"'
    },
    // 运行测试页面的端口
    port: 8000,
    // 编译输出的二级目录
    assetsSubDirectory: 'static',
    // 编译发布的根目录 可配置为资源服务器域名或 CDN域名
    assetsPublicPath: '/',
    context: [  // 代理路径
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
    proxypath: 'http://cangdu.org:8001',  // 需要 proxyTable 代理的接口（可跨域）
    cssSourceMap: false
  }
}
