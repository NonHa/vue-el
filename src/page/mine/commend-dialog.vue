<template>
  <div>
     <van-dropdown-menu>
        <van-dropdown-item 
          v-model="userForm.real_referrer" 
          :options="commendList" />
      </van-dropdown-menu>
          <div class="sureSet2" @click="clear">重置</div>
          <div class="sureSet3" @click="submit">确定</div>
    
  </div>
</template>

<script>
import { 
  getVVIPList,
  addRealReferrerVerify
  } from '../../service/getData'
export default {
  props: {
   
  },
  watch: {
    
  },
  data() {
    return {
      phoneDialog: false,
      phoneForm: {},
      commendList: [],
      userForm: {
        real_referrer: '',
        operate: 'addRealReferrerVerify'
      },
    }
  },
  created() {
    this.getComment()
  },
  methods: {
   
    submit() {
      addRealReferrerVerify(this.userForm).then(res => {
        if (res.Code == 0) {
          this.$emit('success')

           this.$toast(res.Msg);
        } else {
          this.$toast(res.Msg);
        }
      })
    },
    clear() {

    }
  },
}
</script>

<style lang="scss" scoped>
  
</style>