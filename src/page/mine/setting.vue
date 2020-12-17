<template>
  <div style="setting">
    <head-content title="设置"></head-content>
    <van-cell center title="资料是否公开" :value="openType">
      <template #right-icon>
        <van-switch v-model="checked" size="24" />
      </template>
    </van-cell>
     <van-cell 
     class="setting_report" 
     title="不良信息举报" 
     is-link 
     to="/report/message"
     />
     <div class="setting_btn" >
      <van-button class="set_btn_report"  type="primary" >注销账户</van-button>
    </div>
  </div>
</template>

<script>

import {  
  getMessageCount, 
  getBeInvitedList,
  getInviteList, 
} from '../../service/getData'
import headContent from '../components/headContent'
import moment from 'moment'
export default {
	components: { headContent },
    data() {
      return {
       checked: true,
       openType: '已公开'
      }
    },
		watch: {
      checked(val) {
        this.openType = val ? '已公开' : '未公开'
      }
    },
    created() {
      
    },
    methods: {
     goCustomerPage() {

     }
    },
   

}
</script>

<style lang="scss" scoped>
    @import '../../style/mixin';
    .van-cell {
      height: 4rem;
      background-color: #fff;
     
      font-family: PingFangSC-Regular, PingFang SC;
      font-weight: 400;
      color: #262B40;
       border-bottom: 1px solid #ccc !important;
    }
    .van-switch--on {
      background-color:#FF807B;
    }
    .setting_report, .van-cell__right-icon {
      line-height: 3rem;
    }
    .van-cell__value {
      margin-right: 5px;
      
    }
    .van-cell__value span {
      color: #8C8C8C;
    }
    .setting_btn {
      padding: 0 0.8rem;
      width: 100%;
      position: absolute;
      bottom: 1rem;
     
    }
</style>
