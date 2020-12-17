<template>
  <div style="background-color: #fff;">
     <div class="img_show">
        <img class="img_bg" src="../../assets/bg_personal_center.png" alt="">
        <div class="go_back_right">
          <img @click="goBackHome" src="../../assets/icon_return_black.png" alt="">
         
        </div>
         <div class="show_more_left" @click="goCustomerPage">
         预览主页
        </div>
         <div class="title">
          编辑资料
        </div>
       
      <div  class="imageMes_title">
          <div class="content_show">
            <div class="avator_content">
              <img :src="baseList.user.photo" alt="">
            </div>
           
            <van-uploader class="tip" :after-read="afterReadHead">
              点击上传形象照
            </van-uploader>
        </div>
      </div>
        
     <div class="link_content" style="margin-top: 5rem">
      <div class="base_search">
        <div class="main_title">
          <span>我的相册</span>
        </div>
         <van-grid class="image_album" :border="false" :column-num="3">
           
               <van-uploader
               class="image_uploader"
               :max-size="500 * 1024"
                @delete="delImage"
                v-model="baseList.img_url" 
                :after-read="afterRead" />
             
        </van-grid>
      
      </div>
      
    </div>
    <div class="link_content" style="border-bottom: 0.5rem solid #F7F7F8;">
      <div class="base_search">
        <div class="main_title">
          <span>内心独白</span>
        </div>
        <van-field
          v-model="updataList.internal_monolog"
          rows="4"
          autosize
          class="field_padding"
          type="textarea"
          placeholder="请描述您的内心独白…"
        />
       </div>
      
    </div>
     
      <!-- <van-cell 
        class="produce" 
        title="修改密码" 
        value-class="produce_more" 
        @click="modifyPwdDialog = true"
        is-link
        >
      
    </van-cell> -->
  
    <div style="background: #fff">
      <van-tabs  style="margin-top: 0.9rem" v-model="active" @change="getItem" color= "#FF807B" line-width="1.1rem" line-height="0.25rem" swipe-threshold sticky :title-active-color="activeColor" :title-inactive-color="activeColor">
      <van-tab v-for="(item, index) in mineMes" :title="item" :key="index" >
      </van-tab>
    </van-tabs>
   </div>
     
    

   <div v-if="active == '0'">
     <div style="border-bottom: 0.5rem solid #F7F7F8;">
       <van-cell 
        class="cell_other"  
        v-for="(item, index) in actions" 
        :title="item.name" 
        value-class="valur_class" 
        :value="item.value" 
        @click="nikeSet(item, index)"
        title-class="cell_class" 
        :key="index" 
        is-link />
        <van-action-sheet 
            v-for="(item, index2) in actions" 
            v-model="item.show" 
            :actions="(index2 != 10 || index2 != 2 || index2 != 12) ? vipActionSheet[item.selectList] : []" 
            :key="index2" 
            @select="onSelect(item, $event)"
            close-on-click-action 
          >
          <div v-if="index2 == 10" class="content">
             <van-area 
              title="标题" 

              :area-list="areaList" 
              columns-num="2"
               @cancel="item.show = false"
              @confirm="sureAreaVip(item, $event)"/>
           </div>
          <van-datetime-picker
          v-if="index2 == 2"
            v-model="currentDate"
            type="date"
            title="选择年月日"
            :min-date="minDate"
            :max-date="maxDate"
            cancel-button-text=" "
           
            @confirm="sureBrithday(item, $event)"
          />
           <van-datetime-picker
            v-if="index2 == 12"
            v-model="currentDate"
            type="year-month"
           
            title="选择年月"
            :min-date="minDate"
            :max-date="maxDate"
            cancel-button-text=" "
           
            @confirm="marileDay(item, $event)"
          />
        </van-action-sheet>

       
     </div>
      <van-dialog v-model="dialogShow" title="请填写昵称" :showConfirmButton="false">
         
        </van-dialog>
      <!-- home -->
      <div class="link_content" >
        <div class="base_search">
          <div class="main_title">
            <span>家庭情况</span>
          </div>
          <van-field
          v-model="updataList.family_situation"
          rows="4"
          autosize
          class="field_padding"
          type="textarea"
          placeholder="请描述您的家庭情况…"
        />
        </div>
        
      </div>

       <div class="link_content" >
      <div class="base_search">
        <div class="main_title">
          <span>职业规划</span>
        </div>
        <van-field
          v-model="updataList.career_planning"
          rows="4"
          autosize
          class="field_padding"
          type="textarea"
          placeholder="请描述您对未来职业的规划…"
        />
      </div>
      
    </div>

     <div class="link_content" >
      <div class="base_search">
        <div class="main_title">
          <span>情感经历</span>
        </div>
        <van-field
          v-model="updataList.emotional_experience"
          rows="4"
          autosize
          class="field_padding"
          type="textarea"
           placeholder="请描述您的情感经历…"
        />
      </div>
      
    </div>
   <van-button class="btn_color" type="primary" @click="scrollToSoup">下一步</van-button>

   </div>
   <div v-if="active == '1'">
     <van-cell 
      class="cell_other"
      v-for="(item, index) in actions2" 
      :title="item.name" 
      value-class="valur_class"
      :value="item.value" 
      title-class="cell_class" 
       @click="nikeSetVip(item, index)"
      :key="index" 
      is-link />
       <van-action-sheet 
            v-for="(item, index2) in actions2" 
            v-model="item.show" 
            :actions="index2 != 4 || index2 != 5 || index2 != 14 ? vipActionSheet[item.selectList] : []" 
            :key="index2" 
            @select="onSelect(item, $event)"
            close-on-click-action 
          >
          <div v-if="index2 == 4" class="content">
             <van-area 
              title="标题" 

              :area-list="areaList" 
              columns-num="2"
               @cancel="item.show = false"
              @confirm="sureAreaVip2(item, $event)"/>
           </div>
          <div v-if="index2 == 5" class="content">
             <van-area 
              title="标题" 

              :area-list="areaList" 
              columns-num="2"
               @cancel="item.show = false"
              @confirm="sureAreaVip(item, $event)"/>
           </div>
           <van-datetime-picker
            v-if="index2 == 14"
            v-model="currentDate"
            type="year-month"
           
            title="选择年月"
            :min-date="minDate"
            :max-date="maxDate"
            cancel-button-text=" "
           
            @confirm="marileDay(item, $event)"
          />
      
        </van-action-sheet>
   </div>
   <van-button class="btn_color" type="primary" @click="saveBaseEditMes">保 存</van-button>

    </div>
     <van-dialog  
        
        class="login_dialog" 
        style="height:15rem"
        :title="`请填写${activeName2}`" 
        closeOnClickOverlay 
        closeOnPopstate 
        :showConfirmButton="false"
        v-model="nikeNameDialog"
        v-if="nikeNameDialog"
        >
      <name-form :activeName="activeName2" @sureLogin="sureLogin"></name-form>
    </van-dialog> 

    <van-dialog  
        
        class="login_dialog"
        style="height: 14rem" 
        :title="`${activeName}范围`" 
        closeOnClickOverlay 
        closeOnPopstate 
        :showConfirmButton="false"
        v-model="ageDialog"
        v-if="ageDialog"
        >
        <!-- <choose-age :activeName="activeName" @setAge="setAge"></choose-age> -->
        
    </van-dialog> 

    
  </div>
