<template>
  <div style="setting">
    <head-content title="确认订单"></head-content>
    <div class="pay_price">
      <div class="left_pay_mes">
        缘分牵线（包1次成功）
      </div>
      <div class=" right_pay_mes">
        <span style=" color: #FF807B;font-weight: 600;font-size: 1.1rem;">
          199
        </span>
        <span>
          元/次
        </span>
      </div>
    </div>
    <div class="pay_price pay_mes">
      <div class="head_sure_pay">
        <div>
          原价：<span style=" text-decoration: line-through;">299元</span>
        </div>
        <div>
          实际费用：199元
        </div>
      </div>
      <div class="pay_main_mes">
        <div>
         订单编号：QX20201214092956127001
        </div>
        <div>
         牵线对象：严女士
        </div>
        <div>
         下单时间：2020-12-14 09:29:56
        </div>
        <div>
         相关规则：本产品服务支付的费用，只限于本平台使用，不可抵用及兑换任何其他费用。
        </div>
      </div>
    </div>
    <div class="bottom_pay">
      <div class="warning_mes">
        等待付款：剩余 23:59:58 自动取消订单
      </div>
      <div class="sure_string_pay">
        <div class="total_pay" >
          合计：<span style="font-size: 1.1rem;font-weight: 600">¥199</span>
        </div>
        <div class="btn_pay">
          立即付款
        </div>
      </div>
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
    .pay_price {
      width: 19rem;
      height: 4rem;
      margin: 0 auto;
      margin-top: 0.8rem;
      font-size: 0.8rem;
      font-family: PingFangSC-Regular, PingFang SC;
      background-color: #fff;
      padding: 0.8rem;
      line-height: 2rem;
    }
    .left_pay_mes {
      float: left;
     
      color: #262B40;
      font-weight: 600;
    }
    .right_pay_mes {
      float: right;
      font-weight: 400;
      color: #262B40;
     
    }
    .pay_mes {
      height: auto;
      
    }
    .head_sure_pay {
      border-bottom: 1px solid #ccc;
    }
    .pay_main_mes {
      
      font-size: 0.8rem;
      font-family: PingFangSC-Regular, PingFang SC;
      font-weight: 400;
      color: #787878;
      line-height: 2rem;
      margin-top: 0.8rem;
    }
    .bottom_pay {
      position: absolute;
      bottom: 0;
      width: 100%;
    }
    .warning_mes {  
      background: #FFF8CC;
      padding: 1rem;
      font-size: 0.8rem;
      font-family: PingFangSC-Regular, PingFang SC;
      font-weight: 400;
      color: #505050;
    }
    .sure_string_pay {
      height: 3rem;
      background-color: #fff;
      display: flex;
      line-height: 3rem;
    }
    .total_pay {
      flex: 1;
      margin-left: 2rem;
    }
    .btn_pay {
      width: 8rem;
      text-align: center;
     
      background: #FF807B;
      color: #ffff;
      height: 100%;
    }
</style>
