<template>
  <van-pull-refresh   
    v-model="isLoading" 
    style="min-height: 100vh;padding-bottom:4rem"
    @refresh="onRefresh">
       <div class="main_head">
      <img src="../../assets/bg_personal_center.png" alt="">
       <div class="content_show">
          <div class="avator_content">
            <img :src="userList.user.photo" alt=""  
            @click="showImage(userList.user.photo)">
          </div>
          
          <div class="title_name">
             <span class="name">
              {{ userList.user.nickname }}
            </span>
             <!-- <span class="unique_message" :style="session.vip_id != 1 ? 'background: #CE7676;' : ''">
                {{ session.vip_id == 1 ? '单身联合创始人' : session.vip_id == 2 ? '钻石会员' : session.vip_id == 3 ? '精英会员' : session.vip_id == 4 ? '普通会员' : session.vip_id == 5 ? '基础会员' : '非会员23333' }}
                </span> -->
            <span class="title">
              一瓢ID：{{ userList.user.id }}
            </span>
          </div>
        <div class="time" @click="goEdit">
          编辑资料
        </div>
        <div class="user_num_tip">
          <router-link :to="{name:'loveNum'}">
            <span class="num">{{ getMyLoveCount1 }}</span>
            <span class="tip">我喜欢的</span>
          </router-link>
          <router-link :to="{name:'loveNum'}">
            <span class="num">{{ getByLoveCount1 }}</span>
            <span class="tip">喜欢我的</span>
          </router-link>
          <router-link :to="{name:'Mine'}">
            <span class="num">{{ getInviteCount1.inviteCount }}</span>
            <span class="tip">我的邀约</span>
          </router-link>
      </div>
      </div>
      
      <div class="mine_vip_img">
          <router-link :to="{name:'vip'}">

        <img src="../../assets/pic_mine_member.png" alt="">
          </router-link>

      </div>
    </div>
    <div class="main_customer_select">
        <!-- <van-cell class="cell_other" v-for="(item, index) in userList" :title="item.name" value-class="valur_class" value="不限" title-class="cell_class" :key="index" is-link /> -->
    <div>
      <van-cell 
        class="mina_check" 
        title="我的认证" 
        is-link 
        @click="gocheck(checkState)" >
      <template #title>
        <img src="../../assets/icon_authentication_blue.png" alt="">
        <span class="custom-title">我的认证</span>
        
      </template>
    </van-cell>
    </div>
    <van-cell 
      class="vip_check" 
      title="会员认证" 
      :value="checkState.real_vip != 1 ? '未认证 ' : '已认证'" 
      value-class="vip_more" 
      is-link 
      @click="goCheckVip"
      >
      <template #title>
        <img src="../../assets/icon_member_blue.png" alt="">
        <span class="custom-title">会员认证</span>
        
      </template>
    </van-cell>
     <van-cell 
      class="phone_bind" 
      title="手机绑定" 
      :value="tel ? '已绑定' : '未绑定'"  
      value-class="phone_more" 
      is-link
      @click="bindPhone"
       >
       <template #title>
        <img src="../../assets/icon_phone_blue.png" alt="">
        <span class="custom-title">手机绑定</span>
        
      </template>
    </van-cell>
    
    <div>
       <van-cell 
        class="produce" 
        title="推荐人" 
        value-class="produce_more" 
         @click="commendDialogVisible"
        :value="checkState.real_referrer.status != 2 ? '待审核' : '已认证'"
        is-link
        >
       <template #title>
        <img src="../../assets/icon_recommend_blue.png" alt="">
        <span class="custom-title">推荐人</span>
        
      </template>
    </van-cell>
    </div>
     <div>
       <van-cell 
        class="produce" 
        title="我的订单" 
        value-class="produce_more" 
        to="/order"
        is-link
        >
       <template #title>
        <img src="../../assets/icon_order_blue.png" alt="">
        <span class="custom-title">我的订单</span>
        
      </template>
    </van-cell>
    </div>
     
    <van-cell 
      class="price" 
      title="我的礼物" 
      is-link >
       <template #title>
        <img src="../../assets/icon_gift_blue.png" alt="">
        <span class="custom-title">我的礼物</span>
        
      </template>
    </van-cell>
    </div>
    <div>
       <van-cell 
        class="produce" 
        title="我的黑名单" 
        value-class="produce_more" 
        to="/report"
        is-link
        >
       <template #title>
        <img src="../../assets/icon_block_blue.png" alt="">
        <span class="custom-title">我的黑名单</span>
        
      </template>
    </van-cell>
    </div>
    <div>
       <van-cell 
        class="produce" 
        title="设置" 
        value-class="produce_more" 
        to="/setting"
        is-link
        >
       <template #title>
        <img src="../../assets/icon_set_blue.png" alt="">
        <span class="custom-title">设置</span>
        
      </template>
    </van-cell>
    </div>
     <van-dialog  
        
        class="login_dialog_2" 
        title="原手机验证" 
        closeOnClickOverlay 
        closeOnPopstate 
        :showConfirmButton="false"
        v-model="phoneBindDialog"
        v-if="phoneBindDialog"
        >
         <phone-bind @success="bindPhoneNew"></phone-bind>
    </van-dialog> 
     <van-dialog  
        
        class="login_dialog_2" 
        title="绑定新手机号码" 
        closeOnClickOverlay 
        closeOnPopstate 
        :showConfirmButton="false"
        v-model="phonenewBindDialog"
        v-if="phonenewBindDialog"
        >
         <bind-new-phone @success="getCheckState"></bind-new-phone>
    </van-dialog> 
    <van-dialog  
        class="login_dialog"
        style="height: 20rem"
        v-model="commentVisible" 
        v-if="commentVisible"
        title="登录" 
        closeOnClickOverlay 
        closeOnPopstate 
        :showConfirmButton="false">
         <commend-dialog @success="getCheckState"></commend-dialog>
    </van-dialog>
     <van-action-sheet 
          v-model="show" 
          :actions="commendList" 
          @select="onSelect"
          close-on-click-action 
        /> 
     </van-pull-refresh>
