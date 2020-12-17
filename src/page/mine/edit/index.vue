<template>
  <div style="background-color: #fff;">
     <div class="img_show">
        <img class="img_bg" src="../../../assets/bg_personal_center.png" alt="">
        <div class="go_back_right">
          <img @click="goBackHome" src="../../../assets/icon_return_black.png" alt="">
         
        </div>
         <div class="show_more_left" @click="goCustomerPage">
         预览主页
        </div>
         <div class="title">
          编辑资料
        </div>
       
      <div  class="imageMes_title">
         <div>
            <div class="content_show">
              <div class="avator_content">
                <img :src="baseList.user.photo" alt=""  @click="showImage(baseList.user.photo)">
              </div>
           
              <van-uploader 
              class="tip" 
              :max-size="3 * 1024 * 1024"
              @oversize="onOversize"
              :before-read="beforeRead"
              :after-read="afterReadHead">
                点击上传形象照
              </van-uploader>
          </div>
         </div>
          <div class="love_message" >
            <div 
              class="item_love"
              v-for="(item,index) in checkList"
              :key="index"
              >
              <span class="title_love">
                {{item.title}}
              </span>
               <span class="tip_love" @click="goLove(index)">
               {{item.value}}
              </span>
            </div>
          </div>
      </div>
        
     <div class="link_content" >
      <div class="base_search">
        <div class="main_title">
          <span>我的相册</span>
        </div>
         <van-grid class="image_album" :border="false" :column-num="3">
            <!-- <van-grid-item 
              v-for="(item, index) in baseList.img_url" 
              :key="index" 
             > -->
              <!-- <van-image  v-if="index < 2" :src="item.url" /> -->
               <van-uploader
               class="image_uploader"
               :max-size="3 * 1024 * 1024"
                @delete="delImage"
                @oversize="onOversize"
                :before-read="beforeRead"
                v-model="baseList.img_url" 
                :after-read="afterRead" />
              <!-- <div 
                class="more_picture" 
                v-show="index == 5"
                >
                +{{ userMes.album.length - 6 }}
              </div> -->
          <!-- </van-grid-item> -->
         
        </van-grid>
      
      </div>
      
    </div>
    <div class="link_content" style="border-bottom: 0.5rem solid #F7F7F8;margin-top:1rem">
      <div class="base_search">
        <div class="main_title">
          <span>内心独白</span>
        </div>
        <van-field
          v-model="chooseList.desc"
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
      <van-tabs  
        style="margin-top: 0.9rem" 
        v-model="active" 
        @change="getItem" 
        color= "#FF807B" 
        line-width="1.1rem" 
        line-height="0.25rem" 
        swipeable 
        :title-active-color="activeColor" 
        :title-inactive-color="activeColor">
      <van-tab v-for="(item, index) in mineMes" :title="item" :key="index" >
      </van-tab>
    </van-tabs>
   </div>
     
    

   <div v-if="active == '0'" class="soup_top">
     <div style="border-bottom: 0.5rem solid #F7F7F8;">
       <van-cell 
        class="cell_other"  
        v-for="(item, index) in actions" 
        :title="item.name" 
        value-class="valur_class" 
        :value="item.value" 
        @click="nikeSet(item, index) "
        title-class="cell_class" 
        :key="index" 
        is-link />
        <van-action-sheet 
            v-for="(item, index2) in actions" 
            v-model="item.show" 
            :actions="(index2 != 10  || index2 != 2) ? vipActionSheet[item.selectList] : []" 
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
           <!-- <van-datetime-picker
            v-if="index2 == 12"
            v-model="currentDate"
            type="year-month"
           
            title="选择年月"
            :min-date="minDate"
            :max-date="maxDate"
            cancel-button-text=" "
           
            @confirm="marileDay(item, $event)"
          /> -->
        </van-action-sheet>
        <van-action-sheet 
            :actions="columns3" 
            v-model="heightShow" 
            @select="onSelectHeight(3,$event)"
            close-on-click-action 
          >
         
        </van-action-sheet>
        <van-action-sheet 
            :actions="columns2" 
            v-model="weightShow" 
            @select="onSelectHeight(4,$event)"
            close-on-click-action 
          >
         
        </van-action-sheet>

       
     </div>
     
      <!-- home -->
     

     

    
     <van-button class="btn_color" type="primary" @click="scrollToSoup">下一步</van-button>
   </div>
   <div v-else-if="active == '1'" >
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
            :actions="index2 != 14 || index2 != 4 || index2 != 5 ? vipActionSheet[item.selectList] : []" 
            :key="index2" 
            @select="onSelect2(item, $event)"
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
          <!-- <div v-if="index2 == 5" class="content">
             <van-area 
              title="标题" 
              :area-list="areaList" 
              columns-num="2"
               @cancel="item.show = false"
              @confirm="sureAreaVip(item, $event)"/>
           </div> -->
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
         <van-button class="btn_color" type="primary" @click="saveBaseEditMes">保 存</van-button>
   </div>
    <div v-else style="padding-bottom:50px">
    <van-cell 
    class="cell_other"
    v-for="(item, index) in actions3" 
    :title="item.name" 
    value-class="valur_class"
    :value="item.value" 
    title-class="cell_class" 
      @click="commentshow(item, index)"
    :key="index"
    :to="item.url" 
    is-link />
       <van-action-sheet 
          v-model="show" 
          :actions="commendList" 
          @select="onSelect3"
          close-on-click-action 
        /> 
         <!-- <van-button class="btn_color" type="primary" @click="saveBaseEditMes">保 存</van-button> -->
   </div>
  

    </div>
      <van-dialog  
        
        class="login_dialog" 
        style="height:18rem"
        :title="`请填写${activeName2}`" 
        closeOnClickOverlay 
        closeOnPopstate 
        :showConfirmButton="false"
        v-model="nikeNameDialog"
        v-if="nikeNameDialog"
        >
      <name-form :activeName="activeName2" :jobType="baseList.basicInfo.job_class" @sureLogin="sureLogin"></name-form>
    </van-dialog> 
     
     <van-dialog  
        class="login_dialog"
        style="height: 20rem" 
        title="修改密码" 
        closeOnClickOverlay 
        closeOnPopstate 
        :showConfirmButton="false"
        v-model="modifyPwdDialog"
        v-if="modifyPwdDialog"
        >
         <van-form 
          label-align="left" 
          label-width="4rem"
          ref="modiryForm"
          @submit="setModify">
            <van-field
              v-model="modifyForm.oldpw"
              name="原密码"
              label="原密码"
              type="password"
              placeholder="原密码"
              :rules="[{ required: true, message: '请填写原密码' }]"
            />
             <van-field
              v-model="modifyForm.newpw"
              name="新密码"
              label="新密码"
              :type="tiggerEye ? '' : 'password'"
              placeholder="新密码"
              :right-icon="tiggerEye ? 'eye' : 'closed-eye'"
               @click-right-icon="getInputValue"
              :rules="[{ required: true, message: '请填写新密码' }]"
            />
             <van-field
              v-model="modifyForm.surePwd"
              name="确认密码"
              label="确认密码"
              :type="tiggerEye2 ? '' : 'password'"
              placeholder="确认密码"
              :right-icon="tiggerEye2 ? 'eye' : 'closed-eye'"
              @click-right-icon="getInputValue2"
              :rules="[{ required: true, message: '请填写确认密码' }]"
            />
            <div v-if="showCheck" style="color: red; text-align: right; padding-right:1rem ">新密码与确认密码不一致</div>
          </van-form>
          <div class="sureSet2" @click="clearPwd">重置</div>
          <div class="sureSet3" @click="setModify">确定</div>
    </van-dialog> 
 
  </div>
