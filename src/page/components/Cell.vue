<template>
  <div>
      <van-cell-group>
        <van-cell class="cell_other" v-for="(item, index) in cellList" :title="item.title" :value="item.value" :key="index" />
       
      </van-cell-group>
  </div>
</template>

<script>
export default {
  props: {
    cellList: {
      type: Array
    }
  },
  data() {
    return {}
  }
}
</script>

<style lang="scss" scoped>
  
</style>