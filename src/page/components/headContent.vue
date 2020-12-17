<template >
  <div class="head_row_content">
    <div class="to_scroll"
      @click="$router.go(-1)"
    ></div>
    <span>
      {{title}}
    </span>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String
    }
  },
  data() {
    return {

    }
  }
}
</script>
<style lang="scss" scoped>
  .head_row_content {
    position: relative;
    height: 3rem;
    background-color: #fff;
    text-align: center;
    line-height: 3rem;
    font-size: 0.9rem;
  }
  .to_scroll {
    position: absolute;
    left: 1.4rem;
    top: 50%;
    transform: translateY(-50%);
  }
  .to_scroll::after {
    content: '';
    display: inline-block;
    height: 0.5rem;
    width: 0.5rem;
    border-top: 2px solid#403C3C;
    border-left: 2px solid#403C3C;
    transform: rotate(45deg) scaleY(-1);
  }
</style>