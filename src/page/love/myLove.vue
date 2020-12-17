<template>
  <div>
    <div >
      
       <van-tabs
         @change="getTabIndex" 
         v-model="active" 
         class="accset" 
         color= "#FF807B"  
         line-width="1.1rem" 
         line-height="0.25rem" 
         swipeable
         :ellipsis="false"
         sticky  
         >
      <div class="search">
        <van-row class="goBack_search">
          <van-col span="2">
              <img @click="goHome" src="../../assets/icon_return.png" alt="">
          </van-col>
          
        </van-row>
      </div>
      <van-tab v-for="(item, index) in tabList" :title="item" :key="index" title-inactive-color="#FF807B">
         <van-pull-refresh 
           v-model="isLoading"
           style="min-height: 100vh;" 
           @refresh="onRefresh">
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
                    第 <strong style="color:#FF807B">2</strong> 次浏览你 5天前访问过你
                  </p>
                </div>
                <div class="like_add_touch">
                  <img  
                 
                  src="../../assets/icon_like.png"
                   alt=""
                   @click="loveTigger"
                   >
                  喜欢
                  <img style="margin-left: 1.1rem" src="../../assets/pull_strings.png" alt="">牵线
                </div>
            </div>
           
            
          </div>
        </div>
        
        <!-- 上拉加载 -->
         <!-- <van-list
          v-model="loading"
          :finished="finished"
          finished-text="没有更多了"
          @load="onLoad"
          :offset="5"
          :immediate-check="false"
          ref="mylist"
        >
          <slot></slot>
        </van-list> -->
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
import moment from 'moment'
import { getSession, setSession, setIdxCity } from '../../utils/auth' // get token from cookie

