<template>
  <div>
     <van-form  class="login_dialog" label-align="left" label-width="2rem">
            <van-field
              v-model="phoneForm.real_tel"
              name="电话"
              label="电话"
              placeholder="电话"
              :rules="[{ required: true, message: '请填写电话' }]"
            />
            <div 
              @click="getCheckCode"
              class="get_check_code"
            >{{ getCheckCodeTitle }}</div>
            <van-field
              v-model="phoneForm.checkCode"
              name="验证码"
              label-width="3rem"
              label="验证码"
              placeholder="验证码"
              :rules="[{ required: true, message: '请填写验证码' }]"
            />
            
          </van-form>
          <div class="sureSet2" @click="clear">重置</div>
          <div class="sureSet3" @click="sureLogin">确定</div>
   
  </div>
</template>

<script>
import { 
  getBindRealTelCheckCode,
  doBindRealTel
  } from '../../service/getData'
export default {
 
  watch: {
    
  },
  data() {
    return {
      phoneDialog: false,
      phoneForm: {},
      flag: true,
      num: 60,
       timeInterve: null,
      getCheckCodeTitle: '获取验证码'
    }
  },
  methods: {
    getCheckCode() {
      if (this.phoneStyle){
         if (this.flag) {
         getBindRealTelCheckCode({operate: 'getBindRealTelCheckCode', real_tel: this.phoneForm.real_tel}).then(res => {
          if (res.Code == 0) {
            this.$toast('已发送验证码， 请查收 ');
          } else {
            this.$toast(res.Msg);
            this.flag = false
          }
        })
          }
        if(this.flag) {
            this.timeInterve = setInterval(res => {
            this.flag = false
            this.num --
            this.getCheckCodeTitle = `${this.num} 后可重新发送验证码`
            if (this.num == 0) {
              this.num = 60
              clearInterval(this.timeInterve)
              this.flag = true
              this.getCheckCodeTitle = '获取验证码'
            }
           
          }, 1200)
        }
      } else {
         this.$toast('手机号码格式错误');
      }
      
     
     
    },
    sureLogin() {
      this.phoneForm.operate = 'doBindRealTel'
      doBindRealTel(this.phoneForm).then(res => {
        if (res.Code == 0) {
          this.$emit('success')
           this.$toast(res.Msg);
        } else {
          this.$toast(res.Msg);
        }
      })
    },
    clear() {
      this.phoneForm = {}
    }
  },
  computed: {
    phoneStyle() {
        let reg = /(^1[3|4|5|8][0-9]\d{4,8}$)|(^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$)/
        if (!reg.test(this.phoneForm.real_tel)) {
            return false
        }
        return true
    },
  }
}
</script>

<style lang="scss" scoped>
  
</style>