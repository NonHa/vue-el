<template>
  <div style="background:#F7F7F8; overflow: hidden;">
   
    <NavBarHead :title="title" @goBack="goBackArticle" @showItem="showArticleItem"></NavBarHead>
      <div class="head_main_active">
        <!-- <div> -->
          <img :src="avtiveMes.activity_poster" alt="">
          <div :class="activeStatus ? 'doing_state' : 'done_state'">
            {{ activeStatus ? '进行中' : '已结束' }}
          </div>
          
        <!-- </div> -->
        <div class="main_title_active">
          优质精英单身联会, 你想要的好对象在这里！
        </div>
        <div style="padding: 0 0.9rem; margin-top: 0.9rem">
            <span>
            邀请人数: {{avtiveMes.no_of_invite}}人
          </span>
          <span style="margin-left: 1rem">
            已报名: {{avtiveMes.no_of_applicants}}人
          </span>
        </div>
      </div>
      <div class="active_message">
        <div v-for="(item, index) in activeList" :key="index">
          <span class="main">{{ item.name }}</span>
          <span class="content">{{ item.value }}</span>
        </div>
        <div class="active_introduce">
           <span class="main" >活动说明:</span>
          <div class="content" style="margin: 0">
            {{avtiveMes.activity_description}}
          </div>
          <span class="main" style="margin-top: 0.5rem">参与对象:</span>
          <div class="content" style="margin: 0">
            全平台用户
          </div>
        </div>
      </div>
     <div class="link_content_btn">
        
     <van-button type="primary" style="margin-bottom:1rem"  @click="goVisite">立即报名</van-button>
     <!-- <van-button v-else style="background-color: #A8A8A8;border: #A8A8A8" type="primary" >报名结束</van-button> -->
    </div>
  </div>
</template>

<script>
import NavBarHead from '../components/NavBarTab'
import {  
  getActivityDetailsById,
  activityApplicants
} from '../../service/getData'
import moment from 'moment'
export default {
  components: {  NavBarHead },
  watch: {
    $route(to,from) {
      if (from.path == '/active') {
        this.getActiveMes()
      }
    }
  },
  data() {
    return {
       title: '活动详情',
       avtiveMes: {},
       activeList: [
         { name: '活动主办:', value: ''},
         { name: '活动地点:', value: ''},
         { name: '活动时间:', value: ''},
         { name: '截止报名:', value: ''},
         { name: '费用说明:', value: ''},
       ],
       dostate: '进行中',
       activeId: null,
       activeStatus: false,
    }
  },
  created() {
     
    // console.log(this.$route.query.id);
    this.getActiveMes()
  },
  methods: {
    getActiveMes() {
      this.activeId = this.$route.query.id
      getActivityDetailsById({operate: 'getActivityDetailsById',id: this.activeId}).then(res => {
        console.log('res', res);
        if (res.Code == 0){
          console.log(JSON.parse(res.Result));

          this.avtiveMes =JSON.parse(res.Result)
          this.activeList[0].value = decodeURIComponent(this.avtiveMes.theme)
          this.avtiveMes.activity_poster = decodeURIComponent(this.avtiveMes.activity_poster)
          this.avtiveMes.activity_description = decodeURIComponent(this.avtiveMes.activity_description)
          this.activeList[1].value = decodeURIComponent(this.avtiveMes.activity_addr)
          this.activeList[2].value = this.avtiveMes.activity_time
          this.activeList[3].value = this.avtiveMes.deadline
          this.activeList[4].value = this.avtiveMes.application_fee + '元'
          const nowTime = moment(this.activeList[2].value).diff(moment().format('YYYY-MM-DD 00:00:00')) 
          this.activeStatus = nowTime>0
         
          console.log(JSON.parse(res.Result));
         
        }
      })
    },
    goBackArticle() {
      this.$router.go(-1)
    },
    showArticleItem() {

    },
    goVisite() {
      activityApplicants({operate: 'activityApplicants', id:this.activeId}).then(res => {
        console.log('res', res);
        if (res.Code == 0) {
          this.$toast(res.Msg)
          this.getActiveMes()
        } else {
          this.$toast(res.Msg)
          
        }
      })
    }
  }
   
}
</script>

<style lang="scss" scoped>
   @import '../../style/mixin';

  .link_content_btn {
   margin-top: 0.9rem;
    padding: 0 0.9rem;
    width: 100%;
    
  }
  .van-button {
       @include sc(0.9rem,#FF807B);
       @include wh(100%,2.1rem);
    
  }
  // .van-button--primary {
  //   background-color: #404868;
  //       border: 1px solid #404868
  // }
  .head_main_active {
    position: relative;
    @include wh(19.4rem,14rem);
    margin-top: 3.5rem;
    background-color:#fff;
    margin-left: 0.9rem;
    overflow: hidden;
    box-shadow: 0px 4px 20px 0px rgba(0, 0, 0, 0.06);
    border-radius: 10px;
  }
  .head_main_active img {
    position: relative;
    top: -1.2rem;
    display: inline-block;
    @include wh(100%,9.2rem);
    
  }
   .doing_state , .done_state{
    position: absolute;
    top: 0;
    right: 0;
    @include sc(0.8rem,#fff);
    @include wh(3.8rem,1.4rem);
    font-weight: 400;
   
    line-height: 1.4rem;
    text-align: center;
    border-radius: 0px 8px 0px 8px;

  }
   .doing_state {
      background-color: #FF807B;
   }
  .done_state {
     background-color: #8C8C8C;
  }
  .main_title_active {
  
    margin-top: -1.4rem;
    padding: 0 0.9rem;
       @include sc(1rem,#262B40);
    font-family: PingFangSC-Semibold, PingFang SC;
    font-weight: 600;
    // line-height: 1.2px;
    // margin-top: rem;
  }
  .head_main_active span {
       @include sc(0.8rem,#787C84);

  }
 
  .active_message {
    width: 19.4rem;
    height: 25rem;
    margin-left: 0.9rem;
    margin-top: 0.9rem;
    padding: 0.9rem;
    background-color: #fff;
    line-height: 1.7rem;
    overflow: hidden;
    
    box-shadow: 0px 4px 20px 0px rgba(0, 0, 0, 0.06);
    border-radius: 8px;
    font-family: PingFangSC-Medium, PingFang SC;
  }
  .active_message .main {
       @include sc(0.8rem,#262B40);
    
    font-weight: 600;
  }
  .active_message .content {
    margin-left: 0.5rem;
       @include sc(0.8rem,#505050);

  }
  .active_introduce {
    margin-top: 1.2rem;
    padding-top: 0.5rem;
    overflow: hidden;
    border-top: 1px solid #E0E0E0;
  }
</style>