export default {
  props: {
   
  },
  watch: {
    $route(to,from) {
      console.log('toQuery', to);
      if (to.query.v) {
        console.log('to.query.v', to.query.v);
        this.listQuery.type = to.query.v
        if (to.query.v == 'creater') {
          this.active = 3
          console.log(this.active );
        } else if (to.query.v == 'vip') {
          this.active = 2

        } else if (to.query.v == 'foreign') {
          this.active = 4
          
        } else if (to.query.v == 'real_name_user') {
          this.active = 1
          
        } else {
          this.listQuery = {
              operate : 'getIndexData'
            }
          this.active = 0
        }
        this.getList()
      }
    }
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
        tabList: ['浏览我的', '我浏览的'],
        }
      },
      
      created() {
        console.log('query',this.$route);
        var v= this.$route.query.v
        
        
      },
      methods: {
        getList() {
          getIndexData(this.listQuery).then(res => {
            if (res.Code == 0) {
              setSession(res.session)
              
              this.isLoading = false
              if (res.Result) {
                this.homeList = JSON.parse(res.Result)
                console.log(' this.homeList',  this.homeList);
                if ( this.homeList instanceof Array) {
                  this.homeList.recommander = JSON.parse(JSON.stringify(this.homeList))
                 
                  this.homeList.recommander ? this.homeList.recommander.forEach(item => {
                    item.nickname ? item.nickname = decodeURIComponent(item.nickname) : ''
                    item.photo ? item.photo = decodeURIComponent(item.photo) : ''
                    item.img_url ? item.img_url = decodeURIComponent(item.img_url) : ''
                    item.real_referrer ? item.real_referrer.nickname = decodeURIComponent(item.real_referrer.nickname) : ''
                     item.salary ? item.salary = this.vipActionSheet.salary2[item.salary].name : ''
                     item.constellation ? item.constellation = this.vipActionSheet.constellations[item.constellation].name : ''
                     item.job_addr ? item.job_addr = (this.areaList.city_list[item.job_addr] || this.areaList.county_list[item.job_addr]) : ''
                    item.birthday ? item.age = moment().diff(moment(item.birthday), "years") : ''
                  //  console.log(item.photo);
                  }) : ''
                } else {
                 
                  this.homeList ? this.homeList.recommander.forEach(item => {
                    item.nickname ? item.nickname = decodeURIComponent(item.nickname) : ''
                    item.photo ? item.photo = decodeURIComponent(item.photo) : ''
                    item.img_url ? item.img_url = decodeURIComponent(item.img_url) : ''
                    item.real_referrer ? item.real_referrer.nickname = decodeURIComponent(item.real_referrer.nickname) : ''

                    item.salary =  (item.salary && item.salary < 6)  ? this.vipActionSheet.salary2[item.salary].name : item.salary
                     item.constellation ? item.constellation = this.vipActionSheet.constellations[item.constellation].name : ''
                     item.job_addr ? item.job_addr = (this.areaList.city_list[item.job_addr] || this.areaList.county_list[item.job_addr]) : ''

                      item.birthday ? item.age = moment().diff(moment(item.birthday), "years") : ''
                  //  console.log(item.photo);
                  }) : ''
                }
              } else {
                this.isLoading = false
                 this.$toast('暂无用户信息');
                this.homeList = []
              }
                
            } else {
               this.$toast(res.Msg);
            }
          })
        },
         getTabIndex(index) {
           
          //  console.log(index);
          //  if (index == 0) {
          //     this.listQuery.operate = 'getIndexData'
          //   } else if (index == 1) {
          //     this.listQuery.operate = 'getRecommend'
          //     this.listQuery.type = 'real_name_user'

          //   }  else if (index == 2) {
          //     this.listQuery.operate = 'getRecommend'
          //     this.listQuery.type = 'vip'

          //   }  else if (index == 3) {
          //     this.listQuery.operate = 'getRecommend'
          //     this.listQuery.type = 'creater'

          //   } else if (index == 4) {
          //     this.listQuery.operate = 'getRecommend'
          //     this.listQuery.type = 'foreign'
          //   }
          //   this.getList()
          },
        onRefresh() {
         this.getTabIndex(this.active)
        },
       
        onChange(index) {
          this.index = index;
        },
        goArtivle() {
          this.$router.push({path : '/article'})
        },
        goLove() {
          this.$router.push({path : '/love'})

        },
        goCustomerPage(item) {
          this.$router.push({name: 'customer', params: { item: item}})

        },
        loveTigger(state) {
          if (state.islove == 0) {
            addLove({operate: 'addLove', to: state.openid}).then(res => {
               if (res.Code == 0) {
                 this.getList()
                
              } else {
                  this.$toast(res.Msg);
              }
            })
          } else {
            delLove({operate: 'delLove', to: state.openid}).then(res => {
               this.getList()
            })
          }
        },
         toSearchPage() {
            this.$router.push({path: '/search'})
        },
         goHome() {
          this.$router.go(-1)
        }
      }
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
    
   
    .like_add_touch {
        @include sc(0.7rem, #262B40);
      @include wh(100%, 1.4rem);

    }
    .like_add_touch img {
      vertical-align:middle;
      margin-right: 0.2rem;
      @include wh(1.4rem, 1.4rem);

    }
    .swrip_img {
     
     height: 8rem;
     background-color: #f7f7f9;
    
     overflow: hidden;
    }
    
   
    .van-swipe-item {
      position: relative;
      // @include wh(50%, 6rem);
      width: 45% !important;
    }
   
     .search_top {
        background-color:#FFFFFF;
				 padding: 0.6rem 0.9rem;
				 padding-bottom: 0;
        @include wh(100%, 3.5rem);
       
    }
    .search_content {
        background-color: #F2F2F2;
        line-height: 2.1rem;
        @include sc(0.8rem, #A0A0A0);
        @include wh(100%, 2.1rem);

    }
    .search_content img {
        display: inline-block;
        margin: 0 0.5rem;
        @include wh(0.7rem, 0.7rem);

    }
    .head_logo{
        left: 0.4rem;
        font-weight: 400;
        @include sc(0.7rem, #fff);
        @include wh(2.3rem, 0.7rem);
        @include ct;
    }
    .command {
      width: 100%;
      height: 1.8rem;
      padding-left: 1.1rem;
      background: #E3CCB3;
      border-radius: 0px 0px 0.3rem 0.3rem;
      font-size: 0.7rem;
      font-family: PingFangSC-Regular, PingFang SC;
      font-weight: 400;
      color: #262B40;
      line-height: 1.8rem;
    }
    .swipe {
      margin-top: 1rem;
    }
    .swipe img {
      width: 14.5rem;
      height: 6rem;
      margin: 0 auto;
      // margin-left: 1rem;
    }
    .article_text,.article_text2 {
      position: absolute;
      top: 30%;
      left: 35%;
      font-size: 0.7rem;
      font-family: PingFangSC-Regular, PingFang SC;
      font-weight: 400;
      color: #262B40;
      line-height: 1rem;
    }
    .article_text2 {
      left: 50%;
    }
</style>