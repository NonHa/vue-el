<template style="height: 100px">
  <div class="bottom-view-wrapper">
    <keep-alive>
      <router-view></router-view>
    </keep-alive>
    <footer-bar></footer-bar>

  </div>
</template>

<script>
import {  
    isRegistered,
    } from '../../../service/getData'
import { getSession, setSession, setIdxCity } from '../../../utils/auth' // get token from cookie

import FooterBar from '../../../components/layout/footBottom.vue'
export default {
  props: {},
  data () {
    return {
      phpSession: null,
    }
  },
  computed: {},
  created () { },
  mounted () { 
   
    this.checkisRegistered()
  },
  watch: {
     $route(to, from) {
       if (to.path) {
         this.checkisRegistered()
       }
    }
  },
  methods: {
     checkisRegistered() {
      this.phpSession = getSession()
      if (!this.phpSession) {
        isRegistered({ operate: 'isRegistered' }).then(res => {
            if (res.Code == 0) {
                if (res.Result == 'no-tel') {
                  this.passwordDialog = true
                } else if (res.Result == 'no-real') {
                  this.$toast('您还没有实名注册');
                }
                if (res.session) {
                  setSession(res.session)
                }
            } else {
                 this.$toast(res.Msg);
            }
        })
      }
      
    },
  },
  components: {
    FooterBar
  }
}
</script>

<style scoped lang="scss">
.bottom-view-wrapper {
  // padding-bottom: 50px;
  height: 1000%;
}
 .van-tabs__line {
    background-color: #FF807B;
  }
  .login_dialog {
    height: 15rem;
  }
</style>
