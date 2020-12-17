<template>
  <div style="background-color: #F7F7F8" >
    <!-- <NavBarHead class="nav_other_class" :title="title" :border="false" @goBack="goBackArticle" @showItem="showArticleItem"></NavBarHead> -->
   
   <div class="img_show">
        <img  src="../../assets/bg_ invitation_pink.png" alt="">
        
        <div class="go_back_right">
          <img @click="goBackHome" src="../../assets/icon_return_white.png" alt="">
        </div>
        <div class="show_more_left" @click="showReport">
          <img src="../../assets/icon_more_white.png" alt="">
        </div>
        <div class="mesVisite">
          {{ headMes }}
        </div>
      <div  class="imageMes">
        <div  class="imageMes_head">
           <div class="avator">
            <img  :src="userMes.photo" alt="">
            
          </div>
          <div class="name_address">
            <div class="name">
              <span>
                  {{ userMes.nickname }}，{{ userMes.age }}岁
              </span>
            </div>
            <div class="address">
              <span class="message_address">
                {{ userMes.job_addr }}/{{ userMes.job}}/{{ userMes.salary }}
              </span>
        
              </div>
          </div>
        </div>
         
      </div>
      
    </div>
   <div class="caledar_item">
      <calendar 
        v-model="show"
        @confirm="onConfirm"  
        />
   </div>
      
    <div class="link_content">
       
        <div class="base_search">
          <div class="main_title">
            <span>邀约开场白</span>
          </div>
          <!-- <div class="introduce_mes">
             您好，可以邀请 您到一瓢婚恋书馆见个面吗？
          </div> -->
          <Radio ref="radio" :radioList="radioList" @showVisible="setMes"></Radio>
        </div>
       <div class="base_search">
          <div class="main_title">
            <span>邀约地点</span>
          </div>
          <div class="introduce_mes">
             一瓢婚恋书馆(长沙市岳麓区后湖)
          </div>
          <!-- <Radio ref="radio" :radioList="radioList"></Radio> -->
        </div>
     <!-- <van-button 
      :class="{ 'btn_color' :userMes.sex == '2' , 
      'btn_color_blue': userMes.sex == '1'}" 
      type="primary" 
      @click="goVisite">马上邀约</van-button> -->
    </div>
   <van-dialog v-if="dialogShow" v-model="dialogShow" title="温馨提示" closeOnClickOverlay closeOnPopstate :showConfirmButton="false">
         线下邀请已成功发送，请您耐心等待对方的回应。
         <div class="sureSet" @click="sureSet">确定</div>
  </van-dialog> 
  <van-dialog 
    v-if="sureVisiteDialog" 
    v-model="sureVisiteDialog" 
    title="您的邀约信息"
    style="height: 17rem;line-height:1.5rem"
     closeOnClickOverlay 
     closeOnPopstate 
     :showConfirmButton="false">
         邀约开场白:{{visiteMes.msg}} <br/>
         邀约地点:  一瓢婚恋书馆(长沙市岳麓区后湖)<br/>
        邀约时间：{{visiteDate}}<br/>
         是否邀约？
         <div class="sureSet2" @click="sureVisiteDialog = false">取消</div>
         <div class="sureSet3" @click="goVisite">确定</div>
  </van-dialog> 
    <van-action-sheet 
      v-model="show" 
      :actions="commendList" 
      @select="onSelect"
      cancel-text="取消"
      close-on-click-action 
    /> 
  </div>
</template>

<script>

import NavBarHead from '../components/NavBarTab'
import calendar from '../components/Calendar '
import Radio from '../components/Radio'
import BaseHeader from '../components/BaseHeader'
import { 
  createInviteMsg 
  } from '../../service/getData'

export default {
  components: { NavBarHead, calendar, Radio, BaseHeader},
  data() {
    return {
      title: '',
      show: false,
      dialogShow: false,
      show: false,
      commendList:[
        {name: '举报'},
        {name: '拉黑'},
      ],
      headMes: '马上发出您的线下邀约吧~',
      address: '地点：长沙市岳麓区后湖一瓢婚恋书馆',
   
      radioList: [
        { value: ' 您好，对您印象蛮好的能认识您吗?'},
        { value: ' 您好，很想更进一步认识您，可否能线下见面彼此了解一下呢？'},
        
      ],
      visiteMes: {
        operate: 'createInviteMsg',
        lab: 'invite',
        to_openid: '',
        status: '',
        addr: ''
      },
      sureVisiteDialog: false,
      ids: '',
      sexFlag: false,
      visiteDate: '',
      userMes: {
       
      }
    }
  },
  watch: {
    $route(to, from) {
      console.log('form-customer', from);
     if (from.path=="/customer/index") {
          console.log('to2', to);
        if (to.params && to.params.userMes) {
          console.log('to1', to);
        this.setBaseMes()
      }
     }
    }
  },
  created() {
    this.setBaseMes()
  },
  methods: {
    setMes() {
      this.visiteMes.msg = this.radioList[this.$refs.radio.radio].value
      this.sureVisiteDialog = true
    },
    setBaseMes() {
      var item = this.$route.params.userMes
      if (item) {
        console.log('item', item);
         this.userMes = item
          this.visiteMes.to_openid = item.openid
          this.dialogShow = false
      }
    },
    goVisite() {
      this.sureVisiteDialog = false
      this.visiteMes.addr = 0
      this.visiteMes.msg = this.radioList[this.$refs.radio.radio].value 
      console.log(this.radioList[this.$refs.radio.radio].value);
      this.userMes.msg = this.radioList[this.$refs.radio.radio].value
      if (this.userMes.meet_time && this.userMes.msg) {
        createInviteMsg(this.visiteMes).then(res => {
          if (res.Code == 0) {
            this.dialogShow = true
            this.ids = res.Result
            } 
          })
      } else {
        if (!this.userMes.meet_time) {
          this.$toast('请选择邀约时间');
        } else if (!this.userMes.msg) {
          this.$toast('请输入邀约开场白');
        }
        
      }
      
    },
   
    onConfirm(date) {
      this.visiteDate = JSON.parse(JSON.stringify(date))
      
       this.userMes.meet_time = date
      this.visiteMes.meet_time = Number((new Date(date)).getTime())/1000
      if (this.visiteMes.msg) {
        this.sureVisiteDialog = true
      }
    },
    goBackHome() {
      this.$router.push({ path: '/customer'})
    },
    showHomeItem() {

    },
    goMoreMes() {
      this.$router.push({ path: '/customer/message'})

    },
    goMoreChoose() {
      this.$router.push({ path: '/customer/choose'})

    },
    sureSet() {
      this.dialogShow = false
      this.userMes.ids = this.ids
      this.$router.push({name: 'success', params: { userMes: this.userMes }})
    },
     showReport() {
      console.log(111);
      this.show = true
    },
     onSelect() {

    }
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
   .link_content {
    margin-top: 0rem;
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

  .van-radio {
    height: 3rem;
  }
  .caledar_item {
    margin-top: -2rem;
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