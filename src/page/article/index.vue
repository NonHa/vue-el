<template>
  <div style="padding: 0 0.9rem; background-color: #fff">
     <van-tabs 
      v-model="active" 
      @change="getItem" 
      color= "#FF807B" 
      line-width="1.1rem" 
      line-height="0.25rem" 
      swipe-threshold 
      sticky 
      :title-active-color="activeColor" 
      :title-inactive-color="activeColor">
      <van-tab v-for="(item, index) in article" :title="item" :key="index" >
       
      </van-tab>
    </van-tabs>
     <div v-if="activeItem == 0" @click="goArticleMes"  class="article_item">
          <div class="img_item" >
            <img src="../../assets/pull_strings_ select.png" alt="">
          </div>
          <div class="content_item">
           <div style="line-height: 1.1rem;">
              <h3>什么样的人值得你去爱？</h3>
           </div>
            <div style="line-height: 1rem; margin-top: 0.5rem">
              <p>等待英雄的过程中，我们又把自己看得太重要</p>
            </div>
            <div style="line-height: 0.7rem; margin-top: 1rem">
              <span>06月21日 17:40</span>
            </div>
          </div>
    </div>
  </div>
</template>

<script>


export default {
  data() {
    return {
      active: '1',
       selected:"active",
      activeColor: '#FF807B',
       activeItem:0,
      article: ['全部文章', '热门文章',]
    }
  },
   components: {
       
    },
  methods: {
    getItem(val) {
     this.activeItem = val
    },
    goArticleMes() {
      this.$router.push({ path: '/searchMessage'})
    }
  }
}
</script>

<style lang="scss" scoped>
    @import '../../style/mixin';

  .van-tabs {
    width: 52%;
  }
  
</style>