<template>
  <div>
    <head-content title="我的订单"></head-content>

    <div >
      
       <van-tabs
        @change="tabChange"
         v-model="active" 
         class="accset" 
         color= "#FF807B"  
         line-width="1.1rem" 
         line-height="0.25rem" 
         swipeable
         :ellipsis="false"
         sticky  
         >
     
      <van-tab v-for="(item, index) in tabList" :title="item" :key="index" title-inactive-color="#FF807B">
         <van-pull-refresh 
           v-model="isLoading"
           style="min-height: 100vh;" 
           @refresh="onRefresh">
           <div style="padding:  1rem; background-color: #fff;">
              <div class="order_item">
              <div class="type_order">
                <div class="left_type_mes">
                  缘分牵线（包1次成功）
                </div>
                <div class="right_type_mes">
                  <span style=" text-decoration: line-through;margin-right: 0.5rem;color: #787878;">
                    ¥299
                  </span>
                  <span>
                    ¥199
                  </span>
                </div>
              </div>
              <div 
            
                class="all_day_content_item"
                @click="$router.push({name: 'OrderMessage'})"
                >
                <div class="left_item">
                  <!-- <div class="checkSure" >
                    <img  src="../../assets/successful_certification.png" alt=""> -->
                    <!-- <img :src="item.photo" alt=""> -->
                    <!-- 认证客户 -->
                  <!-- </div> -->
                  <img src="../../assets/bg_personal_center.png" alt="" >
                </div>
                <div class="user_message"  >
                    <div  >
                      <span class="home_title">
                        何女士
                        <!-- 何女士 -->
                      </span>
                      <span class="unique_message" >
                          联合创始人
                      </span>
                      <p>
                        26岁/长沙/10W~20W/天蝎座
                      </p>
                      <p >
                        希望三年内结婚
                      </p>
                    </div>
                  
                </div>
            
              
              </div>
              <div class="bottom_btn" v-show="active != 1">
                <div class="bottom_time" v-show="active == 0">
                  剩余付款时间：10:03:19
                </div>
                <div class="right_btn">
                  <div class="cancel_btn">
                    {{ active == 0 ? '取消订单' : '删除订单'}}
                  </div>
                  <div class="go_pay_btn">
                    {{ active == 0 ? '去支付' : '重新下单'}}

                    
                  </div>
                </div>
              </div>
            </div>
            
           </div>
      </van-pull-refresh>
      </van-tab>
    </van-tabs>
			
    </div>
       
  </div>
</template>

<script>
import { 
  addLove, 
  delLove,
  getIndexData
  } from '../../service/getData'
import { 
  actionSheet, 
  vipActionSheet, 
  areaList 
  } from '../components/actioneSheet'
import {ImagePreview} from "vant"
import headContent from '../components/headContent'

import moment from 'moment'
import { getSession, setSession, setIdxCity } from '../../utils/auth' // get token from cookie

export default {
  components: {headContent},
  props: {
   
  },
  watch: {
   
  },
  data() {
    return {
        homeList: {
          recommander: []
        },
        isLoading: false,
        finished: false,
        loading: false,
        vipActionSheet: vipActionSheet,
        active: 0,
        show: false,
        index: 0,
        areaList: areaList,
        listQuery: {
          operate: 'getIndexData'
        },
        images: [],
        tabList: ['待付款', '已完成', '已取消'],
        }
      },
      
      created() {
        console.log('query',this.$route);
        var v= this.$route.query.v
        
        
      },
      methods: {
      
        
        onRefresh() {
        //  this.getTabIndex(this.active)
        },
        tabChange(index) {
          console.log(index);
          this.active = index
        }
       
      
     
      }
}
</script>

