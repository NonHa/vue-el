<template>

  <div class="login_dialog name_dialog"  style="background-color: #fff">
    <div class="head_title">
      <div class="go_back_right">
          <img @click="goBackHome" src="../../../assets/icon_return_black.png" alt="">
         
        </div>
      实名认证
    </div>
  <div class="link_content" >
      <div class="base_search">
        <div class="main_title">
          <span>姓名</span>
        </div>
        <van-field
          v-model="checkForm.real_name"
          rows="1"
          autosize
          class="field_padding"
          type="textarea"
          :rules="[{ required: true, message: '请填写姓名' }]"
          placeholder="请输入姓名"
        />
       </div>
      
    </div>
    <div class="link_content" >

     <div class="base_search">
        <div class="main_title">
          <span>身份证号</span>
        </div>
        <van-field
          v-model="checkForm.id_num"
          rows="1"
          autosize
          class="field_padding"
          type="textarea"
          :rules="[{ required: true, message: '请填写身份证号' }]"
          placeholder="请输入身份证号"
        />
       </div>
      
    </div>
    <div class="link_content" >

     <div class="base_search">
        <div class="main_title">
          <span>身份证正面</span>
        </div>
       
          <van-uploader 
          max-count="1"  
          style="margin-top: 0.8rem"
          v-model="fileList" 
          :max-size="3 * 1024 * 1024"
          :after-read="afterReadHead"
          :before-read="beforeRead"
          preview-size="250px"
            >
              <van-button size="mini" type="primary">上 传 图 片</van-button>
          </van-uploader>
        
       </div>
      
    </div>
      <div class="link_content" >

     <div class="base_search">
        <div class="main_title">
          <span>身份证反面</span>
        </div>
       
          <van-uploader
          max-count="1"  
          style="margin-top: 0.8rem"
            v-model="fileList2" 
            :before-read="beforeRead"
             :max-size="3 * 1024 * 1024"
            :after-read="afterReadHead2"
            preview-size="250px"
            >
              <van-button size="mini" type="primary">上 传 图 片</van-button>
          </van-uploader>
        
       </div>
      
    </div>
    
         <van-button class="btn_color" type="primary" @click="addRealEduVerifySet">提 交</van-button>
    
  </div>
</template>

<script>
import { 
  actionSheet, 
  vipActionSheet, 
  areaList 
  } from '../../components/actioneSheet'
  import {  
    addRealNameVerify
  } from '../../../service/getData'
import { getSession, setSession, setIdxCity } from '../../../utils/auth' // get token from cookie

export default {
  data() {
    return {
      checkForm: {
        operate: 'addRealNameVerify'
      },
      value: '',
      show: false,
      vipActionSheet: vipActionSheet,
      session: {},
      
       fileList: [],
       fileList2: []
    }
  },
  created() {
    this.session = JSON.parse(getSession())
  },
  methods: {
    //校验图片格式
      beforeRead(file){
        let fileType='';
        if(file instanceof Array && file.length){
          for (let i = 0; i < file.length; i++) {
              fileType=file[i].type.substr(0,file[i].type.indexOf('/'));
              if (fileType !== 'image') {
                this.$toast('格式错误');
                return false;
              }
          }
        }else{
          fileType=file.type.substr(0,file.type.indexOf('/'));
          if (fileType!== 'image') {
            this.$toast('格式错误');
            return false;
          }
        }
        return true;
      },
    onSelect(e) {
      this.value = e.name
      this.checkForm.real_edu = e.code
      console.log(e);
    },
      afterReadHead(val) {
      
      console.log('this.session',this.session);
      var data = new FormData()
      data.append('id_card_front', val.file)
     
      var code = encodeURIComponent(`img/id_card_front/${this.session.openid}/temp`)
      var url_mes = {file: code, file_id: 'id_card_front', uid: 'web',isUniq: 1}
      var dataStr = ''
      Object.keys(url_mes).forEach(key => {
            dataStr += key + '=' + url_mes[key] + '&';
        })
      dataStr = dataStr.substr(0, dataStr.lastIndexOf('&'));
      var api = 'upload.php?' + dataStr
      this.$axios({
          method:'post',
          url: api,
          data
      }).then((res) =>{          //这里使用了ES6的语法
          this.fileList = []
          if (res.data.url) {
            
            this.checkForm.id_card_front_url = JSON.parse(JSON.stringify(res.data.url))
             var img = {} 
            img.url = decodeURIComponent(res.data.url)
            this.fileList.push(img)
            console.log(this.fileList);

          } else {
            this.fileList = []
          }
      })
    },
     afterReadHead2(val) {
       
      var data = new FormData()
      data.append('id_card_back', val.file)
     
      var code = encodeURIComponent(`img/id_card_back/${this.session.userid}/temp`)
      var url_mes = {file: code, file_id: 'id_card_back', uid: 'web',isUniq: 1}
      var dataStr = ''
      Object.keys(url_mes).forEach(key => {
            dataStr += key + '=' + url_mes[key] + '&';
        })
      dataStr = dataStr.substr(0, dataStr.lastIndexOf('&'));
      var api = 'upload.php?' + dataStr
      this.$axios({
          method:'post',
          url: api,
          data
      }).then((res) =>{          //这里使用了ES6的语法
      console.log('nameres',res);
      this.fileList2 = []
          if (res.data.url) {
            this.fileList2 = []
            this.checkForm.id_card_back_url = JSON.parse(JSON.stringify(res.data.url))
            var img = {} 
            img.url = decodeURIComponent(res.data.url)
            this.fileList2.push(img)
            console.log(this.fileList);

          }
      })
    },
    addRealEduVerifySet() {
      if (this.checkForm.id_card_back_url && this.checkForm.id_card_front_url) {
         addRealNameVerify(this.checkForm).then(res => {
          console.log('name', res);
          if (res.Code == 0) {
            this.$toast('提交实名认证信息成功，请等待审核');
            this.$router.push({ name: 'Check'})
            
          } else {
            this.$toast(res.Msg);

          }
        })
      } else {
        this.$toast('请上传手持身份证照片再提交！');
      }
     
    },
    goBackHome() {
      this.$router.go(-1)
    },
  }
}
</script>

<style lang="scss" scoped>
  .link_content {
     background-color: #fff;
     padding: 0 1rem;
     margin-top: 2rem;
   }
   .link_content, .base_search {
     border: 0;
    //  padding: 1rem;
   }
   .van-cell  {
     padding: 5px ;
     background-color: #F8F8F8;
   }
 
   .van-field {
     margin-top: 0.8rem;
   }
   .preview-cover {
    position: absolute;
    bottom: 0;
    box-sizing: border-box;
    width: 100%;
    padding: 4px;
    color: #fff;
    font-size: 12px;
    text-align: center;
    background: rgba(0, 0, 0, 0.3);
  }
  .van-button  {
    margin-top: 1rem;
  }
  .van-uploader__input-wrapper {
    top: 1rem;
  }
  .head_title {
    width: 100%;
    height: 2.3rem;
    line-height:  2.3rem;
    text-align: center;
    background: #FFFFFF;
    font-size: 0.9rem;
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    color: #262B40;
   border: 1px solid #efefef;
  }
   .go_back_right {
    width: 1rem;
    height: 1rem;
    top: 0.4rem;
    left: 1.5rem;
  }
  .go_back_right img{
    height: 100%;
    width: 100%;
  }
</style>