</template>

<script>
import { 
  getBasicInfo,
  getAuthenticate,
  getMyLoveCount,
  getByLoveCount,
  getInviteCount,
  getVVIPList,
  addRealReferrerVerify
  } from '../../service/getData'
import phoneBind from './phone-bind'
import commendDialog from './commend-dialog'
import bindNewPhone from './bind-new-phone'
import {ImagePreview} from "vant"

import { getSession, setSession, setIdxCity } from '../../utils/auth' // get token from cookie

export default {
  components: { phoneBind, commendDialog,bindNewPhone},
  data() {
    return {
      images: [],
     phoneBindDialog: true,
     commentVisible: true,
     phonenewBindDialog: true,
     getMyLoveCount1: 0,
     getByLoveCount1: 0,
     getInviteCount1: {
       inviteCount: 0
     },
     show: false,
     isLoading: false,
     commendList: [
      
     ],
     userList: {
       user: {
         photo: ''
       }
     },
     flag: true,
     checkState: {
       real_referrer: {
         status: 1
       },
        real_vip: 0
     },
     tel: '',
     session: {
       vip_id: 1
     }
    }
  },
  watch: {
   
  },
  created() {
    this.getMienList()
    this.phoneBindDialog = false
    this.commentVisible = false
    this.phonenewBindDialog = false

  },
  mounted() {
    this.phoneBindDialog = false
    this.commentVisible = false
    this.phonenewBindDialog = false

  },
  methods: {
    onRefresh() {
      this.getMienList()
    },
     getComment() {
       getVVIPList().then(res => {
        if (res.Code == 0) {
           this.commendList = JSON.parse( res.Result)
           console.log('JSON.parse( res.Result)', JSON.parse( res.Result));
           if (this.commendList && this.commendList.length> 0) {
             
             var otherList = this.commendList.map(({nickname , openid}) => ({
               name: decodeURIComponent(nickname),
               value: openid
             }))
             this.commendList = otherList
             console.log('commendList', this.commendList);
           }
            this.getCheckState()
           
        } else {
          this.$toast(res.Msg);
        }
      })
    },
    showImage(image, index) {
      this.images = []
        this.images.push(image)
      ImagePreview({images: this.images});
    },
    getByLove() {
      getByLoveCount().then(res => {
       
        if (res.Code == 0) {
          this.getByLoveCount = JSON.parse(res.Result)
        }
      })
    },
    getMyLove() {
      getMyLoveCount().then(res => {
        
        if (res.Code == 0) {
          this.getMyLoveCount1 = JSON.parse(res.Result)
        }
      })
    },
    getInvite() {
      var user = JSON.parse(getSession())
      console.log('user',user);
      if (user.userid) {
         getInviteCount({operate:"getInviteCount", msg_id: user.userid}).then(res => {
        if (res.Code == 0) {
          this.getInviteCount1 = JSON.parse(res.Result)
        }
      })
      }
     
    },
    getMienList() {
      this.falg = false
      getBasicInfo({operate: 'getBasicInfo'}).then(res => {
        if (res.Code == 0) {
          this.isLoading = false;

          this.session = res.session
          this.userList = res.Result ? JSON.parse(res.Result) : {}
          console.log('userList', this.userList);
          this.userList.user.nickname = decodeURIComponent(this.userList.user.nickname)
          this.userList.user.photo = decodeURIComponent(this.userList.user.photo)
          this.getByLove()
          this.getMyLove()
          this.getInvite()
          this.getCheckState()
        } else {
           this.$toast(res.Msg);
        }
      })
    },
    bindPhoneNew() {
      this.phoneBindDialog = false
      this.phonenewBindDialog = true
    },
    getCheckState() {
       this.phoneBindDialog = false
      this.phonenewBindDialog = false
      getAuthenticate({operate: 'getAuthenticate'}).then(res => {
        if (res.Code == 0) {
          this.checkState = res.Result ? JSON.parse(res.Result) : {}
         
          console.log('this.checkState', this.checkState);
          this.tel = res.session.tel  
        } else {
          this.$toast(res.Msg);
        }
      })
    },
    bindPhone() {
      if (this.tel) {
        this.phoneBindDialog = true
      } else {
      this.phonenewBindDialog = true
      }
    },
    
    phonenewBind() {
      this.phonenewBindDialog = false
    },
    commendDialogVisible() {
       if (this.checkState.real_referrer.status != 2) {
         this.show = true
          this.getComment()
      }
     
    },
    onSelect(val) {
      console.log('command', val);
      addRealReferrerVerify({operate: 'addRealReferrerVerify', real_referrer: val.value}).then(res => {
        if (res.Code == 0) {
          this.$emit('success')

           this.$toast(res.Msg);
        } else {
          this.$toast(res.Msg);
        }
      })
    },
    goCheckVip() {
       
       if (this.checkState.real_vip != 1) {
         this.$router.push({ name: 'vip', params: { userId:this.userList} })
       }
       

    },
    gocheck(val) {
      if (this.checkState) {
        this.$router.push({ name: 'mineCheck' ,params: { item: this.checkState} })
      }
       
     },
    goEdit() {
       this.$router.push({ name: 'Edit', params: { user: this.userList } })

    }
  }
   
}
</script>

