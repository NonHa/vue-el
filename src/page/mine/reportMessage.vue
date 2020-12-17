<template>
  <div >
    <head-content title="不良信息举报"></head-content>
    <div class="setting">
       <van-cell class="setting_report" title="举报类型" value="请选择" is-link />
        <van-field
          class="report_field"
          v-model="value"
          label="您的名字"
          placeholder="请填写真实姓名"
          input-align="right"
        />
        <van-field
          v-model="value"
          label="您的手机号"
          placeholder="请填写真实手机号"
          input-align="right"
        />
    </div>

    <div class="link_content" style="border-bottom: 0.5rem solid #F7F7F8;margin-top:1rem">
        <div class="base_search">
          <div class="main_title">
            <span>举报内容</span>
          </div>
          <van-field
            v-model="chooseList.desc"
            rows="7"
            autosize
            class="field_padding"
            type="textarea"
            placeholder="请填写举报内容…"
          />
           <div class="phone_report">
            <div>
              违法不良信息举报电话：<span>4000-888-888</span>
            </div>
            <div>
              违法不良信息举报邮箱：<span>vip@yipiaohunlian.com</span>
            </div>
        </div>
        </div>
       
    </div>
    <div style="padding: 0 0.8rem">
      <van-button class="set_btn_report"  type="primary" >提交</van-button>
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
       openType: '已公开',
       chooseList: {},
       value: ''
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
    .setting .van-cell {
      height: 4rem;
      background-color: #fff;
     
      font-family: PingFangSC-Regular, PingFang SC;
      font-weight: 400;
      color: #262B40;
       border-bottom: 1px solid #ccc !important;
    }
    .setting .van-switch--on {
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
    .phone_report {
    
      font-size: 0.7rem;
      font-family: PingFangSC-Regular, PingFang SC;
      font-weight: 400;
      color: #8C8C8C;
      
    }
    .phone_report div {
      margin-top: 0.5rem;
    }
    .phone_report span {
      color: #FF807B;
      text-decoration: underline;
    }
    .set_btn_report {
      margin: 3rem 0 1rem 0;
    }
</style>
