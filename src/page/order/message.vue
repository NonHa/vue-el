<template>
  <div style="setting">
    <head-content title="订单详情"></head-content>
    <div class="order_mesage_item" >
      <div class="message_item" style="margin:0">
        <span class="tip_order">
          购买业务
        </span>
        <span class="order_mes_item">
          缘分牵线(包1次成功)
        </span>
      </div>
      <div class="message_item">
        <span class="tip_order">
          金额
        </span>
        <span class="order_mes_item">
          ¥199
        </span>
      </div>
      <div class="message_item">
        <span class="tip_order">
          优惠金额
        </span>
        <span class="order_mes_item">
          0
        </span>
      </div>
      <div class="message_item">
        <span class="tip_order">
          支付金额
        </span>
        <span class="order_mes_item">
          ¥199
        </span>
      </div>
    </div>

     <div class="order_mesage_item" >
      <div class="message_item" style="margin:0">
        <span class="tip_order">
          下单时间
        </span>
        <span class="order_mes_item">
          2020-12-14 09:29:56
        </span>
      </div>
      <div class="message_item">
        <span class="tip_order">
          订单编号
        </span>
        <span class="order_mes_item">
          QX20201214092956127001
        </span>
      </div>
      <div class="message_item">
        <span class="tip_order">
          牵线对象
        </span>
        <span class="order_mes_item">
         严女士
        </span>
      </div>
      <div class="message_item">
        <span class="tip_order">
          支付方式
        </span>
        <span class="order_mes_item">
          微信
        </span>
      </div>
    </div>

     <div class="order_mesage_item" >
      <div class="message_item" style="margin:0">
        <span class="tip_order">
          状态
        </span>
        <span class="order_mes_item">
          待支付
        </span>
      </div>
      <div class="message_item">
        <span class="tip_order">
          剩余时间
        </span>
        <span class="order_mes_item">
          10 时 03 分 22 秒
        </span>
      </div>
     
    </div>
     <div class="setting_btn" >
      <van-button style="margin-bottom:1rem"  type="primary">立即支付</van-button>
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
    .order_mesage_item {
      width: 19rem;
      margin: 0 auto;
      padding: 0.8rem;
      background-color: #fff;
      margin-top: 1rem;
      box-shadow: 0px 0.1rem 0.6rem 0px rgba(0, 0, 0, 0.06);
      border-radius: 0.4rem;
    }
    .message_item {
      display: flex;
      justify-content: space-between;
      font-size: 0.8rem;
      font-family: PingFangSC-Regular, PingFang SC;
      font-weight: 400;
      margin-top: 1rem;
   
    }
    .tip_order {
      color: #262B40;
    }
    .order_mes_item {
      
      color: #646464;
    }
    .setting_btn {
      position: absolute;
      padding: 0 0.8rem;
      bottom:0;
      width: 100%;
      margin: 1rem 0;
    }
</style>
