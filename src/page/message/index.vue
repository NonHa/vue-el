<template>
  <van-tabs 
    @change="getIndex" 
    v-model="index" 
    class="accset" 
    color= "#FF807B"  
    line-width="1.1rem" 
    ine-height="0.25rem" 
    swipeable
    sticky  >
    <van-tab 
      v-for="(item, index) in homeTabList" 
      :title="item" :key="index" 
      title-inactive-color="#FF807B"
      >
      <van-pull-refresh   
        v-model="isLoading"
        style="min-height: 100vh;" 
        @refresh="onRefresh"
        >
        <div style="padding-bottom: 4rem">
          <div v-if="index == 0">
            <van-skeleton  
              title 
              avatar 
              :row="1"  
              :loading="loading" 
              
              >
              <div 
                class="content_show" 
                v-for="(item, index) in chatList"
                :key="index"
                @click="getVisiteById(item.user_info)"
                >
                <div style="position: relative" >
                  <div :class="{ avator_content: item.status == 1 || item.status == 3  || item.status == 5, avator_content_border: item.status == 3 }">
                      <img :src="item.user_info.photo" alt="">
                  </div>
                  <div v-if="item.invite.have_read == 0" class="getMessage"></div>

                </div>
                <div class="title_name">
                  <span class="name">
                      <div class="name_lenght">
                        {{ item.user_info.nickname }}
                      </div>
                    
                      <div class="success_visite" v-if="item.status == 2">
                        成功邀约
                      </div>
                  </span>
                  <span class="title">
                    {{ item.invite.update_by == 1 ? item.invite.msg : ''}}
                  </span>
                </div>
                <div class="time">
                  {{ item.create_time }}
                </div>
              </div>
            </van-skeleton>
          </div>
          <!-- 收到邀约 -->
          <div v-else>
            <van-skeleton 
              title 
              avatar 
              :row="1"  
              :loading="loading" 
              >
          <div 
            class="content_show"
            v-for="(item, index) in messageList"
            :key="index"
            @click="acceptResult(item.user_info)">
            <div style="position: relative">
                <div :class="{ avator_content: item.status == 1 || item.status == 3 || item.status == 5, avator_content_border: item.status == 3 }">
                  <img :src="item.user_info.photo" alt="">
                </div>
                <div  v-if="item.user_info.isreal == 0" class="getMessage"></div>
            </div>
            <div class="title_name">
               <span class="name">
                  <div class="name_lenght">
                    {{ item.user_info.nickname }}
                  </div>
                
                  <div class="success_visite" v-if="item.status == 3">
                    成功邀约
                  </div>
              </span>
              
              <span class="title">
              {{ item.user_info.lab }}
              </span>
            </div>
            <div class="time">
              {{ item.create_time }}
            </div>
            </div>
          </van-skeleton>
          </div>
        </div>
      </van-pull-refresh>
    </van-tab>
  </van-tabs>
</template>

<script>

