###  build 文件夹
#### build.js
    生产环境构建脚本，也就是打包的时候需要的一些包的引入配置信息
    shelljs:
        去除先前的打包,这个模块是用来清除之前的打的包，
        因为在vue-cli中每次打包会生成不同的hash,每次打包都会生成新的文件，那就不对了，
        我们要复盖原先的文件，因为hash不同复盖不了，所以要清除
        rm('-rf', assertsPath)
        mkdir('-p', assertsPath)
        cp('-R', 'static/*', assertsPath)
    ora: 打包开始提示对cli进行输出一个带spinner的文案，告诉用户正在打包中
    var spinner = ora('building for production...')
    spinner.start()

#### utils.js
    此配置文件是vue开发环境的wepack相关配置文件，主要用来处理css-loader和vue-style-loader
    引入extract-text-webpack-plugin插件，用来将css提取到单独的css文件中 
    path.join和path.posix.join的区别就是，前者返回的是完整的路径，后者返回的是完整路径的相对根路径
    也就是说path.join的路径是C:a/a/b/xiangmu/b，那么path.posix.join就是b

#### webpack.base.conf.js
    var cssSourceMapDev = (env === 'development' && config.dev.cssSourceMap)
    var cssSourceMapProd = (env === 'production' && config.build.productionSourceMap)
    var useCssSourceMap = cssSourceMapDev || cssSourceMapProd
    这一句话表示如何生成map文件

#### webpack.dev.conf.js
    webpack.dev.conf.js，这里面在webpack.base.conf的基础上增加完善了开发环境下面的配置，主要包括下面几件事情：
        将webpack的热重载客户端代码添加到每个entry对应的应用
        合并基础的webpack配置
        配置样式文件的处理规则，styleLoaders
        配置Source Maps
        配置webpack插件

    devtool是开发工具选项，用来指定如何生成sourcemap文件，cheap-module-eval-source-map此款soucemap文件性价比最高
    DefinePlugin内置webpack插件，专门用来定义全局变量的，下面定义一个全局变量 process.env
     new webpack.DefinePlugin({
      'process.env': config.dev.env
    })

    当webpack编译错误的时候，来中端打包进程，防止错误代码打包到文件中，你还不知道
    new webpack.NoErrorsPlugin()

#### webpack.prod.conf.js
    webpack生产环境的核心配置文件