<style lang="scss" scoped>
    @import '../../style/mixin';
    .order_item {
      background-color: #fff;
      padding-bottom: 1rem;
      border-bottom: 1px solid #ccc;
      margin-top: 0.5rem;
    }
    .type_order {
      height: 2rem;
      @include sc(0.8rem, #8C8C8C);
      font-family: PingFangSC-Semibold, PingFang SC;
      font-weight: 600;
      color: #262B40;

    }
    .left_type_mes {
      float: left;
    }
    .right_type_mes {
      float: right;
    }

    .all_day_content_item {
      position: relative;
      display: flex;
       border-radius: 5px;
      background-color: #fff;
      margin-top: 0.2rem;
      height: 4rem;
       font-family: PingFangSC-Semibold, PingFang SC;
    }
    .left_item {
      height: 100%;
      width: 4rem;
    }
    .left_item img {
      height: 100%;
    }
    .all_day_content_item .checkSure, .picture {
      position: absolute;
      top: 0.8rem;
      left: 0.9rem;
      text-align: center;
      line-height: 0.9rem;
      background: #262B40;
      border-radius: 0px 100px 100px 0px;
      opacity: 0.49;
      @include wh(3.2rem, 0.9rem);
      @include sc(0.7rem,#FFFFFF);
      
    }
    .all_day_content_item .checkSure::before {
      position: absolute;
      display: inline-block;
     
      @include wh(1rem, 0.9rem);

      background-image: url('../../assets/successful_certification.png');
    }
    
    .checkSure img{
      position: absolute;
      top: 0;
      left: -0.7rem;
      @include wh(1rem, 0.9rem);
      
    }
    .picture {
      
      left: 16.8rem;
      border-radius: 0.5rem;
      opacity: 0.49;
      
      overflow: hidden;
      line-height: 0.9rem;
       @include wh(2.2rem, 0.9rem);
     
    }
    
    .picture::before {
      content: '';
      position: absolute;
      top: 0.1rem;
      left: 0.3rem;
      background: url('../../assets/icon_photo.png') no-repeat center;
      background-size: 100% 100%;
       @include wh(0.7rem, 0.7rem);

    }
    .picture_num {
      @include sc(0.7rem,#FFFFFF);
      @include wh(2rem, 0.9rem);
      line-height: 0.9rem;
      margin-left: 0.5rem;
    }
    img {
      width: 100%;
      // @include wh(100%, 18rem);

    }
    .search {
      position: absolute;
      top: 1.2rem;
      left: 1rem;
    
    }
  
    .search img {
      position: absolute;
      @include ct;
      top: 58%;
      @include wh(1.1rem, 1.1rem);
    }
    .user_message {
      // padding: 1.2rem;
      // padding-top: 0.5rem;
      margin-left: 1rem;
    }
    .user_message p {
        @include sc(0.6rem,#8C8C8C);
        margin-bottom: 0.5rem;
        white-space: nowrap; 
        // width: 100%; 
        overflow: hidden;
        text-overflow:ellipsis;
    }
     .user_message .content {
        @include sc(0.7rem,#505050);
         display: inline-block;
          // white-space: nowrap; 
          width: 100%; 
          height: 1.2rem;
          white-space: nowrap; 
          // width: 100%; 
          overflow: hidden;
          text-overflow:ellipsis;

     }
    .home_title {
        @include sc(0.9rem,#262B40);
        
      font-weight: 600;

      line-height: 30px;
      
    }
    
   .bottom_btn {
     height: 3rem;
      width: 100%;
   }
  .bottom_time {
    
    @include sc(0.9rem,#262B40);
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    display: inline-block;
  }
  .right_btn {
    float: right;
    width: 9rem;
    font-size: 0.8rem;
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    margin-top: 1rem;
    
  }
  .bottom_time {
    line-height: 4rem;
  }
  .right_btn div {
    
    display: inline-block;
    width: 4rem;
    height: 2rem;
    line-height: 2rem;
    text-align: center;
    border-radius: 0.3rem;
    box-sizing: border-box;
  }
  .cancel_btn {
    border: 0.1rem solid #787878;
    color: #787878;
  }
  .go_pay_btn {
    
    background: #FF807B;
    border: 0.1rem solid #FF807B;

    color: #fff;
    margin-left: 0.3rem;
  }
</style>