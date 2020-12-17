import Vue from 'vue'
import App from './App'
import VueRouter from 'vue-router'
import routes from './router/router'
import store from './store'
import 'vant/lib/index.css';
import { routerMode } from './config/env'
import './config/rem'
import './plugins/vant'
import './style/vant.scss'
import { getSession, setSession, setIdxCity } from './utils/auth' // get token from cookie
import axios from 'axios'
const Axios = axios.create({
  //请求接口
  baseURL:"../",
  //超时设置
  timeout:8000,
  //请求头设置
  headers: {
        // "accept": "application/json",
        'Content-Type': 'application/json',
  }
})
Vue.prototype.$axios = Axios 
Vue.use(VueRouter)
const router = new VueRouter({
  routes,
  mode: routerMode,
  strict: process.env.NODE_ENV !== 'production',
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      // 与keepAlive结合，如果keepAlive的话，保存停留的位置
      if (from.meta.keepAlive) {
        from.meta.savedPosition = document.body.scrollTop
      }
      // return 期望滚动到哪个的位置
      return { x: 0, y: to.meta.savedPosition || 0}
    }
  }
})

router.beforeEach(async(to, from, next) => {
    // setSession('e6075bf473f33015a3732d3dead53c52')
    // setIdxCity('184')
    // determine whether the user has logged in
    const hasToken = getSession()
  
    if (!hasToken) {
      if (to.path === '/mine/edit') {
        // if is logged in, redirect to the home page
        next()
        // NProgress.done()
      } else {
        // determine whether the user has obtained his permission roles through getInfo
        const hasRoles = true
        if (hasRoles) {
          next()
        } else {
          try {
            // get user info
            // note: roles must be a object array! such as: ['admin'] or ,['developer','editor']
            // const { roles } = await store.dispatch('user/getInfo')
            //let roles = ['admin'];
           
            next({ ...to, replace: true })
          } catch (error) {
            // remove token and go to login page to re-login
            // await store.dispatch('user/resetToken')
            Message.error(error || 'Has Error')
            next(`/login?redirect=${to.path}`)
            // NProgress.done()
          }
        }
      }
    } else {
      /* has no token*/
  
      // if (whiteList.indexOf(to.path) !== -1) {
      //   // in the free login whitelist, go directly
        next()
        // next(`/login?redirect=${to.path}`)

      // next(`/home`)

      // } else {
      //   // other pages that do not have permission to access are redirected to the login page.
      //   next(`/login?redirect=${to.path}`)
        // NProgress.done()
      // }
    }
  })
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
