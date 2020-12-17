<template>
  <div style="background-color: #F7F7F8" >
    <div class="img_show">
        <img class="img_bg" src="../../../assets/bg_personal_center.png" alt="">
        <div class="go_back_right">
          <img @click="goBackHome" src="../../../assets/icon_return_black.png" alt="">
         
        </div>
         <div class="title">
          我的认证
        </div>
        <div class="more">
          认证项越多，曝光率越高
        </div>
      <div  class="imageMes">
        <div class="imageMes_item">
           <div >
            <img v-if="checkMes.real_name.status == 1" src="../../../assets/real_name_select_big.png" alt="">
            <img @click="toNameCheck" v-else  src="../../../assets/real_name_big.png" alt="">
            <span>实名认证</span>
          </div>
           <div>
            <img v-if="checkMes.real_edu.status == 1" src="../../../assets/education_select_big.png" alt="">
            <img  @click="toEduCheck" v-else  src="../../../assets/work_big.png" alt="">
            
            <span>学历认证</span>

          </div>
           <div >
            <img v-if="checkMes.real_vip == 1" src="../../../assets/founder_certification_select_big.png" alt="">
            <img @click="toVipCheck" v-else src="../../../assets/founder_certification_big.png" alt="">
            
            <span>联合创始人</span>

          </div>
         
        </div>
         <!-- <div class="imageMes_item">
         
         </div> -->
      </div>
        
     
    </div>
  </div>
</template>

<script>

export default {
  components: { },
  data() {
    return {
      checkMes: {
        real_name: {
          status: 0
        },
        real_edu: {
          status: 0
        },
        real_vip: 0
      }
    }
  },
  watch: {
    $route(to, from) {
      if (from.path == '/mine') {
        console.log('to',to);
        if (to.params.item) {
           this.checkMes = to.params.item
        }
       
      }
    }
  },
  created() {
    // console.log('111112323');
    // console.log('this.$route', this.$route);
    // if (this.$route.params.item) {
    //   this.checkMes = this.$route.params.item
    // }
    
    // console.log('this.$route.params', this.$route.params);
    // console.log('checkMes', this.checkMes);
  },
  methods: {
    goBackHome() {
      this.$router.push({ name: 'Mine'})
    },
    toNameCheck() {
      this.$router.push({ name: 'nameCheck'})

    },
    toEduCheck() {
      this.$router.push({ name: 'educationCheck'})

    },
    toVipCheck() {
      this.$router.push({ name: 'vip'})

    }
  }
}
</script>

<style lang="scss" scoped>
    @import '../../../style/mixin';

.img_show {
  height: 11rem;
}
.imageMes {
  padding-bottom: 2rem;
  font-size: 14px;
}
.img_show .imageMes .imageMes_item{
   display: flex;
    @include wh(19.2rem, 10rem);
    background-color: #fff;
    justify-content: center;
    align-items: center;
    padding: 0;
 }
 .img_show .imageMes .imageMes_item div {
   flex: 1;
   display: flex;
  flex-direction: column;
   justify-content: center;
   align-items: center;
 }
 .img_show .imageMes img {
    @include wh(5rem, 5rem);
    
 }
 .title {
   position: absolute;
   width: 5rem;
   top: 1rem;
	left: 50%;
	transform: translateX(-50%);
 }
 .more {
    position: absolute;
   
   top: 5rem;
	left: 50%;
  transform: translateX(-50%);
    @include sc(1.1rem, #262B40);
   width: 100%;
   text-align: center;
    font-family: PingFangSC-Semibold, PingFang SC;
    font-weight: 600;
    line-height: 1.4rem;
 }
</style>