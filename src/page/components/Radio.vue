<template>
  <div>
    <van-radio-group v-model="radio" @change="showRidio" >
      <van-radio icon-size="0.1rem" v-for="(item, index) in radioList" :name="index" :key="index">
        {{ item.value }}
        <template #icon="props">
          <img  class="img-icon" :src="props.checked ? activeIcon : inactiveIcon" />
        </template>
      </van-radio>
      
    </van-radio-group>
  </div>
</template>

<script>
export default {
  props: {
    radioList: {
      type: Array
    }
  },
  data() {
    return {
      radio: '1',
      inactiveIcon: require("../../assets/unchecked.png"),
     activeIcon: require("../../assets/select.png"),
    }
  },
  methods: {
    showRidio() {
      console.log(111);
      this.$emit('showVisible')
    }
  }
}
</script>

<style lang="scss" scoped>
  .van-radio-group {
    height: 10rem;
    overflow: scroll;
  }
</style>