</template>

<script>
import { 
  actionSheet, 
  vipActionSheet, 
  areaList 
  } from '../../components/actioneSheet'
import {  
  getBasicInfo,
  getSpouseCondition,
  addImg,
  updateMyInfo,
  updateImg, 
  delImg, 
  updateBasicInfo, 
  updateSpouseCondition,
  ModifyPassword,
  addRealReferrerVerify,
  getVVIPList
  } from '../../../service/getData'
import nameForm from '../../components/nikenameForm'
import {ImagePreview} from "vant"

export default {
  components: { nameForm},

  props: {
    
  },
  watch: {
    stateMes: {
      handler(val) {
        console.log(val, 'mes');
        if (val) {
          this.state = '邀约成功'
        } else {
          this.state = '邀约已拒绝'

        }
      },
      deep: true,
      immediate: true,
      
    },
    $route(to, from) {
     
      if (to.path == '/mine/edit') {
       
        this.getBaseList()
        this.getSpouseConditionList()
       
      }
     
    
    },
    active(val) {
      
      // if (val == '0') {
      //   this.getBaseList()
      // } else {
      //   this.getSpouseConditionList()
      // }
    }
  },
 
  data() {
    return {
      showPicker:false,
      showPicker2: false,
      // columns: [
      //   18,19,20,21,22,23,24,
      //   25,26,27,28,29,30,31,
      //   32,33,34,35,36,37,38,
      //   39,40,41,42,43,44,45,
      //   46,47,48,49,50,51,52,
      //   53,54,55,56,57,58,59,
      //   60,61,62,63,64,65,66,
      //   67,68,69,70
      // ],
      columns2: [
       
      ],
       columns3: [
       
      ],
      // columns4: [
      //   3000,5000,8000,
      //   12000,20000,50000
      // ],
      commendList:[],
      form: {},
      state: '邀约待接受',
      stateMes: false,
      dialogShow: false,
      nikeNameDialog: false,
      modifyPwdDialog: false,
      ageDialog: false,
      tiggerEye: false,
      tiggerEye2: false,
      showCheck: false,
      weightShow: false,
      activeName2: '',
      modifyForm: {
        operate: "ModifyPassword",
      },
      checkList: [
        // {title: '手机绑定', check: false, value: '立即绑定'},
        // {title: '实名认证', check: false,value: '立即认证'},
        // {title: '联合创始人认证', check: false,value: '立即认证'},
        {title: '我的爱好', check: false,value: '未填写'},
      ],
      nikeName: '',
      active: '0',
      message: '',
      area: [],
      area2: [],
      show: false,
      actionSheet: actionSheet,
      vipActionSheet: vipActionSheet,
      areaList: areaList,
      minDate: new Date(1900, 0, 1),
      maxDate: new Date(2025, 10, 1),
      currentDate: new Date(),
      activeColor: '#FF807B',
      mineMes: ['基本资料', '择偶标准','我的认证'],
      updateForm: {},
      userList: {
        user: {
          photo: ''
        }
      },
      actionsOption: [],
      actions: [
          { name: '昵称', value: '不限',show: false, filed: 'nickname'  },
          { name: '性别', value: '不限',show: false, selectList: 'sex',filed: 'sex'}, 
          { name: '出生日期', value: '不限',show: false,filed: 'birthday',code: -1 ,code: -1}, 
          { name: '身高' , value: '不限',show: false,filed: 'height',code: -1},
          { name: '体重' , value: '不限',show: false,filed: 'weight',code: -1},
          { name: '星座' , value: '不限',show: false,  selectList: 'constellations',filed: 'constellation',code: -1},
          { name: '月收入', value: '不限',show: false ,selectList: 'salary',filed: 'salary',code: -1},
          { name: '学历' , value: '不限',show: false,selectList: 'educations',filed: 'education',code: -1},
          { name: '毕业学校' , value: '不限',show: false,filed: 'graduated_school',code: -1},
          { name: '工作单位' , value: '不限',show: false,filed: 'job_unit',code: -1},
          { name: '工作生活地', value: '不限',show: false ,areaList: 'areaList',filed: 'job_addr',code: -1},
          { name: '职业', value: '不限',show: false,filed: 'job' ,code: -1},
          { name: '期望结婚时间', value: '不限',show: false ,selectList: 'mariDate',filed: 'when_marry',code: -1},
          { name: '婚姻状态', value: '不限',show: false, selectList: 'marital',filed: 'marital_status' ,code: -1},
          { name: '有无子女', value: '不限',show: false,selectList: 'children',filed: 'child' ,code: -1},
          { name: '是否想要孩子', value: '不限',show: false, selectList: 'checkName',filed: 'wanna_child' ,code: -1},
          { name: '饮酒', value: '不限',show: false, selectList: 'drinks',filed: 'drink',code: -1},
          { name: '吸烟', value: '不限',show: false, selectList: 'smokes',filed: 'smoke',code: -1},
          { name: '房产情况', value: '不限',show: false, selectList: 'children',filed: 'house',code: -1},
          { name: '车辆情况', value: '不限',show: false, selectList: 'children',filed: 'car',code: -1},
          { name: '籍贯', value: '不限',show: false, filed: 'hometown',code: -1},
      ],
       actions2: [
          { name: '年龄', value: '不限',show: false,filed: 'age', selectList: 'age' }, 
          { name: '身高', value: '不限',show: false,filed: 'height', selectList: 'height' },
          { name: '月收入', value: '不限',show: false,filed: 'salary',selectList: 'salary'  },
          { name: '学历' , value: '不限',show: false,filed: 'education',selectList: 'educations2'},   
          { name: '工作生活地', value: '不限',show: false,filed: 'job_addr', areaList: 'areaList', },
          // { name: '户籍（老家）', value: '不限',show: false,filed: 'min_age' },
          { name: '婚姻状况' , value: '不限',show: false,filed: 'marital_status',selectList: 'marital2'},
          { name: '饮酒', value: '不限',show: false,filed: 'drink',selectList: 'drinks2'  },
          { name: '吸烟', value: '不限',show: false,filed: 'smoke',selectList: 'smokes2' },
          { name: '有无子女' , value: '不限',show: false,filed: 'child',selectList: 'children2'},
          { name: '是否想要孩子' , value: '不限',show: false,filed: 'wanna_child',selectList: 'checkName2'},
          { name: '体重', value: '不限',show: false,filed: 'weight', selectList: 'weight'},
          // { name: '星座' , value: '不限',show: false,filed: 'constellations', selectList: 'constellations'},
          // { name: '职业' , value: '不限',show: false,filed: 'job'},
          // { name: '期望结婚时间', value: '不限',show: false,filed: 'when_marry' },
      ],
       actions3: [
          { name: '实名认证', value: '',url: '/check/name'}, 
          { name: '学历认证', value: '',url: '/check/education'},
          { name: '推荐人认证', value: '',  },
          { name: '联合创始人认证' , value: '',url: '/vip'},   
         
      ],
       baseList: {
        user: {
            photo: ''
          },
        basicInfo: {
          job_class: '1'
        }
      },
      heightShow: false,
      chooseList: {},
      SpouseCondition: {
        operate: 'updateSpouseCondition'
      },
      images: {},
      activeName: '',
      updataList: {},
      updataList2: {},
      session: {},
      image: [],
      soupeList: {}
      }
    },
  created() {
    for( var i = 0; i<=200;i++) {
      if (i >= 150) {
        var item = {}
       item.name = `${i}cm`
       item.code = i
       this.columns3.push(item)
      }
    }
    for( var j = 0; j<=100;j++) {
      if (j >= 45) {
        var item = {}
       item.name = `${j}kg`
       item.code = j
       this.columns2.push(item)
      }
    }
   
   console.log('this.columns3', this.columns3);
  },
  mounted() {
     this.setUpload()
      this.actionsOption = this.actions
      this.getBaseList()
      this.getSpouseConditionList()
  },
  methods: {
    goLove(index) {
      switch (index) {
       
        case 0:
           this.$router.push({ name: 'myLove', params: {id: this.baseList.user.openid}})
          break;
       
      }
     

    },
     showImage(image, index) {
      this.images = []
        this.images.push(image)
      ImagePreview({images: this.images});
    },
     nikeSetVip(item, index) {
     
      // if (index == 0) {
      //   this.ageDialog = true
      //    this.activeName = '年龄'
      // } else if (index == 1) {
      //   this.ageDialog = true
      //    this.activeName = '身高'
      // }else if (index == 2) {
      //   this.ageDialog = true
      //    this.activeName = '月收入'
      // }else if (index == 11) {
      //   this.ageDialog = true
      //    this.activeName = '体重'
      // }else {
        if (index != 13 || index != 14 || index != 12) {
          item.show = true
        }  
      // }
     },
   
    sureLogin(val) {
      if (this.activeName2 == '昵称') {
         this.actions[0].value = val
         this.actions[0].code = val
      } else if (this.activeName2 == '身高') {
        this.actions[3].value = val + 'cm'
        this.actions[3].code = val
      }else if (this.activeName2 == '体重') {
        this.actions[4].value = val + 'kg'
        this.actions[4].code = val
      }else if (this.activeName2 == '毕业院校') {
        this.actions[8].value = val
        this.actions[8].code = val
      }else if (this.activeName2 == '工作单位') {
        this.actions[9].value = val.nikeName
        this.actions[9].code = val.nikeName
        this.updataList.job_class = val.job_class
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
    nikeSet(item, index) {
       if (index == 3) {
         console.log(1111);
        this.heightShow = true
      } else if (index == 4) {
        
        this.weightShow = true
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
      } else {
        if (index == 0 || index == 1) {
          item.show = false
        } else {
          item.show = true
          
        }
        
      }
    },
    onOversize(file){
      this.$toast('文件太大，最大为3M');
    },
    delImage(val) {
      delImg({operate: 'delImg', id: val.id}).then(res => {
        if (res.Code == 0) {
          this.getBaseList()
        }
        this.$toast(res.Msg);
      })
    },
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
    onConfirm(item) {
      this.form.min = item
      this.showPicker = false
    },
     onConfirm2(item) {
       console.log(this.form.min);
       if (item > (this.form.min ? this.form.min : 0)) {
         this.form.max = item
          this.showPicker2 = false
       } else {
         this.$toast(`${this.activeName}最大值不能小于最小值`);
       }
      
    },
    scrollToSoup() {
      var el=document.getElementsByClassName('soup_top');
      this.$nextTick(function () {
          window.scrollTo({"behavior":"smooth","top":(Number(el[0].offsetTop) - 50)});
          
      })
      this.$toast("请填写择偶标准");
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
    getBaseList() {
      getBasicInfo({operate: 'getBasicInfo'}).then(res => {
        if (res.Code == 0) {
          this.baseList = res.Result ? JSON.parse(res.Result) : {}
         console.log('this.baseList', this.baseList);
           this.session = res.session
          this.baseList.img_url ? this.baseList.img_url.forEach(item => {
            item.url = decodeURIComponent(item.url)
           
          }) : this.baseList.img_url = []
          this.baseList.user.photo  = decodeURIComponent(this.baseList.user.photo) 
          this.actions.forEach(item => {
          if (this.baseList.user[item.filed]) {
            
            if (item.filed == 'nickname') {
              item.code = this.baseList.user[item.filed]
              item.value = decodeURIComponent(this.baseList.user[item.filed])
            } else if (item.selectList){
              this.vipActionSheet[item.selectList].forEach(item2 => {
                if (item2.code == this.baseList.user[item.filed]) {
                  item.value = item2.name
                }
              })
              
            } else {
               item.value = this.baseList.user[item.filed]
               
              item.code = this.baseList.user[item.filed]
            }
          }
           if (this.baseList.basicInfo[item.filed]) {
            item.value = this.baseList.basicInfo[item.filed]
            if (item.filed == 'height') {
                item.value = item.value + 'cm'
              }
              if (item.filed == 'weight') {
                item.value = item.value + 'kg'
              }
            item.code = this.baseList.basicInfo[item.filed]
             if (item.selectList){
              this.vipActionSheet[item.selectList].forEach(item2 => {
                if (item2.code == this.baseList.basicInfo[item.filed]) {
                  item.value = item2.name
                }
              })
              
            } else if (item.areaList){
              if (this.areaList.city_list[this.baseList.basicInfo.job_addr]) {
                item.value =  this.areaList.city_list[this.baseList.basicInfo.job_addr]
                item.code = this.baseList.basicInfo.job_addr
              }
            } 
          }
        })
        }
      })
    },
    getSpouseConditionList() {
     
      getSpouseCondition({ operate: 'getSpouseCondition' }).then(res => {
        if (res.Code == 0) {
          this.chooseList = res.Result ? JSON.parse(res.Result) : {}
          console.log('chooseList', this.chooseList);
        const {min_age,max_age,min_height,max_height,min_salary,max_salary,min_weight,max_weight} =this.chooseList 
        this.updateForm.min_age = min_age ? min_age : -1
         this.updateForm.max_age = max_age ? max_age : -1
         this.updateForm.min_height = min_height ? min_height : -1
         this.updateForm.max_height = max_height ? max_height : -1
        //  this.updateForm.min_salary = min_salary ? min_salary : -1
        //  this.updateForm.max_salary = max_salary ? max_salary : -1
         this.updateForm.min_weight = min_weight ? min_weight : -1
         this.updateForm.max_weight = max_weight ? max_weight : -1
          this.actions2.forEach(item => {
            if (item.filed == 'age') {
              if (max_age != -1) {
                item.value = (min_age ? min_age : '') + '~' + (max_age ? max_age : '') + '岁'
              } else {
                item.value = '40岁以上'
              }
                
              }
               if (item.filed == 'height') {
                if (max_height != -1) {
                  item.value = (min_height ? min_height : '') + '~' + (max_height ? max_height : '') + 'cm'
                } else {
                  item.value = '190以上'
                }
              }
              if (item.filed == 'salary') {
                if (max_salary != -1) {
                  item.value = (min_salary ? min_salary : '') + '~' + (max_salary ? max_salary : '')
                } else {
                  item.value = '50000 +'
                }
                
              }
              if (item.filed == 'weight') {
                if (max_weight != -1) {
                  item.value = (min_weight ? min_weight : '') + '~' + (max_weight ? max_weight : '')+ 'kg'
                } else {
                  item.value = '80kg以上'
                }
              }
          if (this.chooseList[item.filed]) {
             if (item.selectList){
              this.vipActionSheet[item.selectList].forEach(item2 => {
                if (item2.code == this.chooseList[item.filed]) {
                  item.value = item2.name
                }
              })
              
            }else if (item.areaList){
              if (this.areaList.city_list[this.chooseList.job_addr]) {
                item.value =  this.areaList.city_list[this.chooseList.job_addr]
                item.code = this.chooseList.job_addr
              }
            }  else {
              
              
              item.value = this.chooseList[item.filed] != -1 ? this.chooseList[item.filed] : '不限'
              item.code = this.chooseList[item.filed]
            } 
          }
         })
        }
      })
    },
    onSelectHeight(index, e) {
      console.log('e',e);
      this.actions[index].value = e.name 
      this.actions[index].code = e.code
    },
    saveBaseEditMes() {
      // if (this.active == '0') {
         this.actions.forEach((item,index) => {
           if (index > 1 && item.code != -1) {
             this.updataList[item.filed] = item.code
           }
          
        })
        console.log('list2', this.updataList);
         
        this.actions2.forEach(item => {
           
           if (item.filed != 'age' && item.filed != 'height'  && item.filed != 'salary' && item.filed != 'weight') {
             item.code != -1 ? this.soupeList[item.filed] = item.code : ''
           }
            
          })
        // console.log('list2', this.soupeList);
        
        // this.updataList.nation = -1
        // this.updataList.province = this.area[0] ? this.area[0].code : -1
        // this.updataList.city = this.area[1] ? this.area[1].code :  -1
         this.area[1] ? this.updataList.job_addr = this.area[1].code :  ''

        const {min_age, max_age, min_height, max_height, min_salary, max_salary, min_weight, max_weight} = this.updateForm
        this.soupeList.min_age =min_age 
        this.soupeList.max_age =max_age
        this.soupeList.min_height =min_height 
        this.soupeList.max_height =max_height
        this.soupeList.min_salary =min_salary 
        this.soupeList.max_salary =max_salary
        this.soupeList.min_weight =min_weight 
        this.soupeList.max_weight =max_weight
         this.chooseList.desc ? this.soupeList.desc = this.chooseList.desc : ''
        // this.soupeList.house = -1
        // this.soupeList.car = -1
        this.soupeList.job_addr = this.area2[1] ? this.area2[1].code : this.soupeList.job_addr
        
        // this.updataList.internal_monolog = -1
        // this.updataList.family_situation = -1
        // this.updataList.career_planning = -1
        // this.updataList.emotional_experience = -1
        var list1 = JSON.stringify(this.updataList)
        var list2 = JSON.stringify(this.soupeList)
        console.log('list2', list2);
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
            this.getBaseList()
            this.getSpouseConditionList()
            this.$toast(res.Msg);
          } else {
            this.$toast(res.Msg);
          }
        })
     
     
    },
    onSelect(item, val) {
      console.log(item);
      console.log(val);
      item.value = val.name
      item.code = val.code
    },
     onSelect2(item, val) {
      item.value = val.name
      item.code = val.code
      if (item.filed == 'age') {
        this.updateForm.min_age = val.min
        this.updateForm.max_age = val.max
      }
      if (item.filed == 'salary') {
        this.updateForm.min_salary = val.min
        this.updateForm.max_salary = val.max
      }
      if (item.filed == 'weight') {
        this.updateForm.min_weight = val.min
        this.updateForm.max_weight = val.max
      }
      if (item.filed == 'height') {
        this.updateForm.min_height = val.min
        this.updateForm.max_height = val.max
      }
    },
    commentshow(item, index) {
      console.log(index);
      if (index == 2) {
        this.show = true
          this.getComment()
        
      }
    },
     getComment() {
       getVVIPList().then(res => {
        if (res.Code == 0) {
           this.commendList = JSON.parse( res.Result)
           console.log('JSON.parse( res.Result)', JSON.parse( res.Result));
           if (this.commendList && this.commendList.length> 0) {
             
             var otherList = this.commendList.map(({nickname , openid}) => ({
               name: decodeURIComponent(nickname),
               value: openid
             }))
             this.commendList = otherList
             console.log('commendList', this.commendList);
           }
            this.getCheckState()
           
        } else {
          this.$toast(res.Msg);
        }
      })
    },
    onSelect3(val) {
       console.log('command', val);
      addRealReferrerVerify({operate: 'addRealReferrerVerify', real_referrer: val.value}).then(res => {
        if (res.Code == 0) {
          this.$emit('success')

           this.$toast(res.Msg);
        } else {
          this.$toast(res.Msg);
        }
      })
    },
    clear() {
      this.nikeName = ''
    },
    getInputValue() {
      this.tiggerEye = !this.tiggerEye
    },
    getInputValue2() {
      this.tiggerEye2 = !this.tiggerEye2
    },
    goCustomerPage() {
      this.$router.push({name: 'customer', params: { item: this.baseList.user}})
    },
    setModify() {
      this.$refs.modiryForm.validate().then(valid => {
        if (valid == undefined) {
           if (this.modifyForm.surePwd != this.modifyForm.newpw) {
            this.showCheck = true
            // this.$toast({
            //       message: '新密码与确认密码不一致',
            // });
          } else {
            this.showCheck = false

            ModifyPassword(this.modifyForm).then(res => {
              if (res.Code == 0) {
                this.$toast(res.Msg);
                this.modifyPwdDialog = false
              } else {
                this.$toast(res.Msg);
              }
            })
          }
        }
       
      })
     
    },
    clearPwd() {
      this.modifyForm = {
        operate: "ModifyPassword",
        oldpw: null,
        newpw: null,
        surePwd: null,
      }
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
      val.code = `${year}-${month}-${day}`
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
   @import '../../../style/mixin';

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

   padding-bottom: 0  !important;
    width: 19.6rem;
  background-color: #fff;
  top: -5rem

 }
 .accset.van-tabs {
   width: 100%;
 }
 .van-tabs {
   
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
    // position: absolute;
    // top: 1.2rem;
    display: flex;
    padding: 0.9rem;
    align-items: center;
   
    height: 5rem;
    font-family: PingFangSC-Regular, PingFang SC;
  }
  .avator_content {
   
    @include wh(4rem, 4rem);
    border-radius: 50%;
    margin-left: 0.8rem;
    margin-top: 1rem;
    // flex: 1;
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
    top: 2rem;
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
  //   background: url('../../../assets/icon_more_small_black.png') no-repeat center;
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
    .love_message {
      // position: absolute;
      // bottom: 0;
      
      width: 100%;
      margin-top: 1rem;
    }
    .item_love {
      display: flex;
      padding: 0 2rem;
      justify-content: space-between;
      height: 3rem;
      //  background-color: pink;
       font-family: PingFangSC-Regular, PingFang SC;
      font-weight: 400;
      line-height: 3rem;
    }
    .item_love .title_love {
      font-size: 0.8rem;
      color: #262B40;
    }
     .item_love .tip_love {
        font-size: 0.8rem;
        color: #505050;
    }
    .van-cell {
        padding: 12px;
        background-color: #fff;
    }
    .tip_love::after {
      content: '';
      display: inline-block;
      width: 0.5rem;
      height: 0.5rem;
      border-top:1px solid #000 ;
      border-right:1px solid #000 ;
      transform: rotate(45deg) scaleY(1);
    }
</style>