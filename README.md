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

    build： 打包上线的配置；可以看出会将打包好的文件放在elm目录下，启动的首页index,html，资源目录是elm/static
    dev：本地启动测试的配置；运行的端口8000

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

### config 文件夹
    config配置的目的都是为了服务webpack的配置，给不同的编译条件提供配置


### src/main.js
#### scrollBehavior
    在文档页面(http://localhost:8080/document)拉动滚动条，然后刷新浏览器会发现滚动条依然在原来的位置，这是浏览器的默认行为，会记录浏览器滚动条默认位置。

    但是点击浏览器“前进/后退”按钮，会发现当初那个页面的滚动条从0开始了，没有记录上一次滚动条的位置。现在要求点击浏览器“前进/后退”按钮，页面滚动条要记录上一次的位置，这时需要设置它的的滚动行为。

    这时候需要在路由配置中设置 scrollBehavior(to,from,savePosition)函数，函数有三个参数。scrollBehavior() 函数在点击浏览器的“前进/后退”，或者切换导航的时候触发。

#### App.vue
    Vue的动画并没有非常炫酷的效果，不过也是有一些实用性的，在项目中有的地方使用，也是能够营造出不同的效果
    使用 <transition> 包裹

#### webpack-dev-middleware
    你定义了 webpack.config，webpack 就能据此梳理出entry和output模块的关系脉络，而 webpack-dev-middleware 就在此基础上形成一个文件映射系统，每当应用程序请求一个文件，它匹配到了就把内存中缓存的对应结果以文件的格式返回给你，反之则进入到下一个中间件。

    因为是内存型文件系统，所以重建速度非常快，很适合于开发阶段用作静态资源服务器；因为 webpack 可以把任何一种资源都当作是模块来处理，因此能向客户端反馈各种格式的资源，所以可以替代HTTP 服务器。

    webpack-dev-server

    webpack-dev-server实际上相当于启用了一个express的Http服务器+调用webpack-dev-middleware。它的作用主要是用来伺服资源文件。这个Http服务器和client使用了websocket通讯协议，原始文件作出改动后，webpack-dev-server会用webpack实时的编译，再用webpack-dev-middleware将webpack编译后文件会输出到内存中。适合纯前端项目，很难编写后端服务，进行整合