</template>

<script>
import { 
  actionSheet, 
  vipActionSheet, 
  areaList 
  } from '../components/actioneSheet'
import {  
  getBasicInfo,
  getSpouseCondition,
  addImg,
  updateMyInfo,
  updateImg, 
  delImg, 
  updateBasicInfo, 
  updateSpouseCondition,
  ModifyPassword
  } from '../../service/getData'
import nameForm from '../components/nikenameForm'
import pwdForm from '../components/forgetPwd'

import { getSession, setSession, setIdxCity } from '../../utils/auth' // get token from cookie

export default {
  components: { nameForm, pwdForm },
  props: {
    
  },
  watch: {
   
  },
 
  data() {
    return {
      state: '邀约待接受',
      activeName: '',
      activeName2: '',
      dialogShow: false,
      nikeNameDialog: false,
      modifyPwdDialog: false,
      collegeDialog: false,
      workeDialog: false,
      heightDialog: false,
      ageDialog: false,
      salaryDialog: false,
      active: '0',
      message: '',
      actionSheet: actionSheet,
      vipActionSheet: vipActionSheet,
      areaList: areaList,
      minDate: new Date(1900, 0, 1),
      maxDate: new Date(2025, 10, 1),
      currentDate: new Date(),
      activeColor: '#FF807B',
      mineMes: ['基本资料', '择偶标准',],
      userList: {
        user: {
          photo: ''
        }
      },
      area: [],
      area2: [],
      actionsOption: [],
      actions: [
          { name: '昵称', value: '不限',show: false, filed: 'nickname', code: '' },
          { name: '性别', value: '不限',show: false, selectList: 'sex',filed: 'sex' }, 
          { name: '出生日期', value: '不限',show: false,filed: 'birthday' }, 
          { name: '身高' , value: '不限',show: false,filed: 'height'},
          { name: '体重' , value: '不限',show: false,filed: 'weight'},
          { name: '星座' , value: '不限',show: false,  selectList: 'constellations',filed: 'nickname'},
          { name: '月收入', value: '不限',show: false ,filed: 'salary'},
          { name: '学历' , value: '不限',show: false,selectList: 'educations',filed: 'real_edu'},
          { name: '毕业学校' , value: '不限',show: false,filed: 'graduated_school'},
          { name: '工作单位' , value: '不限',show: false,filed: 'constellation'},
          { name: '工作生活地', value: '不限',show: false ,filed: 'job_addr'},
          { name: '职业', value: '不限',show: false,filed: 'job' },
          { name: '期望结婚时间', value: '不限',show: false ,filed: 'when_marry'},
          { name: '婚姻状态', value: '不限',show: false, selectList: 'marital',filed: 'marital_status' },
          { name: '有无子女', value: '不限',show: false,selectList: 'children',filed: 'child' },
          { name: '是否想要孩子', value: '不限',show: false, selectList: 'checkName',filed: 'wanna_child' },
          { name: '饮酒', value: '不限',show: false, selectList: 'drinks',filed: 'smoke'},
          { name: '吸烟', value: '不限',show: false, selectList: 'smokes',filed: 'drink'},
           { name: '房产情况', value: '不限',show: false, selectList: 'children',filed: 'house'},
          { name: '车辆情况', value: '不限',show: false, selectList: 'children',filed: 'car'},
          { name: '籍贯', value: '不限',show: false, filed: 'hometown'},
      ],
       actions2: [
          { name: '年龄', value: '不限',show: false,filed: 'min_age'  }, 
          { name: '身高', value: '不限',show: false,filed: 'min_height' },
          { name: '月收入', value: '不限',show: false,filed: 'min_salary' },
          { name: '学历' , value: '不限',show: false,filed: 'education',selectList: 'educations'},   
          { name: '工作生活地', value: '不限',show: false,filed: 'job_addr' },
          { name: '户籍（老家）', value: '不限',show: false,filed: 'min_age' },
          { name: '婚姻状况' , value: '不限',show: false,filed: 'marital_status',selectList: 'marital'},
          { name: '饮酒', value: '不限',show: false,filed: 'drink',selectList: 'drinks'  },
          { name: '吸烟', value: '不限',show: false,filed: 'smoke',selectList: 'smokes' },
          { name: '有无子女' , value: '不限',show: false,filed: 'child',selectList: 'children'},
          { name: '是否想要孩子' , value: '不限',show: false,filed: 'wanna_child',selectList: 'checkName'},
          { name: '体重', value: '不限',show: false,filed: 'min_weight' },
          { name: '星座' , value: '不限',show: false,filed: 'min_age', selectList: 'constellations'},
          { name: '职业' , value: '不限',show: false,filed: 'min_age'},
          { name: '期望结婚时间', value: '不限',show: false,filed: 'min_age' },
      ],
      baseList: {
       user: {
          photo: ''
        }
      },
      chooseList: {},
      updataList: {},
      session: {},
      updateForm: {},
      soupeList: {},
      }
    },
  created() {
      this.actionsOption = this.actions
      this.getBaseList()
      this.session = decodeURIComponent(getSession())
  },
  methods: {
     sureLogin(val) {
       if (this.activeName2 == '昵称') {
         this.actions[0].value = val
         this.actions[0].code = val
      } else if (this.activeName2 == '身高') {
        this.actions[3].value = val
        this.actions[3].cpde = val
      }else if (this.activeName2 == '体重') {
        this.actions[4].value = val
        this.actions[4].code = val
      }else if (this.activeName2 == '毕业院校') {
        this.actions[8].value = val
        this.actions[8].code = val
      }else if (this.activeName2 == '工作单位') {
        this.actions[9].value = val
        this.actions[9].code = val
      }else if (this.activeName2 == '职业') {
         if (this.active == 0) {
           this.actions[11].value = val
           this.actions[11].code = val
        } else {
           this.actions2[13].value = val
           this.actions2[13].code = val
        }
      }else if (this.activeName2 == '籍贯') {
        this.actions[20].value = val
        this.actions[20].code = val
      }
     
      this.nikeNameDialog = false
    },
    sureCollege(val) {
       this.actions[8].value = val
      this.collegeDialog = false
    },
    
    setAge(val) {
      if (this.activeName == '年龄') {
         this.actions2[0].value = val.min + '~' + val.max
         this.updateForm.min_age = val.min
         this.updateForm.max_age = val.max
      } else if (this.activeName == '身高') {
        this.actions2[1].value = val.min + '~' + val.max
         this.updateForm.min_height = val.min
         this.updateForm.max_height = val.max
      }else if (this.activeName == '月收入') {
        this.actions2[2].value = val.min + '~' + val.max
        this.updateForm.min_salary = val.min
         this.updateForm.max_salary = val.max
      }else if (this.activeName == '体重') {
        this.actions2[11].value = val.min + '~' + val.max
        this.updateForm.min_weight = val.min
         this.updateForm.max_weight = val.max
      }
     
      this.ageDialog = false
    },
    
    nikeSet(item, index) {
      if (index == 0) {
        this.activeName2 = "昵称"
        this.nikeNameDialog = true
      }else if (index == 3) {
        this.activeName2 = "身高"
        this.nikeNameDialog = true
      } else if (index == 4) {
        this.activeName2 = "体重"
        this.nikeNameDialog = true
      }  else if (index == 6) {
        this.activeName2 = "月收入"
        this.nikeNameDialog = true
      } else if (index == 8) {
        this.activeName2 = "毕业院校"
        this.nikeNameDialog = true
      }else if (index == 9) {
        this.activeName2 = "工作单位"
        this.nikeNameDialog = true
      }else if (index == 11) {
        this.activeName2 = "职业"
        this.nikeNameDialog = true
      } else if (index == 20) {
        this.activeName2 = "籍贯"
        this.nikeNameDialog = true
      }else {
        item.show = true
      }
      // this.nikeName = item.value == '不限' ? '' : item.value
      
    },
    nikeSetVip(item, index) {
     
      if (index == 0) {
        this.ageDialog = true
         this.activeName = '年龄'
      } else if (index == 1) {
        this.ageDialog = true
         this.activeName = '身高'

      }else if (index == 2) {
        this.ageDialog = true
         this.activeName = '月收入'

      }else if (index == 11) {
        this.ageDialog = true
         this.activeName = '体重'

      }else if (index == 13) {
         this.activeName2 = '职业'
        this.nikeNameDialog = true
        
      }else {
        item.show = true
      }
      // this.nikeName = item.value == '不限' ? '' : item.value
    },
    
    delImage(val) {
      console.log('imgVal', val);
      delImg({operate: 'delImg', id: val.id}).then(res => {
        if (res.Code == 0) {
          this.getBaseList()
        }
        this.$toast(res.Msg);
      })
    },
    afterRead(val) {
      var fd = new FormData()
      fd.append('albumfile', val.file)
      this.setUpload(fd)
    },
    afterReadHead(val) {
      var data = new FormData()
      data.append('headfile', val.file)
      console.log('val-head', val);
      var code = encodeURIComponent(`img/headicon/${this.session.userid}/`)
      var url_mes = {file: code, file_id: 'headfile', uid: 'web'}
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
          if (res.data.url) {
            this.baseList.user.photo = decodeURIComponent(res.data.url)
            updateImg({operate: 'updateImg', id: this.session.userid , photo: encodeURIComponent(res.data.url)}).then(res => {
              
              this.$toast(decodeURIComponent(res.Msg));
            })
            addImg({operate: 'addImg', lab: 'headicon' , url: encodeURIComponent(res.data.url)}).then(res => {
              if (res.Code == 0) {
                  this.getBaseList()
                }
              this.$toast(res.Msg);
            })
          }     
      })
    },
    scrollToSoup() {
      var el=document.getElementsByClassName('soup_top');
      this.$nextTick(function () {
          window.scrollTo({"behavior":"smooth","top":(Number(el[0].offsetTop) - 50)});
          this.$toast("请填写择偶标准");
          
      })
      
    },
    setUpload(data) {
     

      var code = encodeURIComponent(`img/album/${this.session.userid}/`)
      var url_mes = {file: code, file_id: 'albumfile', uid: 'web'}
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
        }).then((res) =>{         
            console.log('axios', res);
            if (res.data.url) {
              addImg({operate: 'addImg', lab: 'album', url: encodeURIComponent(res.data.url)}).then(res2 => {
                if (res2.Code == 0) {
                    this.getBaseList()
                  }
                this.$toast(res2.Msg);
              })
            }     
        })
    },
  
    saveBaseEditMes() {
       this.actions.forEach(item => {
           item.code ? item.code : item.code = -1
          this.updataList[item.filed] = item.code  ? item.code : -1
        })
         
          this.actions2.forEach(item => {
           item.code ? item.code : item.code = -1
            this.soupeList[item.filed] = item.code ? item.code  : -1
          })
        this.updataList.nation = 1
        this.updataList.province = this.area[0] ? this.area[0].code : -1
        this.updataList.city = this.area[1] ? this.area[1].code :  -1
        this.updataList.job_addr = this.area[2] ? this.area[2].code :  this.updataList.job_addr
        const {min_age, max_age, min_height, max_height, min_salary, max_salary, min_weight, max_weight} = this.updateForm
        this.soupeList.min_age =min_age ? min_age : -1
        this.soupeList.max_age =max_age ? max_age : -1
        this.soupeList.desc = -1
        this.soupeList.house = -1
        this.soupeList.car = -1
        this.soupeList.job_addr = this.area2[2] ? this.area2[2].code : this.soupeList.job_addr
        this.soupeList.min_height =min_height ? min_height : -1
        this.soupeList.max_height =max_height ? max_height : -1
        this.soupeList.min_salary =min_salary ? min_salary : -1
        this.soupeList.max_salary =max_salary ? max_salary : -1
        this.soupeList.max_weight =max_weight ? max_weight : -1
        this.soupeList.min_weight =min_weight ? min_weight : -1
        var list1 = JSON.stringify(this.updataList)
        var list2 = JSON.stringify(this.soupeList)
        console.log(list1);
        console.log(list2);
        var data = {
          "operate": "updateMyInfo",
          "basic_info": list1,
          "spouse_condition": list2
          }
        console.log('data',data);
         updateMyInfo(data).then(res => {
          console.log(list1);
          console.log(list2);
          if (res.Code == 0) {
            this.$toast(res.Msg);
          } else {
            this.$toast(res.Msg);
          }
        })
     
     
    },
    onSelect(item, val) {
    
      item.value = val.name
      item.code = val.code
    },
    goCustomerPage() {
      this.$router.push({name: 'CustomerPage', params: { item: userList.user}})
    },
    sureAreaVip(val, eve) {
      val.show = false
      val.value = ''
      this.area = eve

      eve.forEach(v => {
        val.value += v.name
      })
    },
    sureAreaVip2(val, eve) {
      val.show = false
      val.value = ''
      this.area2 = eve
      eve.forEach(v => {
        val.value += v.name
      })
    },
    sureBrithday(val, eve) {
      let year = eve.getFullYear()
      let month = eve.getMonth() + 1
      let day = eve.getDate()
     
      if (month >= 1 && month <= 9) { month = `0${month}` }
      if (day >= 1 && day <= 9) { day = `0${day}` }
     
      val.value = `${year}-${month}-${day}`
      val.show = false
      
    },
    marileDay(val, eve) {
      let year = eve.getFullYear()
      let month = eve.getMonth() + 1
      
      if (month >= 1 && month <= 9) { month = `0${month}` }
     
      val.value = `${year}-${month}`
      val.show = false
      
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
    
  }
}
</script>

