<template>
  <div style="background-color: #F7F7F8" >
    <!-- <NavBarHead class="nav_other_class" :title="title" :border="false" @goBack="goBackArticle" @showItem="showArticleItem"></NavBarHead> -->
   
   <!-- <HeaderCancel @goHome="goBackHome" :accept="true" :address="address" :headMes="headMes" :userList="userList"></HeaderCancel> -->
   <div class="img_show">
        <img   src="../../assets/bg_ invitation_pink.png" alt="">
        <div class="go_back_right">
          <img @click="goBackHome" src="../../assets/icon_return_white.png" alt="">
        </div>
        <div class="show_more_left">
          <img src="../../assets/icon_more_white.png" alt="">
        </div>
        <div class="mesVisite">
          与 {{ userList.nickname }} 的线下邀约~
        </div>
    
       <div  class="imageMes">
        <div  class="imageMes_head">
          
          <div class="name_address2">
            <div class="name2">
            <span>
                {{userList.status == 0 ? '邀约已拒绝' : userList.status == 1 ? '邀约待接受' : userList.status == 2 ? '邀约已接受' : ''}}
            </span>
          </div>
          <div class="address2">
            <span  class="message_address">
              时间：{{ userList.meet_time }}
            </span>
        
          </div>
          </div>
           <div class="avator2">
            <img  :src="userList.photo" alt="" 
            @click="showImage(userList.photo)"
            >
            
          </div>
        </div>
        <div style="margin-left: 1.4rem" class="images_address">
          <span  class="address_mes">
            一瓢婚恋书馆(长沙市岳麓区后湖)
          </span>
        </div>
      </div>
    </div>

     <div class="link_content_visite">
        <span>对方回复:</span>
        <span class="visite_content">
          {{ chatList.update_by == 2 ? chatList.msg : ''}}
        </span>
    </div>
    <div class="link_content" v-if="chatList.state == 'CAN'">
        <div class="base_search">
          <div class="main_title">
            <span>回复邀约</span>
          </div>
           <span class="visite_content" style="display: block">
             <van-field
                v-model="visiteQuery.msg"
                rows="4"
                autosize
                class="field_padding"
                type="textarea"
                placeholder=""
              />
          
          </span>
          
        </div>
     <div class="button" >
        <van-row v-if="chatList.status == '0'">
          <van-col span="24">
            <van-button   type="primary" @click="goVisite">重新邀约</van-button>
          </van-col>
        </van-row>
        <div v-else>
           <van-row  gutter="8" >
            <van-col span="10">
              <van-button 
                plain 
                class="btn_color" 
                type="primary" 
                @click="dotAcceptVisite"
                >拒绝邀约</van-button>
            </van-col>

            <van-col span="14">
              <van-button   
                type="primary" 
                @click="AcceptVisite"
                >接受邀约</van-button>
            </van-col>
          </van-row>
          <!-- <div class="wanring">
            *对方还未完成实名认证，请您谨慎接受邀约
          </div> -->
        </div>
      </div>
       
     
    </div>
     
  </div>
</template>

<script>

import NavBarHead from '../components/NavBarTab'
import calendar from '../components/Calendar '
import Radio from '../components/Radio'
import BaseHeader from '../components/BaseHeader'
import { getInviteMsg , updateInviteMsg, getUserByID} from '../../service/getData'
import {ImagePreview} from "vant"

export default {
  components: { NavBarHead, calendar, Radio},
  data() {
    return {
      title: '',
      headMes: '',
      address: '地点：长沙市岳麓区后湖一瓢婚恋书馆',
      baseMessage: [
        { name: '工作单位', filed: '长沙市周南中学'},
        { name: '职业', filed: '教师'},
        { name: '年收入', filed: '10w~20w'},
        { name: '学历', filed: '本科'},
        { name: '毕业学校', filed: '长沙理工大学'},
        { name: '身高', filed: '160cm'},
        { name: '体重', filed: '45kg'},
        { name: '星座', filed: '处女座'},
        { name: '婚姻状态', filed: '从未结婚'},
      ],
      radioList: [
        { value: '很高兴认识你，我们一瓢婚恋馆见~'},
        { value: '有缘遇见你，愿我们有个愉快的约会~'},
        
      ],
      chatQuery: {
        page: 1
      },
      chatList: {},
      userList: {},
      userMesList: {},
      images: []
    }
  },
  watch: {
    $route(to, from) {
      if (to.path == '/message/chat') {
        this.userList = JSON.parse(JSON.stringify(to.params.item))
        this.getMesById(to.params.item)
      
       
      }
    }
  },
  created() {
    var item = this.$route.params.item
    this.userList = JSON.parse(JSON.stringify(item))
    this.getMesById(item)
   
  },
  methods: {
     showImage(image, index) {
      this.images = []
        this.images.push(image)
      ImagePreview({images: this.images});
    },
    getMesById(val) {
      this.chatQuery.operate = 'getInviteMsg',
      this.chatQuery.msg_id = val.msg_id,
      getInviteMsg(this.chatQuery).then(res => {
        if (res.Code != 0) {
           this.$toast(res.Msg)
        } else {
          var chatList = JSON.parse(res.Result)
          console.log('chatList', chatList);
           this.chatList = chatList.last_invite
          var time = new Date(Number(this.chatList.meet_time)*1000);
          var time2 = new Date(Number(chatList.invite_msg.create_time)*1000);
          var y = time2.getFullYear();
          var m = time2.getMonth()+1;
          var d = time2.getDate();
          var h = time2.getHours();
          var mm = time2.getMinutes();
          var s = time2.getSeconds();
          this.chatList.meet_time = y+'-'+m+'-'+d+' '+h+':'+mm+':'+s;
          this.userList.lab = this.chatList.msg
          this.userList.addr = this.chatList.addr
          this.userList.meet_time = this.chatList.meet_time
          this.userList.status = this.chatList.status
        }
      })
    },
    goVisite() {
      updateInviteMsg({operate: 'updateInviteMsg',addr: '0', status: 1, msg_id: this.chatQuery.msg_id}).then(res => {
         if (res.Code == 0) {
            this.$toast(res.Msg);
          this.getInviteMsg()
         }else {
            this.$toast(res.Msg);
         }
       })

    },
     dotAcceptVisite() {
     updateInviteMsg({operate: 'updateInviteMsg', addr: '0',status: 5,  msg_id: this.chatList.msg_id}).then(res => {
         if (res.Code == 0) {
            this.$toast(res.Msg);
           this.getInviteMsg()
         } else {
            this.$toast(res.Msg);
         }
       })
    },
     AcceptVisite() {
       updateInviteMsg({operate: 'updateInviteMsg',addr: '0', status: 1,msg_id: this.chatList.msg_id}).then(res => {
         if (res.Code == 0) {
            this.$toast(res.Msg);
          this.getInviteMsg()
         }else {
            this.$toast(res.Msg);
         }
       })
    },
    goBackHome() {
      this.$router.push({ path: '/message'})
    },
    showHomeItem() {

    },
   
    
  }
}
</script>

