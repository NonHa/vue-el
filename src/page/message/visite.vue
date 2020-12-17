<template>
  <div style="background-color: #F7F7F8" >
    <!-- <NavBarHead class="nav_other_class" :title="title" :border="false" @goBack="goBackArticle" @showItem="showArticleItem"></NavBarHead> -->
   
   <!-- <setSuccess ref="times" @confirm="confirm" @goHome="goBackHome" :accept="true" :address="address" :headMes="headMes" :visiteList="userList"></setSuccess> -->
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
            <img  :src="userList.photo" alt="" 
            @click="showImage(userList.photo)">
            
            >
            
          </div>
          <div class="name_address">
            <div class="name">
              <span>
                  {{ userList.nickname }}，22岁
              </span>
            </div>
            <div class="address">
              <span class="message_address">
                {{userList.job_addr }}/{{userList.job}}/{{userList.salary}}
              </span>
        
              </div>
          </div>
        </div>
        <div class="message_tip">
           {{ visiteList.update_by != 1 ? userList.lab : '' }}
         
          <img src="../../assets/quotation_marks.png" alt="">
        </div>
          <div class="images_address2">
            <span class="address_mes">
            见面地点：一瓢婚恋书馆(长沙市岳麓区后湖)
            </span>
          </div>
          <div class="images_address3">
            <span class="address_mes">
            见面时间：{{ userList.meet_time }}
            </span>
            <span class="modify" @click="modifyTime">修改</span>
          </div>
      </div>

      
    </div>
     <van-action-sheet 
      v-model="show" 
       >
       <van-datetime-picker
          v-model="currentDate"
          type="datetime"
          title="选择完整时间"
          :min-date="minDate"
          
          @confirm="getconfirm"
          :formatter="formatter"
          @cancel="show = false"
        />
      </van-action-sheet>

    <div class="link_content" >
          <div class="link_content_visite">
            <span>您的回复：</span>
            <span class="visite_content" style="display: block">
              <van-field
               v-if="visiteList.status == 3 "
                  v-model="userList.lab"
                  rows="4"
                  autosize
                  class="field_padding"
                  type="textarea"
                  placeholder=""
                />
          <Radio v-else ref="radio" :radioList="radioList"></Radio>
            
            </span>
        </div>
        <div class="button" v-show="visiteList.status != 3">
          <van-row v-if="visiteList.status == 5">
          
            <van-col span="24" >
              <van-button   type="primary" @click="goVisite">重新邀约</van-button>
            </van-col>
          
          </van-row>
          <div v-else>
            <van-row  gutter="8">
              <van-col span="10">
                <van-button plain class="btn_color" type="primary" @click="dotAcceptVisite">拒绝邀约</van-button>
                
              </van-col>
              <van-col span="14">
                <van-button   type="primary" @click="AcceptVisite">接受邀约</van-button>
              </van-col>
            
            </van-row>
            <!-- <div class="wanring">
              *对方还未完成实名认证，请您谨慎接受邀约
            </div> -->
          </div>
        </div>
     
    </div>
       <van-action-sheet 
        v-model="showReportVisible" 
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
import { getInviteMsg, updateInviteMsg,getUserByID } from '../../service/getData'
import moment  from 'moment'

import {ImagePreview} from "vant"
import { 
  actionSheet, 
  vipActionSheet, 
  areaList 
  } from '../components/actioneSheet'
