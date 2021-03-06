import Vue from 'vue'
import Vuex from 'vuex'
import mutations from './mutations'
import actions from './action'
import getters from './getters'
Vue.use(Vuex)

const state = {
  latitude: '',   // 当前位置维度
  longitude: '',  // 当前位置经度
}
export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters
})