<style lang="scss" scoped>
@import '../../style/mixin';
  

  .nav_other_class {
    background-color: rgba(0,0,0,0) !important;
    // opacity: 0
  }
  
 
  
  .like_num {
   height: 0.9rem;
    @include sc(0.8rem, #8C8C8C);

    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;

    line-height: 0.9rem;
  }

  
  .van-row {
   
    height: 2rem;
    color: #646464 !important;
    font-size: 0.8rem !important;
      // @include sc(0.8rem,#646464);
    font-family: PingFangSC-Regular, PingFang SC !important;
    font-weight: 400 !important;
    
    line-height: 2rem;
  }
  .introduce_mes {
    @include sc(0.9rem,#646464);
    margin-top: 0.9rem;
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    line-height: 1.1rem;
  }
  .van-grid-item:last-child .van-image::before {
    content: '';
    position: absolute;
    
      @include wh(100%, 100%);
   
    opacity: 0.39;
    background-color: #000;

  }
  .more_picture {
    position: absolute;
    @include sc(1rem,#FFFFFF);
    
  }

  .sure_check {
      @include wh(100%, 6.5rem);
      background: #FAFAFA;
      border-radius: 0.3rem;
      margin-top: 0.9rem;
      border: 2px solid #E0E0E0;
      display: flex;
  }
  .sure_check div {
    padding: 0.9rem;
    text-align: center;
    flex: 1;
  }
  .sure_check img {
    display: block;
    margin-left: 0.8rem;
      @include wh(3.2rem, 3.2rem);

  }
  .field_padding {
     margin: 0 auto;
     padding: 0rem;
      height: 4rem; 
      border-radius: 10px;
   }
  .sure_check span {
    @include sc(0.8rem,#262B40);
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    
    line-height: 24px;
  }
  .van-tag--primary.van-tag--plain {
    @include sc(0.8rem,#505050);

  }
  .van-tag--primary {
    background-color: #F6F6F6;
  }
  .van-tag {
    border: 0;
    margin-left: 0.3rem;
    margin-top: 0.4rem;
    padding: 0.4rem 1rem;
    
  }
  .lw_look {
    @include wh(3.2rem, 3.2rem);
  }

  .gave_more {
      @include wh(100%, 6.5rem);
      display: flex;
  }
  .gave_more .sure_name {
    padding: 0.9rem;
    text-align: center;
    flex: 1;
   

  }
  .sure_name div {
     @include wh(5rem, 5rem);
    border-radius: 50%;
    border: 1px solid #fff;
  }
  .pink {
    // border: 1px solid ;
   
    box-shadow: 0px 6px 30px 0px rgba(255, 128, 123, 0.3);
    
  }
  
 
 
  .van-button--primary {
    background-color: #FF807B;
    @include sc(0.9rem,#FFFFFF);
    border: 1px solid #FF807B;
     @include wh(100%, 2.5rem);

  }
 
  .link_content {
    margin-top: 4rem;
    overflow: hidden;
  }
  .link_content, .base_search {
    background-color: #FFFFFF;
  }
   .base_search {
     margin-top: 0.9rem;
   }

   .btn_color {
   
    background-color: #fff;
  }
  .btn_color .van-button__text {
       @include sc(0.9rem,#FF807B);

  }
  .wanring {
       @include sc(0.7rem,#404868);
       text-align: center;
    font-family: PingFangSC-Regular, PingFang SC;
    margin-top: 0.9rem;
    line-height: 0.9rem;
  }

  .button {
   position: fixed;
   bottom: 0;
    width: 19.6rem;
    // margin-left: 0.9rem;
  }
  .imageMes, .imageMes_title {
    padding-bottom: 0;
  }
 
</style>