<style lang="scss" scoped>
    @import '../../style/mixin';

  .img_show {
  height: 9rem;
  background-color: #fff;
}
.show_more_left {
  width: 4rem;
   @include sc(0.6rem, #262B40);
}
 .imageMes_title {
  //  display: flex;
    @include wh(19.6rem, 8rem);
  background-color: #fff;
  top: 4rem

 }
 .accset.van-tabs {
   width: 100%;
 }
 .van-tabs {
    width: 52%;
    background-color: #fff;
  }
 .imageMes_title img {
    @include wh(5.5rem, 5.5rem);
    
 }
 .title {
   position: absolute;
   width: 5rem;
   top: 1rem;
	left: 55%;
  transform: translateX(-50%);
   
   @include sc(0.7rem, #262B40);
  
 }
 
   .content_show {
    position: absolute;
    top: 1.2rem;
    display: flex;
    padding: 0.9rem;
    align-items: center;
   
    height: 5rem;
    font-family: PingFangSC-Regular, PingFang SC;
  }
  .avator_content {
   
    @include wh(4rem, 4rem);
    border-radius: 50%;
    margin-right: 0.5rem;
    flex: 1;
    background-color: #f2f3f5;
    overflow: hidden;
  }
  .image_uploader {
    margin-top: 10px;
    // @include wh(120px, 120px);

  }
  .image_uploader .van-uploader__wrapper {
    width: 100%;
    height: 100%;
  }
  .van-uploader__preview  {
    position: relative;
    margin: 0 2px 6px 9px;
    cursor: pointer;
    width: 29.33%;
  }
  .avator_content img {
    @include wh(100%, 100%);

  }
  .van-uploader__input-wrapper {
    @include sc(0.8rem, #505050);

  }
  .imageMes_title .tip {
    position: absolute;
    left: 12rem;
    top: 1.5rem;
    @include wh(6rem, 0.8rem);
    font-size: 0.6px;
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    @include sc(0.8rem, #505050);

  }
  //  .tip::after {
  //     content: '';
  //   @include wh(0.7rem, 0.7rem);
    
  //   position: absolute;
  //   top:0.6rem ;
  //   left: 5rem;
  //   background: url('../../assets/icon_more_small_black.png') no-repeat center;
  //   background-size: cover;
  //  }
  .title_name {
    flex: 1;
    margin-left: 0.5rem;
    line-height: 2rem;
  }
  .title_name .name{
    width: 108px;
    font-weight: 600;

    line-height: 50px;
    position: relative;
    @include sc(1.1rem, #262B40);


  }
  .title_name .name div {
    position: absolute;
    top: 0.3rem;
    left: 3rem;
    @include wh(3rem, 1.1rem);
    border-radius: 15px;
    line-height: 1.1rem;
    text-align: center;
    @include sc(0.6rem, #FF807B);

    border: 1px solid #FF807B;
  }
   .title_name .title{
    @include sc(0.6rem, #505050);
    font-weight: 400;
    line-height: 3.5rem;
  }
  .time {
   
    @include sc(0.6rem,#505050);
    font-weight: 400;
    margin-top: 1.4rem;
    margin-left: 5rem;

  }

   .valur_class {
      @include sc(0.8rem,#8C8C8C);
     
    font-family: PingFangSC-Regular, PingFang SC;
   }
   .field_padding {
     margin-top: 0.9rem;
     padding: 0rem;
      height: 7rem; 
      border-radius: 10px;
   }
   .link_content {
     background-color: #fff;
   }
   .link_content, .base_search {
     border: 0;
   }
   .tabs_padding {
     border-bottom: 0.5rem solid #F7F7F8;
   }
   .van-cell__title  {
     margin-left: 0.6rem;
   }
   .login_dialog_3 {
     height: 20rem;
   }

</style>