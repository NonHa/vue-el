<template>
  <div>
     <van-form label-align="left" label-width="2rem">
      <van-field 
        name="radio" 
        label="企业类型"
        v-if="activeName == '工作单位'"
        class="field_radio"
        >
        <template #input>
          <van-radio-group v-model="radio" direction="horizontal">
            <van-radio name="1">国企</van-radio>
            <van-radio name="2">民营</van-radio>
          </van-radio-group>
        </template>
      </van-field>
       
      <van-field
        v-model="nikeName"
        :name="activeName"
        :label="activeName"
        :placeholder="`请填写${activeName}`"
        :rules="[{ required: true, message: `请填写${activeName}` }]"
      />
  
    </van-form>
    <div class="sureSet2" @click="clear">重置</div>
    <div class="sureSet3" @click="sureLogin">确定</div>
  </div>
</template>

<script>
export default {
  props: {
    activeName: {
      type: String
    },
    jobType: {
      type: String
    }
  },
  data() {
    return {
      nikeName: "",
      radio: '1',
      
    }
  },
  watch: {
    jobType(val) {
      if (val) {
        this.radio = JSON.parse(JSON.stringify(val))
      }
        
    }
  },
  created() {
    console.log('activeName', this.activeName);
    if (this.jobType) {
      this.radio = JSON.parse(JSON.stringify(this.jobType))
    }
  },
  methods: {
     sureLogin() {
       if(this.activeName == '工作单位') {
          if (this.radio) {
            var user = {}
            user.job_class = this.radio
            user.nikeName = this.nikeName
              this.$emit('sureLogin', user)
          } else {
              this.$toast('请选择企业类型');
          }
       } else {
              this.$emit('sureLogin', this.nikeName)

       }
      
      
    },

    clear() {
      this.nikeName = ''
    },
  }
}
</script>
<style lang="css">
  
</style>