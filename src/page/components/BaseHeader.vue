<template>
  <div>
     <div class="img_show">
        <img  src="../../assets/bg_ invitation_pink.png" alt="">
        <!-- <img v-else src="../../assets/bg_ invitation_blue.png" alt=""> -->
        <div class="go_back_right">
          <img @click="goBackHome" src="../../assets/icon_return_white.png" alt="">
        </div>
        <div class="show_more_left" @click="showReport">
          <img src="../../assets/icon_more_white.png" alt="">
        </div>
        <div class="mesVisite">
          {{ headMes }}
        </div>
      <div v-if="!success && !visiteDone && !accept" class="imageMes">
        <div  class="imageMes_head">
           <div :class="{ 'avator' :user.sex == 2 ,'avator_blue': user.sex == 1} ">
            <img  :src="user.photo" alt="">
            
          </div>
          <div class="name_address">
            <div class="name">
              <span>
                  {{ user.nickname }}，{{ user.age }}岁
              </span>
            </div>
            <div class="address">
              <span class="message_address">
                {{ user.job_addr }}/{{ user.job}}/{{ user.salary }}
              </span>
        
              </div>
          </div>
        </div>
         
      </div>
       <div v-else-if="success && !visiteDone && !accept" class="imageMes">
        <div  class="imageMes_head">
          
          <div class="name_address2">
            <div class="name2">
            <span>
                邀约待接受
            </span>
          </div>
          <div class="address2">
            <span  class="message_address">
              时间：{{user.meet_time}}
            </span>
        
          </div>
          </div>
           <div :class="{ 'avator2' :user.sex == 2 ,'avator2_blue': user.sex == 1} ">
            <img  :src="user.photo" alt="">
            
          </div>
        </div>
        <div style="margin-left: 1.4rem" :class="{ 'images_address' :user.sex == 2 ,'images_address_blue': user.sex == 1}">
          <span  class="address_mes">
            {{ address }}
          </span>
        </div>
      </div>
       <div v-else-if="!accept" class="imageMes">
        <div  class="imageMes_head">
          
          <div class="name_address2">
            <div class="name2">
            <span>
                邀约成功
            </span>
          </div>
          <div class="address2">
            <span  class="message_address">
             时间：{{user.meet_time}}
            </span>
        
          </div>
          </div>
           <div :class="{ 'avator2' :user.sex == 2 ,'avator2_blue': user.sex == 1} ">
            <img  :src="user.photo" alt="">
            
          </div>
        </div>
        <div style="margin-left: 1.4rem" :class="{ 'images_address' :user.sex == 2 ,'images_address_blue': user.sex == 1} ">
          <span  class="address_mes">
            {{ address }}
          </span>
        </div>
      </div>
       <div v-else-if="accept" class="imageMes">
       <div  class="imageMes_head">
          <div :class="{ 'avator' :user.sex == 2 ,'avator_blue': user.sex == 1} ">
            <img  :src="user.photo" alt="">
            
          </div>
          <div class="name_address">
            <div class="name">
              <span>
                  {{ user.nickname }}，22岁
              </span>
            </div>
            <div class="address">
              <span class="message_address">
                {{ user.job_addr }}/{{ user.job}}/{{ user.salary }}
              </span>
        
              </div>
          </div>
        </div>
        <div class="message_tip">
          {{ user.nickname }} 你好，能否有幸约你线下见一面呢？
          <img src="../../assets/quotation_marks.png" alt="">
        </div>
          <div class="images_address2">
            <span class="address_mes">
            见面地点：长沙市岳麓区后湖一瓢婚恋书馆
            </span>
          </div>
          <div class="images_address3">
            <span class="address_mes">
            见面时间：{{user.meet_time}}
            </span>
            <span class="modify">修改</span>
          </div>
      </div>
       <van-action-sheet 
          v-model="show" 
          :actions="commendList" 
          @select="onSelect"
          cancel-text="取消"
          close-on-click-action 
        /> 
    </div>
  </div>
</template>

<script>
export default {
  props: {
    headMes: {
      type: String
    },
    success: {
      type: Boolean
    },
    address: {
      type: String
    },
    visiteDone: {
      type: Boolean
    },
    sucState: {
      type: Boolean
    },
    accept: {
      type: Boolean
    },
    user: {
      type: Object
    }
  },
  watch: {
    stateMes: {
      handler(val) {
        console.log(val, 'mes');
        if (val) {
          this.state = '邀约成功'
        } else {
          this.state = '邀约已拒绝'

        }
      },
      deep: true,
      immediate: true
    },
    $route(to, from) {
      if (from.path == '/home/message') {
         this.stateMes = this.sucState
      } else if (from.path == '/customer/visite') {
          this.state = '邀约待接受'
      }
      
    }
  },
  data() {
    return {
      state: '邀约待接受',
      stateMes: false,
      show: false,
      commendList:[
        {name: '举报'},
        {name: '拉黑'},
      ],

    }
  },
  created() {
    console.log(this.sucState, 'state');
   
    console.log(this.stateMes);
  },
  methods: {
    goBackHome() {
      this.$emit('goHome')
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
 
</style>