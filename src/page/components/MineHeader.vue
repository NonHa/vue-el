<template>
  <div>
     
  </div>
</template>

<script>
export default {
  props: {
    
  },
  watch: {
    stateMes: {
      handler(val) {
        console.log(val, 'mes');
        if (val) {
          this.state = '邀约成功'
        } else {
          this.state = '邀约已拒绝'

        }
      },
      deep: true,
      immediate: true
    },
    $route(to, from) {
      if (from.path == '/home/message') {
         this.stateMes = this.sucState
      } else if (from.path == '/customer/visite') {
          this.state = '邀约待接受'
      }
      
    }
  },
  data() {
    return {
      state: '邀约待接受',
      stateMes: false
    }
  },
  created() {
    console.log(this.sucState, 'state');
   
    console.log(this.stateMes);
  },
  methods: {
    goBackHome() {
      this.$emit('goHome')
    }
  }
}
</script>

