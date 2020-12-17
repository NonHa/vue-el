<template>
  <div style="background-color: #F7F7F8" >
    <!-- <NavBarHead class="nav_other_class" :title="title" :border="false" @goBack="goBackArticle" @showItem="showArticleItem"></NavBarHead> -->
     <div class="img_show">
        <img v-if="userMes.sex == 2" src="../../assets/bg_ invitation_pink.png" alt="">
        <img v-else src="../../assets/bg_ invitation_blue.png" alt="">
        <div class="go_back_right">
          <img @click="goBackHome" src="../../assets/icon_return_white.png" alt="">
        </div>
        <div class="show_more_left">
          <img src="../../assets/icon_more_white.png" alt="">
        </div>
        <div class="mesVisite">
          {{ headMes }}
        </div>
     
       <div  class="imageMes">
        <div  class="imageMes_head">
          
          <div class="name_address2">
            <div class="name2">
            <span>
                邀约待接受
            </span>
          </div>
          <div class="address2">
            <span  class="message_address">
              时间：{{userMes.meet_time}}
            </span>
        
          </div>
          </div>
           <div :class="{ 'avator2' :userMes.sex == 2 ,'avator2_blue': userMes.sex == 1} ">
            <img  :src="userMes.photo" alt="">
            
          </div>
        </div>
        <div style="margin-left: 1.4rem" :class="{ 'images_address' :userMes.sex == 2 ,'images_address_blue': userMes.sex == 1}">
          <span  class="address_mes">
            {{ address }}
          </span>
        </div>
      </div>
     
     
    </div>
      
    <div class="link_content_visite">
        <span>您的邀约开场白：</span>
        <span class="visite_content">{{ userMes.msg }}</span>
    </div>
    <div class="button" >
      <van-row v-if='!againVisite' gutter="8" class="link_content">
        <van-col span="10">
          <van-button plain v-if="userMes.sex == '2'" @click="dotAcceptVisite" class="primary_pink" type="primary">取消邀约</van-button>
          <van-button plain v-else class="primary_blue" @click="dotAcceptVisite"  type="primary">取消邀约</van-button>
           <!-- <van-button class="btn_color" type="primary" @click="goVisite">取消邀约</van-button> -->
        </van-col>
        <van-col span="14">
          <van-button   
            :class="{ 'btn_color' :userMes.sex == '2' , 
              'btn_color_blue': userMes.sex == '1'}" 
            type="primary" 
            @click="goVisite">修改邀约</van-button>
        </van-col>
       
      </van-row>
     
    </div>
  </div>
</template>

<script>

import NavBarHead from '../components/NavBarTab'
import calendar from '../components/Calendar '
import Radio from '../components/Radio'
import BaseHeader from '../components/BaseHeader'
import { getInviteMsg , updateInviteMsg, getUserByID} from '../../service/getData'

export default {
  components: { NavBarHead, calendar, Radio, BaseHeader},
  data() {
    return {
      title: '',
      titleMes: '您的邀约开场白：',
      content: '严女士 你好，能否有幸约你线下见一面呢？',
      headMes: '',
      address: '地点：长沙市岳麓区后湖一瓢婚恋书馆',
      showState: true,
      visiteState: true,
      againVisite: false,
      userMes: {
        sex: '2',
        nickname: ''
      }
    }
  },
  watch: {
   $route(to, from) {
      console.log('form-customer', from);
     if (from.path=="/customer/visite") {
        this.userMes = {}
        if (to.params && to.params.userMes) {
        this.setMessage()
      }
     }
    }
  },
  created() {
    this.setMessage()
  },
  methods: {
    setMessage() {
      this.userMes = this.$route.params.userMes ? this.$route.params.userMes : {}
      this.headMes = `与 ${ this.userMes.nickname ? this.userMes.nickname : '' } 的线下邀约~`
      console.log('this.userMesid', this.userMes);
      
    },
    dotAcceptVisite() {
     updateInviteMsg({operate: 'updateInviteMsg', status: 5,addr: '0', meet_time: Number((new Date(this.userMes.meet_time )).getTime())/1000 ,msg_id:this.userMes.ids, msg:this.userMes.msg}).then(res => {
         if (res.Code == 0) {
             this.$toast('成功取消邀约');
            this.$router.go(-1)
            
         } else {
            this.$toast(res.Msg);
         }
       })
    },
    goBackHome() {
      this.$router.go(-1)
    },
    goVisite() {
       updateInviteMsg({operate: 'updateInviteMsg', status: 5,addr: '0', meet_time:Number((new Date(this.userMes.meet_time )).getTime())/1000 ,msg_id:this.userMes.ids, msg:this.userMes.msg}).then(res => {
         if (res.Code == 0) {
            this.$toast('重新邀约成功,请重新填写邀约信息');
          this.$router.push({ path: '/customer/visite'})
         } else {
            this.$toast(res.Msg);

         }
       })
     
    }
  }
}
</script>

<style lang="scss" scoped>
@import '../../style/mixin';
  .link_content_visite {
    margin-top: -5rem;
    margin-left: 0.9rem;
    width: 19.6rem;
    font-family: PingFangSC-Semibold, PingFang SC;
    background: #FFFFFF;
    box-shadow: 0px 4px 20px 0px rgba(0, 0, 0, 0.06);
    border-radius: 10px;
    overflow: hidden;
    padding: 0.8rem;
    // @include wh(19.6rem, 12rem);


  }
  .link_content_visite span{
    @include sc(0.9rem,#323232);
   font-weight: 600;
    line-height: 1.5rem;
    display: inline-block;
  }
  .link_content_visite .visite_content {
    @include sc(0.8rem,#262B40);
    font-weight: 400;

    line-height: 1.1rem;
  }
  .button {
   position: fixed;
   bottom: 0;
    width: 19.6rem;
    margin-left: 0.9rem;
  }
  .van-button--primary {
    background-color: #FF807B;
    @include sc(0.9rem,#FFFFFF);
    border: 1px solid #FF807B;
     @include wh(100%, 2.5rem);

  }
  .btn_color {
   
    background-color: #fff;
  }
  .btn_color .van-button__text {
       @include sc(0.9rem,#FF807B);

  }
  .caledar_item {
    margin-top: 5rem;
    margin-left: 0.9rem;
    width: 19.6rem;
    
    box-shadow: 0px 4px 20px 0px rgba(0, 0, 0, 0.06);
    border-radius: 10px;
  }
  .link_content {
    overflow: hidden;
  }
  .link_content, .base_search {
    background-color: #FFFFFF;
  }
   .base_search {
     margin-top: 0.9rem;
   }
</style>