<style lang="scss" scoped>
    @import '../../style/mixin';
    .main_head {
      position: relative;
      width: 100%;
      background-color: #EFF1F8;
      font-family: PingFangSC-Semibold, PingFang SC;
    }
    .main_head img {
        @include wh(100%, 100%);

    }
    .content_show {
      position: absolute;
      top: 2.2rem;
      padding: 0.9rem;
      height: 5rem;
      font-family: PingFangSC-Regular, PingFang SC;
    }
  .avator_content {
    float: left;
    @include wh(4rem, 4rem);
    border-radius: 50%;
    margin-right: 0.5rem;
    background-color: #f2f3f5;
    overflow: hidden;
  }

  .avator_content img {
    @include wh(100%, 100%);

  }
  .title_name {
    float: left;
    margin-left: 1.5rem;
    // line-height: 2rem;
    width: 5rem;
  }
  .title_name .name{
    display: inline-block;
    padding: 0 0.2rem;
    font-weight: 600;
    margin-top: 1rem;
    @include sc(1.1rem, #262B40);
    white-space: nowrap; 
    // width: 100%; 
    overflow: hidden;
    text-overflow:ellipsis;
  }
  .unique_message {
    margin-top: 0.8rem;
  }
  .title_name .name div {
    position: absolute;
    top: 0.3rem;
    left: 3rem;
    @include wh(3rem, 1.1rem);
    border-radius: 15px;
    line-height: 1.1rem;
    text-align: center;
    @include sc(0.6rem, #FF807B);

    border: 1px solid #FF807B;
  }
   .title_name .title{
    @include sc(0.6rem, #505050);
    font-weight: 400;
  }
  .time {
    float: left;
    margin-left: 3rem;
    margin-top: 2rem;
    @include sc(0.6rem,#505050);
    font-weight: 400;
    width: auto;
  }
   .time::after {
    content: '';
    display: inline-block;
    border-top: 1px solid #000;
    border-right: 1px solid #000;
    width: 0.4rem;
    height: 0.4rem;
    transform: rotate(45deg) scaleY(1);

   }
  .user_num_tip {
    position: relative;
    bottom: -1rem;
    display: flex;
    height: 3rem;
    width: 100%;
   
  }
  .user_num_tip a{
    flex: 1;
    display: inline-block;
    display: flex;
     justify-content: center;
     align-items: center;
    flex-direction: column;
  }
  
  .user_num_tip .num {
        @include sc(0.7rem,#262B40);

  line-height: 1.2rem;
  }
  .user_num_tip .tip {
    @include sc(0.6rem,#8C8C8C);

    line-height: 1.2rem;
  }
  .main_customer_select span {
    @include sc(0.6rem,#262B40);

  }
  .vip_more span{
    color: #B99268 !important;
    line-height: 1.7rem;
    @include sc(0.6rem,#B99268);

  }
  .phone_more span{
    line-height: 1.7rem;

    @include sc(0.6rem,#A0A0A0);

  }
  .produce_more {
    line-height: 1.7rem;

    @include sc(0.6rem,#A0A0A0);

  }
  .van-cell {
    padding: 10px;
  }
  .van-cell__left-icon, .van-cell__right-icon {
    @include sc(0.6rem,#A0A0A0);
    line-height: 1.8rem;
  }
  .van-cell--clickable {
    @include wh(100%,3.2rem);

    padding-left: 3rem;
    overflow: hidden;
    border: 1px solid #E0E0E0;
  }
  .van-cell__title {
    position: relative;
    line-height: 1.7rem;
  }
  .van-cell__title img {
    position: absolute;
    @include wh(1.1rem,1.1rem);
    margin-top: 1.1rem;
    left: -1.9rem;
    top: -0.8rem;
  }
  .login_dialog_2 {
    height: 16.2rem;
  }
  .van-popup--bottom  {
    bottom: 3rem
  }
  .mine_vip_img {
    height: 5rem;
    width: 100%;
    padding: 0 0.8rem;
    background-color: #EFF1F8;
  }
  .mine_vip_img img {
    
    height: 100%;
  }
</style>