<template>
  <div class="login_dialog name_dialog" style="background-color: #fff">
     <div class="head_title">
       <div class="go_back_right">
          <img @click="goBackHome" src="../../../assets/icon_return_black.png" alt="">
         
        </div>
      学历认证
    </div>
  <div class="link_content" >
      <div class="base_search">
        <div class="main_title">
          <span>学历</span>
        </div>
        <van-cell 
        class="cell_other"  
       
        title="学历" 
        value-class="valur_class" 
        :value="value" 
        @click="show = true "
        title-class="cell_class" 
        is-link />
      <van-action-sheet 
              v-model="show" 
              :actions="vipActionSheet.educations" 
              @select="onSelect"
              close-on-click-action 
            />
       </div>
      
    </div>
      <div class="link_content" >
      <div class="base_search">
        <div class="main_title">
          <span>毕业院校</span>
        </div>
        <van-field
          v-model="checkForm.real_school"
          rows="1"
          autosize
          class="field_padding"
          type="textarea"
          :rules="[{ required: true, message: '请填写毕业院校' }]"
          placeholder="请输入毕业院校"
        />
       </div>
      
    </div>
     <div class="link_content" >

     <div class="base_search">
        <div class="main_title">
          <span>请上传 《毕业证复印件》或《教育部学历证书电子注册备案表》</span>
        </div>
       
          <van-uploader 
            max-count="1"  
            style="margin-top: 1.3rem"
            :max-size="3 * 1024 * 1024"
            :before-read="beforeRead"
            v-model="fileList" 
            :after-read="afterReadHead"
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
    addRealEduVerify
  } from '../../../service/getData'
import { getSession, setSession, setIdxCity } from '../../../utils/auth' // get token from cookie

export default {
  data() {
    return {
      checkForm: {
        operate: 'addRealEduVerify'
      },
      value: '',
      show: false,
      session: {},

      vipActionSheet: vipActionSheet,
      fileList: [],
    }
  },
  created() {
    this.session = decodeURIComponent(getSession())

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
      var data = new FormData()
      data.append('edu_url', val.file)
      console.log('val-head', val);
      var code = encodeURIComponent(`img/edu_url/${this.session.userid}/temp`)
      var url_mes = {file: code, file_id: 'edu_url', uid: 'web',isUniq: 1}
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
      console.log('education',res);

          if (res.data.url) {
            this.fileList = []
            this.checkForm.edu_url = JSON.parse(JSON.stringify(res.data.url))
             var img = {} 
            img.url = decodeURIComponent(res.data.url)
            this.fileList.push(img)
            console.log(this.fileList);
          }
      })
    },
    addRealEduVerifySet() {
      addRealEduVerify(this.checkForm).then(res => {
        console.log('education', res);
        if (res.Code == 0) {
           this.$toast('提交学历认证信息成功，请等待审核');
          this.$router.push({ name: 'Check'})
          
        } else {
            this.$toast(res.Msg);

        }
      })
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
   
   .van-field__body {
     background-color: #F8F8F8  !important;

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