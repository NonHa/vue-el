<template>
  <div style="background: #F7F7F8;">
    <div class="swipe_head">
      <van-swipe class="my-swipe" style="height: 8rem;" :autoplay="3000" indicator-color="white">
      <van-swipe-item v-for="(image, index) in imgList" :key="index">
         <img v-lazy="image" />
      </van-swipe-item>
      
    </van-swipe>
    </div>

   <div style="background: #fff">
      <van-tabs  style="margin-top: 0.9rem" v-model="active" @change="getItem" color= "#FF807B" line-width="1.1rem" line-height="0.25rem" swipe-threshold sticky :title-active-color="activeColor" :title-inactive-color="activeColor">
      <van-tab v-for="(item, index) in article" :title="item" :key="index" >
       
      </van-tab>
    </van-tabs>
   </div>
    <div 
      class="active_item" 
      v-if="activeItem == 0"
      style="padding: 0 0.9rem; 
      background: #FFFFFF;">
       <div 
        v-for="(item,index) in activeList"
        :key="index"
        @click="goArticleMes(item.id)"
        class="article_item">
          <div class="img_item" >
            <img :src="item.activity_poster" alt="">
            <div class="doing">
              进行中
            </div>
          </div>
          <div class="content_item">
           <div style="line-height: 1.1rem;">
              <h3>{{item.theme}}</h3>
           </div>
            <div class="active_time" >
              <p>时间：{{item.activity_time}}</p>
            </div>
            <div style="line-height: 0.7rem; margin-top: 0.6rem">
              <span>{{item.no_of_applicants}}</span>
            </div>
          </div>
    </div>
    </div>
  </div>
</template>

<script>

import {  getActivityList } from '../../service/getData'

export default {
   components: {},
  data() {
    return {
      imgList: [],
      active: '1',
      activeList: [],
      selected:"active",
      activeColor: '#FF807B',
      activeItem:0,
      article: ['全部活动', '最新活动',]
    }
  },
  created() {
    this.getList()
  },

  methods: {
    getList() {
      getActivityList().then(res => {
        if (res.Code == 0) {
          this.activeList= JSON.parse(res.Result)
          if (this.activeList.length > 0) {
            this.activeList.forEach(item => {
              item.activity_poster = decodeURIComponent(item.activity_poster)
              this.imgList.push(item.activity_poster)
            })
          }
        }
        
       

      })
    },
     getItem(val) {
     this.activeItem = val
    },
    goArticleMes(id) {
      this.$router.push({ path: '/active/doing', query: { id: id}})
    }
  }
}
</script>

<style lang="scss" scoped>
@import '../../style/mixin';

  .swipe_head {
    padding: 0.9rem;
    padding-bottom: 0;
    @include wh(100%, 9rem);

  }
  .swipe_head .van-swipe-item {
    width: 100%;
  }
  .van-swipe-item img {
    @include wh(100%, 100%);

  }

  .van-tabs {
    width: 52%;
    background-color: #fff;
  }
  .article_item {
    display: flex;
    margin: 0;
    // margin-top: 0.9rem;
    padding: 0.9rem 0;
    background-color: #fff;
    border-bottom: 1px solid #E0E0E0;
    width: 100%;
    height: auto;
  }
  .active_item .img_item {
    position: relative;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    @include wh(8rem, rem);
  }
  .img_item img {
    @include wh(100%, 100%);

  }
  .active_time {
    line-height: 1rem; 
    margin-top: 0.5rem;
    white-space: nowrap; 
    // width: 100%; 
    overflow: hidden;
    text-overflow:ellipsis;
  }
  .doing {
    position: absolute;
    top: 0;
    right: 0;
    @include wh(2.4rem, 1rem);
    @include sc(0.6rem, #FFFFFF);
    background-color: #FF807B;
    text-align: center;
    line-height: 1rem;
    
    border-radius: 0px 8px 0px 8px;

  }
  .content_item {
    flex: 3;
    padding-left: 0.9rem;
    font-family: PingFangSC-Medium, PingFang SC;
    
  }
  h3 {
    
    font-weight: 500;
        @include sc(0.8rem, #262B40);
  }
  .content_item p {
        white-space: nowrap; 
      width: 100%;
      overflow: hidden;
      text-overflow:ellipsis;
        @include sc(0.6rem, #6E6E6E);

  }
  .content_item span {
      @include sc(0.6rem, #8C8C8C);

  }
</style>