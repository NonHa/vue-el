<template>
  <div style="background: #FFF0F0; padding-bottom: 1rem">
     <img class="vip_img" src="../../assets/pic_love_detail_pages.png" alt="">
    <div style="background: #FFF0F0">
      <van-radio-group v-model="radio">
        <van-cell-group class="icon_cell">
          <van-cell 
           :class="radio == index ?  'cell_heigth_select' : 'cell_heigth'" 
            v-for="(item, index) in optionList" 
            :title="item.name" 
            clickable 
            @click="radio = index" 
            :key="index">
            <template #right-icon>
              <div class="price">{{ item.price }}</div>
              <van-radio :name="index" />
            </template>
          </van-cell>
        </van-cell-group>
      </van-radio-group>

      <div class="link_content">
          <div class="base_search">
            <div class="main_title">
              <span>权益说明</span>
            </div>
          </div>

           <div v-if="radio == 0" class="common">
          「VIP一对一（5次）+线下实体咖啡店消费8折折扣，次月享受联合创始人集体分红一瓢婚恋书馆当月合计会员费纯收益的20%；资源整合」<br/>
            单身联合创始人（300人）要求：<br/>
          「优质单身男女会员人群：企业主、创始人
          企事业单位人员、其它有正式工作单身者」<br/>
          单身、专科及以上、男：24-48岁；女：22-45岁、需审核学历、公司、实名，
          有意向交友者征得会员同意后需全部实名、实况公布信息；<br/>
          ( 备注：男性年收入30万以上，女性年收入10万以上。 )<br/>
          会员费「2万元」
          
          </div>
           <div v-else-if="radio == 1" class="common">
          要求：单身、专科及以上；<br/>
          男：24-48岁；女：22-45岁;<br/>
          需审核学历、岗位、公司，全部实名展示；<br/>
         
          
          「线下8折消费+建档
          线上IP+VIP一对一婚猎10次
          线上不限次数邀约
          个人提升、心理咨询 、个性测评」<br/>
    
          会员费：2万元<br/>
          权益内容终止<br/>
          服务期：3年
          
          </div>
          <div v-else-if="radio == 2" class="common">
         要求：单身、专科及以上<br/>
          男：24-48岁；女：22-45岁;<br/>
          需审核学历、岗位、公司，全部实名展示；<br/>
          
          
          「线下8.5折消费+建档+线上IP
          VIP一对一婚猎5次
          线上不限次数邀约
          个人提升、心理咨询 、个性测评」<br/>
          会员费：1万元<br/>
          权益内容终止<br/>
          服务期：3年<br/>
          
          </div>
          <div v-else-if="radio == 3" class="common">
          要求：单身、专科及以上；<br/>
          男：24-48岁；女：22-45岁;<br/>
          需审核学历、岗位、公司，全部实名展示；<br/>
         
          「线下9折消费+建档+线上IP+VIP一对一；
          婚猎3次+线上不限次数邀约
          个人提升、心理咨询 、个性测评」<br/>

          
          会员费：3800元<br/>
          权益内容终止<br/>
          服务期：2年
          
          </div>
          <div v-else-if="radio == 4" class="common">
          要求：单身、专科及以上；<br/>
          男：24-48岁；女：22-45岁;<br/>
          需审核学历、岗实名展示；<br/>
          建档+线上不限次数邀约<br/>
          个人提升、心理咨询 、个性测评<br/>
          会员费：399元<br/>
          权益内容终止<br/>
          服务期：1年<br/>
          
          </div>
      </div>
      <div class="link_content_btn">
        
       <van-button @click="becomeVip"  type="primary" >立即开通</van-button>
        <van-button class="link_phone" type="primary" >联系顾问</van-button>
    </div>
     
    </div> 

  </div>
</template>

<script>
import Radio from '../components/Radio'
import { 
 addRealVip
  } from '../../service/getData'
export default {
  components: { Radio },
  props: {},

  watch: {
   
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
      radio: 0,
       optionList: [
        
          { name: '联合创始人', price: '¥20000' }, 
          { name: '钻石会员', price: '¥20000' }, 
          { name: '精英会员', price: '¥10000' }, 
          { name: '普通会员', price: '¥3800' }, 
          { name: '基础会员', price: '¥399' }, 
          
      ],
    }
  },
  created() {
      this.actionsOption = this.actions
    
  },
  methods: {
    becomeVip() {
      
      if (this.radio == null) {
        this.$toast(`请选择会员类型!`);
        return
      }
      addRealVip({operate: 'addRealVip',  real_vip: (this.radio + 1)}).then(res => {
        if (res.Code == 0) {
           this.$toast(`成功成为${this.optionList[this.radio].name}`);
        } else {
           this.$toast(res.Msg);
        }
      })
    },
    goBackHome() {
      this.$router.push({ name: 'Mine' })
    },
     getItem(val) {
       if (val == 0) {
         this.actionsOption = this.actions
       } else {
         this.actionsOption = this.actions2

       }
    },
    afterRead() {

    },
    goVisite() {

    }
  }
}
</script>

<style lang="scss" scoped>
    @import '../../style/mixin';

.vip_img {
  width: 100%;
}
.van-cell-group {
    width: 19.8rem;
    margin-left: 0.7rem;
    background: #FFF0F0
}
.van-cell {
  position: relative;
  overflow: hidden;
  margin-top: 0.6rem;
  background: #FFF9F2;
  border-radius: 0.3rem;
  border: 2px solid #CEA476;
  @include wh(100%, 3.5rem);

}
.van-cell__title {
 
    @include sc(0.9rem, #262B40);
font-family: PingFangSC-Semibold, PingFang SC;
font-weight: 600;
line-height: 2.1rem;
}
.van-radio__icon {
  height: 2.5rem;
}
.price {
  position: absolute;
  right: 3rem;
  top: 0.9rem;
  @include sc(0.8rem, #855C30);
  font-family: PingFangSC-Semibold, PingFang SC;
  font-weight: 600;
}

.common, .time_area {
  @include sc(0.8rem, #262B40);
  font-weight: 400;
  line-height: 30px;
}
.base_search {
  border: 0;
}
.time_area {
  margin-top: 0.9rem;
}
.van-button--primary {
    background-color: #404868;
    border: 1px solid #404868;
    
    border-radius: 0.1rem;
  }
  .link_content_btn {
  padding: 0 0.9rem;
  width: 100%;
  margin-top: 2rem;
}
.link_content {
  border: 0;
  margin-top: 2rem;
  background-color: #FFF0F0;
}

.link_phone {
  margin-top: 1rem;
  
  background-color: #FFF0F0;
}
.van-radio  {
  height: 2rem !important;
}
.link_phone .van-button__text {
  color: #404868;
}
.cell_heigth_select {
  position: relative;
  overflow: hidden;
  margin-top: 0.6rem;
  background: #FFF9F2;
  border-radius: 0.3rem;
  border: 2px solid #CEA476;
  @include wh(100%, 3.5rem);

}
.cell_heigth {
  position: relative;
  overflow: hidden;
  margin-top: 0.6rem;
  background: #FFFFFF;
  border-radius: 0.3rem;
  border: 2px solid #D2D2D2;
  @include wh(100%, 3.5rem);

}
</style>