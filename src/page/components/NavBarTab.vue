<template>
  <div>
    <van-nav-bar
      :title="title"
      fixed
      :border="border"
      right-text="..."
      left-arrow
      @click-left="onClickLeft"
      @click-right="onClickRight"
    />
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String
    },
    border: {
      type: Boolean
    }
  },
  data() {
    return {
      
    }
  },
  methods: {
    onClickLeft() {
      this.$emit('goBack')
    },
    onClickRight() {
      this.$emit('showItem')
    }
  }
}
</script>

<style lang="scss" scoped>
   
</style>