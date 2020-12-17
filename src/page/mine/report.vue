<template>
  <div>
    <head-content title="我的黑名单"></head-content>
    <div class="all_day_content">
         
          <div 
           
            class="all_day_content_item"
            
            >
            <div class="left_item">
              <div class="checkSure" >
                <img  src="../../assets/successful_certification.png" alt="">
                <!-- <img :src="item.photo" alt=""> -->
                认证客户
              </div>
              <img src="../../assets/bg_personal_center.png" alt="" @click="goCustomerPage" >
            </div>
            <div class="user_message"  >
                <div @click="goCustomerPage" >
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
                  <p class="content">
                    最好的感情会让两个人变得…
                  </p>
                </div>
               <div class="btn_detail">
                 移出名单
               </div>
            </div>
           
            
          </div>
        </div>
  </div>
</template>

<script>

import {  
  getMessageCount, 
  getBeInvitedList,
  getInviteList, 
} from '../../service/getData'
import headContent from '../components/headContent'
import moment from 'moment'
export default {
	components: { headContent },
    data() {
      return {
       
      }
    },
		watch: {
   
  },
    created() {
      
    },
    methods: {
     goCustomerPage() {

     }
    },
   

}
</script>

<style lang="scss" scoped>
    @import '../../style/mixin';
  
    .all_day_content {
     
      padding: 0.9rem;
      padding-top: 0;
      width: 100%;
      background-color: #f7f7f9;
      margin-bottom: 3rem;
      // @include wh(100%, 100%);
    }
    .all_day_content_item {
      position: relative;
      display: flex;
       border-radius: 5px;
      background-color: #fff;
      margin-top: 0.9rem;
      height: 8rem;
       font-family: PingFangSC-Semibold, PingFang SC;
       
      box-shadow: 0px 4px 20px 0px rgba(0, 0, 0, 0.06);
      border-radius: 10px;
    }
    .left_item {
      height: 100%;
      width: 8rem;
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
   
   
    img {
      width: 100%;
      // @include wh(100%, 18rem);

    }
    
    .user_message {
      padding: 1.2rem;
      padding-top: 0.5rem;
     
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
    .btn_detail {
      width: 5rem;
      height: 1.4rem;
      background: #FFFFFF;
      border-radius: 0.2rem;
      border: 1px solid #FF807B;
      font-size: 0.6rem;
      font-family: PingFangSC-Regular, PingFang SC;
      font-weight: 400;
      color: #FF807B;
      line-height: 1.1rem;
      text-align: center;
    }
</style>