export default {
  components: { NavBarHead, calendar, Radio},
  data() {
    return {
      title: '',
      show: false,
      showReportVisible: false,
      headMes: 'TA发来的心动邀约~',
      address: '地点：长沙市岳麓区后湖一瓢婚恋书馆',
      areaList: areaList,
      vipActionSheet: vipActionSheet,
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
       minDate: new Date(2020, 0, 1),
      // maxDate: new Date(2025, 10, 1),
      currentDate: new Date(),
      radioList: [
        { value: '您好，感谢您的邀约，会准时赴约！'},
        { value: '您好，感谢您的邀约，不能赴约！'},
        
      ],
      times: '',
      visiteList: {},
      visiteQuery: {},
      userList: {},
      userMesList: {},
      listQuery: {},
      commendList:[
        {name: '举报'},
        {name: '拉黑'},
      ],
    }
  },
   watch: {
    $route(to, from) {
      if (to.path == '/message/visite') {
         console.log(1111);
        this.userList = JSON.parse(JSON.stringify(to.params.item))
        this.getMesById()
        this.getUserMes()
      }
    }
  },
  created() {
   
    this.userList = JSON.parse(JSON.stringify(this.$route.params.item))
    this.getMesById()
    this.getUserMes()
    
  },
  methods: {
     showImage(image, index) {
      this.images = []
        this.images.push(image)
      ImagePreview({images: this.images});
    },
    getUserMes() {
      getUserByID({operate: 'getUserByID', id: this.userList.id}).then(res => {
        if (res.Code == 0) {
          this.userMesList = JSON.parse(res.Result)
          
          const {job_addr, job, salary} = this.userMesList.base
          this.$set(this.userList, 'job_addr', job_addr ? (this.areaList.city_list[job_addr] || this.areaList.province_list[job_addr]) : '')
          this.$set(this.userList, 'job', job)
          this.$set(this.userList, 'salary', salary ? this.vipActionSheet.salary2[salary].name : '')
          }
      })
     
    },
    formatter(type, val) {
      if (type === 'year') {
        return val + '年';
      }
      if (type === 'month') {
        return val + '月';
      }
      if (type === 'day') {
        return val + '日';
      }
      if (type === 'hour') {
        return val + '时';
      }
      if (type === 'minute') {
        return val + '分';
      }
      return val;
    },
  
     getMesById() {
     
      this.visiteQuery.operate = 'getInviteMsg'
      this.visiteQuery.msg_id = this.userList.msg_id,
      getInviteMsg(this.visiteQuery).then(res => {
        if (res.Code != 0) {
           this.$toast(res.Msg);
        } else {
          var visiteList = JSON.parse(res.Result)
          console.log('visiteList =>', visiteList);
         
          this.visiteList = visiteList.last_invite
          //  this.headMes = this.visiteList.status == 0 ? '已拒绝TA的邀约' : this.visiteList.status == 1 ? '接受TA的邀约' : 'TA发来的心动邀约~'
          this.userList.lab = this.visiteList.msg
          this.userList.addr = this.visiteList.addr
           var time = new Date(Number(this.visiteList.meet_time)*1000);
          var y = time.getFullYear();
          var m = time.getMonth()+1;
          var d = time.getDate();
          var h = time.getHours();
          var mm = time.getMinutes();
          var s = time.getSeconds();
          this.visiteList.meet_time = y+'-'+m+'-'+d+' '+h+':'+mm+':'+s;
          this.userList.meet_time = this.visiteList.meet_time
          this.userList.status = this.visiteList.status
          this.headMes = this.userList.status == 5 ? '已拒绝TA的邀约'  :this.userList.status == 3 ? '接受TA的邀约':  '邀约待接受' 
        }
      })
    },
    confirm(val) {
      this.times = val ? (new Date(val)).getTime() : (new Date()).getTime()
    },
     getconfirm(item) {
        this.show = false
        this.userList.meet_time =  moment(item).format('YYYY-MM-DD hh:mm')
    
      },
    
      modifyTime() {
        this.show = true
      },
     dotAcceptVisite() {
      this.times = this.userList.meet_time ? (new Date(this.userList.meet_time)).getTime()/1000  : (new Date()).getTime()/1000
      this.visiteQuery.msg = this.radioList[this.$refs.radio.radio].value 
      console.log( this.visiteQuery.msg);
      console.log(this.times);
       updateInviteMsg({operate: 'updateInviteMsg', meet_time: this.times,status: 5, addr: '0', msg: this.visiteQuery.msg, msg_id: this.visiteList.msg_id}).then(res => {
         if (res.Code == 0) {
           this.getMesById()
            this.$toast("取消邀约成功");
         } else {
             this.$toast("取消邀约失败");
         }
         
       })
     
    },
     AcceptVisite() {
      this.visiteQuery.msg = this.radioList[this.$refs.radio.radio].value 
      this.times = this.userList.meet_time ? (new Date(this.userList.meet_time)).getTime()/1000  : (new Date()).getTime()/1000
      console.log(this.times);
       updateInviteMsg({operate: 'updateInviteMsg',addr: '0', status: 3,msg: this.visiteQuery.msg, msg_id: this.visiteList.msg_id, meet_time: this.times}).then(res => {
         if (res.Code == 0) {
            this.$toast('接受邀约成功！');
          this.getMesById()
         }else {
            this.$toast("接受邀约失败");
         }
       })
      
    },
    goVisite() {
      this.times = this.userList.meet_time ? (new Date(this.userList.meet_time)).getTime()/1000  : (new Date()).getTime()/1000
      updateInviteMsg({operate: 'updateInviteMsg',addr: '0', msg_id: this.visiteList.msg_id, status: 1,msg: this.visiteQuery.msg, meet_time: this.times}).then(res => {
        if (res.Code == 0) {
          this.$toast(res.Msg);
        this.getMesById()
        }else {
          this.$toast(res.Msg);
        
        }
      })
    },
    showReport() {
      console.log(111);
      this.showReportVisible = true
    },
    goBackHome() {
      this.$router.go(-1)
    },
    onSelect(e) {
      if (e.name=="举报") {
        this.$router.push({name: 'reportMessage'})
      }
      
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
  
  .link_content_visite {
    margin-left: 0;
    margin-top: 0;
   
  }
  .more_picture {
    position: absolute;
    @include sc(1rem,#FFFFFF);
    
  }
  .field_padding {
     margin: 0 auto;
     padding: 0rem;
      height: 4rem; 
      border-radius: 10px;
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
    margin-top: -5rem;
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
   margin-top: 20px;
   bottom: 0;
    width: 19.6rem;
    // margin-left: 0.9rem;
  }
  .img_show {
    margin-bottom: 0;
    
  }

</style>