<template >
  <div>
    <div class="head_string">
     
      <div class="go_string_main">
         <div class="to_scroll"  @click="$router.go(-1)"></div>
        牵线服务
      </div>
      <img src="../../assets/bg_ invitation_pink.png" alt="">
      <div class="head_pay_string">
        <div class="pay_service">
          - 请选择需要购买的服务 -
        </div>
      <div class="select_string">
        <van-radio-group v-model="radio" class="icon_cell">

          <div @click="selectString(1)" :class="radio == 1 ? 'radio_string2' : 'radio_string'">
            <div class="radio_left">
              <img src="../../assets/icon_diamonds_one.png" alt="">
              <div class="success_content">
                <h3>
                  包1次成功
                </h3>
                <span>
                  有效期90天
                </span>
              </div>
            </div>
            <div class="radio_right">
              <div class="price">
                <h3>
                  199元
                </h3>
                <span>
                  299元
                </span>
              </div>
              <van-radio name="1" />

            </div>
          </div>

          <div  @click="selectString(2)" :class="radio == 2 ? 'radio_string2' : 'radio_string'">
            <div class="radio_left">
              <img src="../../assets/icon_diamonds_two.png" alt="">
              <div class="success_content">
                <h3>
                  包3次成功
                </h3>
                <span>
                  有效期180天
                </span>
              </div>
            </div>
            <div class="radio_right">
              <div class="price">
                <h3>
                  499元
                </h3>
                <span>
                  699元
                </span>
              </div>
              <van-radio name="2" />

            </div>
          </div>

          <div  @click="selectString(3)" :class="radio == 3 ? 'radio_string2' : 'radio_string'">
            <div class="radio_left">
              <img src="../../assets/icon_diamonds_three.png" alt="">
              <div class="success_content">
                <h3>
                  包9次成功
                </h3>
                <span>
                  有效期360天
                </span>
              </div>
            </div>
            <div class="radio_right">
              <div class="price">
                <h3>
                  1199元
                </h3>
                <span>
                  1699元
                </span>
              </div>
              <van-radio name="3" />

            </div>
          </div>
        </van-radio-group>
      </div>
      </div>
    </div>
    <div class="string_tail">
      <div class="head_tail">
        <div class="left_ball"></div>
        <span >牵线服务说明</span>
        <div class="right_ball"></div>
      </div>
      <div class="mian_content">
        看中心仪的TA，点击TA个人详情最下方的“牵线”按钮可购买服务套餐。
      </div>
      <div class="string_message">
        <div class="message_item">
          <span class="message_tip_string">
            学历
          </span>
          <span class="message_value">
            本科
          </span>
        </div>
        <div class="message_item">
          <span class="message_tip_string">
            毕业院校
          </span>
          <span class="message_value">
            湖南大学
          </span>
        </div>
        <div class="message_item">
          <span class="message_tip_string">
            身高
          </span>
          <span class="message_value">
            160cm
          </span>
        </div>
        <div class="message_item">
          <span class="message_tip_string">
            体重
          </span>
          <span class="message_value">
            45kg
          </span>
        </div>
      </div>
       <div class="mian_content" style="height: auto">
       1小时内红娘老师为您牵线搭桥，联系对方为您们撮合，给到双方深入交流和了解的机会。若对方同意，则牵线成功；若对方不同意，则牵线失败，不计入成功次数，服务继续使用。
        <img src="../../assets/pic_matchmaker_two.png" alt="">
      </div>
    </div>
     <div class="string_tail string_rule" style="margin-top: 1rem">
      <div class="head_tail">
        <div class="left_ball"></div>
        <span >规则条款说明</span>
        <div class="right_ball"></div>
      </div>
     <div style="margin-top: 1rem">
        <p>
        牵线服务购买成狗后，可在“我的”页面进入“我的订单”查看消费记录和凭证，不支持退款。
      </p>
      <p style="margin-top: 0.6rem">
        1.从购买后的当天开始计入有效期，超过有效期仍有剩余次数的情形，视为用户已享有服务并成功完成消费，平台停止提供服务。
      </p>
      <p style="margin-top: 0.6rem">
        2.牵线成功的次数使用完或者超过有效期后，如需再次牵线服务，需重新购买。
      </p>
     </div>
    </div>
     <div class="setting_btn" >
      <van-button style="margin-bottom:1rem"  type="primary" @click="$router.push({name: 'TranslatorPay'})">立即购买</van-button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      radio: '1',
      
    }
  },
  methods: {
    selectString(index) {
      this.radio = `${index}`
    }
  }
}
</script>

