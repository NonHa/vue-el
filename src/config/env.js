/**
 * 配置编译环境和线上环境的切换
 * 
 * baseUrl: 域名地址
 * routerMode: 路由模式
 * imgBaseUrl: 图片所在域名地址
 * **/

 let baseUrl = ''
 let routerMode = 'hash'
 let imgBaseUrl = ''

 if (process.env.NODE_ENV == 'development') {
     imgBaseUrl = '../upload.php'
     baseUrl = '../webapi.php'

 } else if (process.env.NODE_ENV == 'production') {
     baseUrl = '../webapi.php'
     imgBaseUrl = '../upload.php'
 }

 export {
     baseUrl,
     routerMode,
     imgBaseUrl
 }