<template>
  <div>
    
    <div >
        <div  class="search_top">
            <div class="search_content"  @click="toSearchPage">
                <img src="../../assets/samll_search.png" alt="">
                点击搜索您的真爱…
            </div>
        </div>
      
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

      <van-tab 
        v-for="(item, index) in tabList" 
        :title="item" 
        :key="index"
        
        title-inactive-color="#FF807B">
         
         <van-pull-refresh 
           v-model="isLoading"
           style="min-height: 100vh;" 
           @refresh="onRefresh">
            <van-notice-bar
            left-icon="volume-o"
            @click="$router.push({name: 'vip'})"
            background="#ecc185"
            color="#fff"
            text="温馨提示：您需要进行会员认证，点击前往认证"
          />
        <div class="all_day_content">
          <div 
            v-for="(item, index) in homeList.recommander" 
            class="all_day_content_item"
            
            :key="index">
            <div v-if="item.real_name_status == 1" class="checkSure" >
              <img  src="../../assets/successful_certification.png" alt="">
              <!-- <img :src="item.photo" alt=""> -->
              认证客户
            </div>
            <div class="picture">
              <!-- <img src="../../assets/icon_photo.png" alt=""> -->
              <div class="picture_num">
                  {{ item.img_count }}
              </div>
            </div>
            <img :src="item.photo ? item.photo : item.photo" alt="" @click="goCustomerPage(item)" >
           
            <div class="user_message"  >
                <div @click="goCustomerPage(item)" >
                  <span class="home_title">
                    {{ item.nickname ? item.nickname : '' }}
                    <!-- 何女士 -->
                  </span>
                  <span class="unique_message" :style="item.vip_id != 1 ? 'background: #CE7676;' : ''">
                  
                    {{ item.vip_id == 1 ? '单身联合创始人' : item.vip_id == 2 ? '钻石会员' : item.vip_id == 3 ? '精英会员' : item.vip_id == 4 ? '普通会员' : item.vip_id == 5 ? '基础会员' : '' }} 
                  </span>
                  <p>{{ item.age ?`${item.age}岁/` : ''}}{{ item.job_addr ? `${item.job_addr}/` : ''}}{{ item.salary ? `${item.salary}/` : ''}}{{ item.constellation ? `${item.constellation}/` : ''}}</p>
                  <p class="content">
                    {{ item.desc != -1 ? item.desc : '' }}
                  </p>
                </div>
                <div class="like_add_touch">
                  <img  
                  v-if="item.islove == 0"
                  src="../../assets/icon_like.png"
                   alt=""
                   @click="loveTigger(item)"
                   >
                  <img  
                    v-else
                    src="../../assets/icon_like_ select.png"
                    alt=""
                    @click="loveTigger(item)"
                    >喜欢
                  <img 
                    @click="goString"
                    style="margin-left: 1.1rem" 
                    src="../../assets/pull_strings.png" alt="">牵线
                </div>
            </div>
            <div class="command" v-show="item.real_referrer">
              推荐人: 一瓢婚恋{{item.real_referrer.nickname == '雪' ? `创始人${item.real_referrer.nickname}` : item.real_referrer.nickname}}
            </div>
            
          </div>
           <div class="swrip_img">
               <van-swipe class="swipe" :loop="false" :width="300" :show-indicators="false" >
                <van-swipe-item>
                  <div class="article_text">
                    <div style="font-size: 1rem;">
                      情感咨询
                    </div>
                    <div style="margin-top:0.4rem">
                      更了解我们的爱情
                    </div>
                  </div>
                  <img @click="goArtivle" src="../../assets/bg_ emotional.png" alt="">
                </van-swipe-item>
                <van-swipe-item>
                  <div class="article_text2">
                    <div style="font-size: 1rem;">
                      爱情定制
                    </div>
                    <div style="margin-top:0.4rem">
                      提供优质的服务保障
                    </div>
                  </div>
                  <img @click="goLove" src="../../assets/bg_ love.png" alt="">
                </van-swipe-item>
              
            </van-swipe>
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
        tabList: ['每日情缘', '实名用户','优质会员', '联合创始人', '海外华侨'],
        }
      },
      
      created() {
        console.log('query',this.$route);
        var v= this.$route.query.v
        if (v) {
         this.listQuery.operate = 'getRecommend'
          this.listQuery.type = v
          if (v == 'creater') {
            this.active = 3
          } else if (v == 'vip') {
            this.active = 2

          } else if (v == 'foreign') {
            this.active = 4
            
          } else if (v == 'real_name_user') {
            this.active = 1
            
          } else {
            this.listQuery = {
              operate : 'getIndexData'
            }
            this.active = 0
          }
         this.getList()
         
        } else {
          this.getList()
        }
        
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
           
           console.log(index);
           if (index == 0) {
              this.listQuery.operate = 'getIndexData'
            } else if (index == 1) {
              this.listQuery.operate = 'getRecommend'
              this.listQuery.type = 'real_name_user'

            }  else if (index == 2) {
              this.listQuery.operate = 'getRecommend'
              this.listQuery.type = 'vip'

            }  else if (index == 3) {
              this.listQuery.operate = 'getRecommend'
              this.listQuery.type = 'creater'

            } else if (index == 4) {
              this.listQuery.operate = 'getRecommend'
              this.listQuery.type = 'foreign'
            }
            this.getList()
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
        goString() {
            this.$router.push({name: 'Translator'})

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
       border-radius: 5px;
      background-color: #FFFFFF;
      margin-top: 0.9rem;
      @include wh(100%, 100%);
       font-family: PingFangSC-Semibold, PingFang SC;
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
    .user_message {
      padding: 1.2rem;
      padding-top: 0.5rem;
     
    }
    .user_message p {
        @include sc(0.7rem,#8C8C8C);
        margin-bottom: 0.5rem;
    }
     .user_message .content {
        @include sc(0.8rem,#505050);
         display: inline-block;
          // white-space: nowrap; 
          width: 100%; 
          height: 2.2rem;
          overflow: hidden;
          text-overflow:ellipsis;

     }
    .home_title {
        @include sc(0.9rem,#262B40);
        
      font-weight: 600;

      line-height: 30px;
      
    }
    
   
    .like_add_touch {
      margin-top: 1.5rem;
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