<style lang="scss" scoped>
  @import '../../style/mixin';
  .head_string {
    position: relative;
    height: 23rem;
  }
  .go_string_main {
    position: absolute;
    width: 100%;
    text-align: center;
    font-size: 0.8rem;
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    color: #FFFFFF;
    line-height: 2rem;
    z-index: 2;
  }
  .head_string img{
   
    height: 15rem;
    width: 100%;
    
  }
  .head_pay_string {
    position: absolute;
    top: 25%;
    left: 50%;
    transform: translateX(-50%);
    background: #FFFFFF;
    box-shadow: 0px 0.1rem 0.6rem 0px rgba(0, 0, 0, 0.06);
    border-radius: 0.3rem;
    padding-bottom: 0.8rem;
  }
  .pay_service {
    position: absolute;
    top: -1.5rem;
    width: 100%;
    text-align: center;
    font-size: 0.6rem;
    font-family: PingFangSC-Semibold, PingFang SC;
    font-weight: 600;
    color: #fff;
    overflow: hidden;
    // line-height: 1rem;
  }
  .select_string {
      @include wh(19rem,11rem);
      // background-color: pink;
      margin: 0 auto;
  }
  .radio_string,.radio_string2 {
   
    @include wh(17rem,4rem);
    margin: 0 auto;
    margin-top: 0.8rem;
    box-shadow: 0px 0.2 0.8rem 0px rgba(0, 0, 0, 0.06);
    border-radius: 0.3rem;
    
    
    // background-color: pink;
  }
  .radio_string {
    border: 0.1rem solid #D2D2D2;
  }
  .radio_string2 {

    border: 0.1rem solid #FFB6B2;
  }
  .radio_left {
    float: left;
    display: flex;
    font-family: PingFangSC-Semibold, PingFang SC;
  }
  .radio_right {
    float: right;
    display: flex;

  }
  .radio_left img {
    @include wh(1.4rem,1.4rem);
    margin: 1.3rem 1rem 0 1rem;
  }
  .success_content, .price {
    margin-top: 0.5rem;
  }
  .radio_left h3 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #262B40;
    line-height: 1.3rem;
  }
  .radio_left span, .radio_right span {
    @include sc(0.6rem, #8C8C8C);
    font-weight: 400;
  
  }
  .radio_right h3 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #FF807B;
    line-height: 1.3rem;
  }
  .radio_right span {
    text-decoration: line-through;
  
  }
  .van-radio {
    margin: 0 1rem;
  }
   .to_scroll {
    position: absolute;
    left: 1.4rem;
    top: 50%;
    transform: translateY(-50%);
  }
  .to_scroll::after {
    content: '';
    display: inline-block;
    height: 0.5rem;
    width: 0.5rem;
    border-top: 2px solid#FFF;
    border-left: 2px solid#FFF;
    transform: rotate(45deg) scaleY(-1);
  }
  .string_tail {
    
    position: relative;
    background-color: #fff;
    padding-top: 1rem;
    width: 19rem;
    margin: 0 auto;
   
      // margin: 0 auto;
  }
  .left_ball,.right_ball {
    position: absolute;
    width:  1.8rem;
    height: 0.2rem;
    top: 1.3rem;
  }
  .head_tail {
    @include sc(0.6rem, #262B40);
    font-family: PingFangSC-Semibold, PingFang SC;
    font-weight: 600;
    text-align: center;
  }
  .left_ball {
    left: 25%;
    background: linear-gradient(270deg, #FF807B 0%, rgba(255, 255, 255, 0) 100%);
  }
  .right_ball {
    right: 25%;
    
    background: linear-gradient(270deg, rgba(255, 255, 255, 0) 0%, #FF807B 100%);
  }
  .mian_content {
    width: 17rem;
    height: 4rem;
    background: #FAFAFA;
    border-radius: 0.4rem;
    margin: 0 auto;
    @include sc(0.6rem, #505050);
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    line-height: 1.3rem;
    text-align: center;
    padding: 0.8rem;
    margin-top: 1rem;
  }
  .string_message {
    width: 17rem;
    margin: 0 auto;
    margin-top: 1rem;
    background-color: #fff;
    padding: 0.8rem;
    
    box-shadow: 0px 0.2rem 0.7rem 0px rgba(0, 0, 0, 0.06);
    border-radius: 0.4rem;
  }
  .message_item span{
    @include sc(0.6rem, #505050);

  }
  .message_item {
    margin-bottom: 0.5rem;
  }
  .message_value {
    display: inline-block;
    margin-left: 2rem;
    width: 3rem;
    text-align: left;
  }
  .message_tip_string {
    display: inline-block;
    
    width: 3rem;
  }
  .mian_content img {
    display: inline-block;
    @include wh(15rem, 12rem);
    margin-top: 0.8rem;
  }
  .string_rule {
    @include sc(0.6rem, #787878);
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    line-height: 1.3rem;
    padding: 0.8rem 0.8rem ;
  }
  .setting_btn {
      padding: 0 0.8rem;
      width: 100%;
      margin: 1rem 0;
    }
</style>