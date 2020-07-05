import Vue from 'vue'
import VueRouter from 'vue-router'
import routers from './router/router'
import store from './store'
import { routerMode } from './config/env'

Vue.use(VueRouter)
const router = new VueRouter({
  routers,
  mode: routerMode
})
new Vue({
  router,
  store
}).$mount('#app')
