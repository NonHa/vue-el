<template>
  <div>
      <van-form 
      label-align="left" 
      label-width="4rem"
      ref="modiryForm"
      @submit="setModify">
        <van-field
          v-model="modifyForm.oldpw"
          name="原密码"
          label="原密码"
          type="password"
          placeholder="原密码"
          :rules="[{ required: true, message: '请填写原密码' }]"
        />
          <van-field
          v-model="modifyForm.newpw"
          name="新密码"
          label="新密码"
          :type="tiggerEye ? '' : 'password'"
          placeholder="新密码"
          :right-icon="tiggerEye ? 'eye' : 'closed-eye'"
            @click-right-icon="getInputValue"
          :rules="[{ required: true, message: '请填写新密码' }]"
        />
          <van-field
          v-model="modifyForm.surePwd"
          name="确认密码"
          label="确认密码"
          :type="tiggerEye2 ? '' : 'password'"
          placeholder="确认密码"
          :right-icon="tiggerEye2 ? 'eye' : 'closed-eye'"
          @click-right-icon="getInputValue2"
          :rules="[{ required: true, message: '请填写确认密码' }]"
        />
        <div v-if="showCheck" style="color: red; text-align: right; padding-right:1rem ">新密码与确认密码不一致</div>
      </van-form>
      <div class="sureSet2" @click="clearPwd">重置</div>
      <div class="sureSet3" @click="setModify">确定</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      modifyForm: {},
      tiggerEye: false,
      tiggerEye2: false,
      showCheck: false,
    }
  },
  methods: {

     setModify() {
        this.$refs.modiryForm.validate().then(valid => {
        if (valid == undefined) {
           if (this.modifyForm.surePwd != this.modifyForm.newpw) {
              this.showCheck = true
            } else {
              this.showCheck = false
              ModifyPassword(this.modifyForm).then(res => {
                if (res.Code == 0) {
                  this.$toast(res.Msg);
                  this.$emit('setModify')
                  
                } else {
                  this.$toast(res.Msg);
                }
              })
            }
        }
      })
      
    },

    clearPwd() {
      this.modifyForm = {
        oldpw: '',
        newpw: '',
        surePwd: ''
      }
    },
     getInputValue() {
      this.tiggerEye = !this.tiggerEye
    },
    getInputValue2() {
      this.tiggerEye2 = !this.tiggerEye2
    },
  }
}
</script>
<style lang="css">
  
</style>