import {  
  getMessageCount, 
  getBeInvitedList,
  getInviteList, 
} from '../../service/getData'
import moment from 'moment'
export default {
	components: {},
    data() {
      return {
        homeTabList: ['发出邀约', '收到邀约', ],
        index: 0,
        count: {},
        isLoading: false,
        loading: true,
        count: {},
        messageList: [],
        chatList: []
      }
    },
		watch: {
   
  },
    created() {
      this.getChstMes()
    },
    methods: {
      getIndex(index) {
         if (index == 0) {
            this.getChstMes()
          } else {
            this.getMesList()
          }
      },
      onRefresh() {
        console.log('index', this.index);
      if (this.index == 0) {
        this.getChstMes()
      } else {
        this.getMesList()

      }
    },
        
    getCount() {
      getMessageCount({ operate: 'getMessageCount' }).then(res => {
        if (res.code == 0) {
          this.count = res.Result
        }
      })
    },
    getMesList() {
      getBeInvitedList().then(res => {
        if (res.Code == 0 ) {
          this.loading = false
          this.isLoading = false

          this.messageList = res.Result ? JSON.parse(res.Result) : []
          console.log('messageList', this.messageList);
          
          this.messageList.forEach(item => {
         
            item.create_time = moment(Number(item.create_time) * 1000).format('YYYY-MM-DD hh:mm:ss');
           
            if (item.user_info) {
              item.user_info.status = item.status
              item.user_info.msg_id = item.id
               item.user_info.nickname = decodeURIComponent(item.user_info.nickname)
              item.user_info.photo = decodeURIComponent(item.user_info.photo)
              item.user_info.create_time =  item.create_time
            }
            
          })
        } else {
          this.loading = false
          this.isLoading = false
           this.$toast('暂无邀约信息');
        }
      })
    },
    getChstMes() {
      getInviteList().then(res => {
         if (res.Code == 0 ) {
          this.loading = false
          this.isLoading = false
          this.chatList = res.Result ? JSON.parse(res.Result) : []
          console.log('chatList', this.chatList);
          this.chatList.forEach(item => {
           
            item.create_time = moment(Number(item.create_time) * 1000 ).format('YYYY-MM-DD hh:mm:ss');
            if (item.user_info) {
              item.user_info.status = item.status
              item.user_info.msg_id = item.id
              item.user_info.nickname = decodeURIComponent(item.user_info.nickname)
              item.user_info.photo = decodeURIComponent(item.user_info.photo)
              var newTime = new Date(Number(item.user_info.create_time) * 1000)
              item.user_info.create_time = item.create_time
            }
            

          })
        } else {
          this.loading = false
          this.isLoading = false
           this.$toast('暂无邀约信息');
        }
      })
    },
    getVisiteById(val) {
      this.$router.push({ name: 'chat', params: { item: val}})

    },
   
    acceptResult(val) {
      this.$router.push({ name: 'visite', params: { item: val}})

    },
    },
   

}
</script>

<style lang="scss" scoped>
    @import '../../style/mixin';


	.van-skeleton {
    padding: 0.9rem;
    
    border-bottom: 1px solid #E0E0E0;
    height: 5rem;
  }
  .van-skeleton__title+.van-skeleton__row {
    margin-top: 0.2rem;
  }
  .van-skeleton__avatar {
    width: 3rem !important;
    height: 3rem !important;
        // @include wh(3rem, 3rem);

  }
  .content_show {
    background-color: #fff;
    display: flex;
    padding: 0.9rem;
    border-bottom: 1px solid #E0E0E0;
    height: 5rem;
    font-family: PingFangSC-Regular, PingFang SC;
  }
  .avator_content {
   
    @include wh(3rem, 3rem);
    border-radius: 50%;
    margin-right: 0.5rem;
    background-color: #f2f3f5;
    overflow: hidden;
  }
  .avator_content_border {
   border: 2px solid #FF807B;
    @include wh(3rem, 3rem);
    border-radius: 50%;
    margin-right: 0.5rem;
    background-color: #f2f3f5;
    overflow: hidden;
  }
  .getMessage {
    position: absolute;
    top: 0;
    // left: 1rem;
    right: 0.3rem;
    @include wh(0.9rem, 0.9rem);
    background: #FF5050;
    border: 2px solid #FFFFFF;
    z-index: 2;
    border-radius: 50%;
  }
  .avator_content img {
    @include wh(100%, 100%);

  }
  .title_name {
    flex: 1;
    margin-left: 0.5rem;
    line-height: 2rem;
    width: 50%;
  }
  .title_name .name{
    font-size: 15px;
    color: #000;
    font-weight: 400;

  }
  .name_lenght {
    max-width: 4rem;
    white-space: nowrap; 
    // width: 100%; 
    overflow: hidden;
    text-overflow:ellipsis;
  }
  .title_name .name .success_visite {
   
    @include wh(3rem, 1.1rem);
    border-radius: 15px;
    line-height: 1.1rem;
    text-align: center;
    @include sc(0.6rem, #FF807B);
    border: 1px solid #FF807B;
    margin: 0.2rem 0 0 0.2rem;
  }
   .title_name .title{
    @include sc(0.6rem, #6E6E6E);
    font-weight: 400;
    margin-top: 0.5rem;
  }
  .title {
    width: 70%;
  }
  .title, .time {
    display: inline-block;
    white-space: nowrap; 
    // width: 100%; 
    overflow: hidden;
    text-overflow:ellipsis;
  }
  .time {
    @include sc(0.6rem, #B4B4B4);
    font-weight: 400;
    margin-top: 0.4rem;
 
  }
</style>
