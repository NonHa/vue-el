<template>
  <div >
    <!-- <NavBarHead class="nav_other_class" :title="title" :border="false" @goBack="goBackArticle" @showItem="showArticleItem"></NavBarHead> -->
    <div class="img_show">
      <img :src="userMes.user.photo ? userMes.user.photo : ''" alt="">
      <div  @click="goBackHome" class="go_back_right">
        <img src="../../assets/icon_return_white.png" alt="">
      </div>
      <div class="show_more_left">
        <img src="../../assets/icon_more_white.png" alt="">
      </div>
    </div>
    <div class="message_head">
      <div class="name">
       <span>
          {{ userMes.user.nickname ? userMes.user.nickname : '' }}，{{userMes.user.age}}岁
       </span>
       <img 
        src="../../assets/icon_like_ select_big.png" 
        alt=""
        @click="loveClick"
        >
      </div>
      <div class="address">
        <span class="message_address">
          {{userMes.base ? userMes.base.job_addr : ''}}/{{userMes.user.job ? userMes.user.job : ''}}/{{ userMes.user.salary }}
        </span>
        <span class="like_num">
          {{ count }}人喜欢
        </span>
      </div>
    </div>

     <div class="link_content">
        <div class="base_search">
          <div class="main_title">
            <span>基本信息</span>
            <!-- <div class="more_message" @click="goMoreMes">查看更多</div> -->
          </div>
          <div class="introduce_mes">
          <van-tag 
            text-color="#505050"
            round 
            type="primary"
            v-for="(item, index) in baseList"
           
            :key="index"
            >
            {{  item.value }}
            </van-tag>
         
          </div>
        <!-- <van-row style="margin-top: 0.2rem" v-for="(item, index) in baseMessage" :key="index">
            <van-col span="8">{{item.name}}</van-col>
            <van-col span="8">{{item.value}}</van-col>
          
          </van-row> -->
        </div>
         <div class="base_search">
          <div class="main_title">
            <span>内心独白</span>
          </div>
          <div class="introduce_mes">
            {{userMes.mate.desc != -1 ? userMes.mate.desc : ''}}
            
          </div>
        </div>
        <!-- <div class="base_search">
          <div class="main_title">
            <span>自我介绍</span>
          </div>
          <div class="introduce_mes">
             {{userMes.base.internal_monolog != -1 ? userMes.base.internal_monolog : ''}}
          </div>
          </div> -->
      </div>

      <div class="link_content">
        <div class="base_search">
          <div class="main_title">
            <span>TA的相册</span>
          </div>
        <van-grid class="image_album" :border="false" :column-num="3">
          <van-grid-item 
            v-for="(item, index) in userMes.album" 
            v-if="index < 6" 
            :key="index" 
            @click="showImage(userMes.album, index)">
            <van-image v-if="index < 6"  :src="item.url" />
            <div 
              class="more_picture" 
              v-show="index == 5"
              >
              +{{ userMes.album.length - 6 }}
            </div>
          </van-grid-item>
         
        </van-grid>
        </div>
        <div class="base_search">
          <div class="main_title">
            <span>TA的认证</span>
          </div>
        <div class="sure_check">
          <div class="sure_name">
            <img v-if="userMes.auth.real_name" src="../../assets/real_name_select_big.png" alt="">
            <img v-else src="../../assets/real_name_big.png" alt="">
            <span>实名认证</span>
          </div>
          <div class="sure_education">
            <img v-if="userMes.auth.edu != 0" src="../../assets/education_select_big.png" alt="">
            <img v-else src="../../assets/education_big.png" alt=""> 
            <span>学历认证</span>

          </div>
          <div class="sure_work" >
             <img v-if="userMes.vipinfo.vip_id == 1" src="../../assets/founder_certification_select_big.png" alt="">
            <img v-else src="../../assets/founder_certification_big.png" alt="">
            
            <span>联合创始人</span>
          </div>
        </div>
        </div>
      </div>
      
       <div class="link_content">
          <div class="base_search">
          <div class="main_title">
            <span>TA的爱好</span>
          </div>
          <div class="introduce_mes love_message">
            喜欢的一道菜：{{loveForm.hobby_food ? loveForm.hobby_food : ''}}<br/>
            欣赏的电影：{{loveForm.hobby_film ? loveForm.hobby_film : ''}}<br/>
            喜欢的一首歌：{{loveForm.hobby_song ? loveForm.hobby_song : ''}}<br/>
            喜欢的一本书：{{loveForm.hobby_book ? loveForm.hobby_book : ''}}<br/>
            喜欢做的事：{{loveForm.hobby_thing ? loveForm.hobby_thing : ''}}<br/>
            
          </div>
        </div>
        <div class="base_search">
          <div class="main_title">
            <span>择偶标准</span>
            <!-- <div class="more_message" @click="goMoreChoose">查看更多</div> -->

          </div>
          <div class="introduce_mes">
          <van-tag 
            text-color="#505050"
            round 
            type="primary"
            v-for="(item, index) in checkList"
            :key="index"
            >
            {{ item.value }}
            </van-tag>
         
          </div>
        </div>
       <!-- <div class="base_search">
          <div class="main_title">
            <span>家庭情况</span>
          </div>
          <div class="introduce_mes">
            {{userMes.base.family_situation}}
            
          </div>
        </div>
        <div class="base_search">
          <div class="main_title">
            <span>职业规划</span>
          </div>
          <div class="introduce_mes">
            {{userMes.base.career_planning}}
          </div>
        </div> -->
       
      </div>

       <div class="link_content_item" style="padding-top: 0.5rem">
       
          <div class="base_search">
            <div class="main_title">
            <span>TA的礼物</span>
            </div>
            <div class="lw_look">
              
            </div>
             <div class="base_search">
         
            <div class="gave_more">
              <div class="sure_name">
                <div class="gold">
                  <img src="../../assets/icon_gift.png" alt="">
                  <span>礼物</span>
                </div>
              </div>
              <div @click="toVisite" class="sure_name">
                <div class="pink">
                  <img src="../../assets/icon_invitation.png" alt="">
                <span style="color:#FF807B ">邀约</span>
                </div>

              </div>
              <!-- <div class="sure_name">
               <div class="blue">
                  <img src="../../assets/icon_pull_strings.png" alt="">
                <span style="color: #404868">牵线</span>
               </div>

              </div> -->
        </div>
        </div>
      </div>
          
    </div>
       <van-dialog v-if="dialogShow" v-model="dialogShow" title="温馨提示" closeOnClickOverlay closeOnPopstate :showConfirmButton="false">
         请注册成为会员，邀约线下见面
         <!-- <div class="sureSet2" @click="dialogShow = false">取消</div> -->
         <div class="sureSet" @click="sureSet">确定</div>
  </van-dialog> 
  </div>
</template>

<script>

import NavBarHead from '../components/NavBarTab'
import { 
  getUserByID,
  getBeLoveCountById,
  addLove,
  getBeLovedCountById,
  getHobby
  } from '../../service/getData'
import {ImagePreview} from "vant"
import { 
  actionSheet, 
  vipActionSheet, 
  areaList 
  } from '../components/actioneSheet'
import moment from 'moment'

export default {
  components: { NavBarHead },
  data() {
    return {
      title: '',
      dialogShow: false,
      userMes: {
        user: { photo: null },
        base: { job_addr: null },
        auth: {},
        mate: {  desc: null },
        vipinfo: {}
      },
      baseMessage: [
        { name: '工作单位', filed: 'job_addr', value: ''},
        { name: '职业', filed: 'job',value: ''},
        { name: '月收入', filed: 'salary',value: ''},
        { name: '学历', filed: 'education',value: ''},
        { name: '毕业学校', filed: 'graduated_school',value: ''},
        { name: '身高', filed: 'height',value: ''},
        { name: '体重', filed: 'weight',value: ''},
        { name: '星座', filed: 'constellation',value: ''},
        { name: '婚姻状态', filed: 'marital_status',value: '',selectList: 'marital2'},
      ],
      loveForm: {},
      checkList: [],
      baseList: [],
      index: 0,
      loveCount: 0,
      count: 0,
      userMes2: {},
      vipActionSheet: vipActionSheet,
      areaList: areaList,
      images: [
        'https://img.yzcdn.cn/vant/apple-1.jpg',
        'https://img.yzcdn.cn/vant/apple-2.jpg',
      ],
    }
  },
  watch: {
    $route(to, from) {
      if (from.path == '/home' || from.path == '/edit/index' || from.path == '/search') {
        console.log('customer', to);
        this.loveCount = 0
        this.count = 0
       
        if (to.params.item) {
           this.userMes2 = to.params.item
           this.getMessageById( this.userMes2)
            this.getLovedCount( this.userMes2)
            this.getHobbyId(this.userMes2)
        }
      }
    }
  },
  created() {
    
    this.loveCount = 0
    this.count = 0
    this.userMes2 = this.$route.params.item
    this.getMessageById(this.userMes2)
    this.getLovedCount(this.userMes2)
    this.getHobbyId(this.userMes2)

  },
  methods: {
    getLovedCount(item) {
      console.log('love',item);
      if (item.openid != undefined) {
        getBeLovedCountById({operate: 'getBeLovedCountById', user_openid: item.openid}).then(res => {
        if (res.Code == 0) {
          this.count = JSON.parse(res.Result)
        }
      })
      }
      
    },
    getHobbyId(item) {
      getHobby({operate: 'getHobby', user_openid:item.openid}).then(res => {
        if (res.Code == 0) {
          var resLove = JSON.parse(res.Result)
          console.log('resLove', resLove);
          if (resLove) {
            this.loveForm = resLove
          } else {
            this.loveForm = {
              hobby_food: null,
              hobby_film: null,
              hobby_song: null,
              hobby_book: null,
              hobby_thing: null,
            }
          }
          
        }
      })
    },
    showImage(image, index) {
      this.images = []
      if ( image instanceof Array) {
        image.forEach((item, index2) => {
            this.images.push(item.url)
        })
      } else {
        this.images.push(image)
      }
      ImagePreview({images: this.images, startPosition: index});
    },
   
    getMessageById(item) {
      if (item) {
         this.userMes = {
        user: {
          photo: null
        },
        base: {
          job_addr: null
        },
        auth: {},
        mate: {
          desc: null
        },
        vipinfo: {}
      }
         
      getUserByID({id: item.id,operate: "getUserByID"}).then(res => {
        
        if (res.Code == 0) {
           
            this.userMes = JSON.parse(res.Result)
            if (this.userMes.vipinfo.vip_id <= 0) {
                this.dialogShow = true
            } 
            console.log('userMes', this.userMes);
           this.userMes.user.nickname = decodeURIComponent(this.userMes.user.nickname)
           this.userMes.user.photo = this.userMes.user.photo ? decodeURIComponent(this.userMes.user.photo) : ''
          
           const mate =  JSON.parse(JSON.stringify(this.userMes.mate))
           this.checkList = []
           this.baseList = []
          
          const {job,job_addr,constellation,graduated_school,education,weight,height,wanna_child,when_marry,marital_status,drink,smoke,child,nation,house,car,salary,hometown} = this.userMes.base
          const {constellations,educations,marital,smokes2,mariDate,nations2,drinks2,hourse2,salary2} = this.vipActionSheet
            
            if (mate) {
              if (mate.min_age > -1 || mate.max_age > -1) {
                if (mate.max_age != -1) {
                  this.checkList.push({ value: `${ mate.min_age != -1 ? mate.min_age : 0 }~${ mate.max_age != -1 ? mate.max_age : 0}岁` })
                } else {
                  this.checkList.push({ value: `${ mate.min_age != -1 ? mate.min_age : 0 }岁以上` })
                  
                }
                
              }
             if (mate.min_height > -1 || mate.max_height > -1) {
               if (mate.max_height != -1) {
                 this.checkList.push({ value: `${ mate.min_height != -1 ? mate.min_height : 0 }~${ mate.max_height != -1 ? mate.max_height : 0}cm` })
               } else {
                 this.checkList.push({ value: `${ mate.min_height != -1 ? mate.min_height : 0 }cm以上` })
               }
               
             }
             if (mate.min_weight > -1 || mate.max_weight > -1) {
               if (mate.max_weight != -1) {
                 this.checkList.push({ value: `${ mate.min_weight != -1 ? mate.min_weight : 0 }~${ mate.max_weight != -1 ? mate.max_weight : 0}kg` })
               } else {
                 this.checkList.push({ value: `${ mate.min_weight != -1 ? mate.min_weight : 0 }kg以上` })
               }
               
             }
              if (mate.min_salary > -1 || mate.max_salary > -1) {
                if (mate.max_salary != -1) {
                  this.checkList.push({ value: `${ mate.min_salary != -1 ? mate.min_salary : 0 }~${ mate.max_salary != -1 ? mate.max_salary : ''}` })
                } else {
                  this.checkList.push({ value: `${ mate.min_salary != -1 ? mate.min_salary : 0 } +` })
                }
                 
              } 
              mate.marital_status != -1 ? this.checkList.push({value:  marital[mate.marital_status].name} ) : ''
              mate.education != -1 ? this.checkList.push({value:  educations[mate.education].name}  ) : ''
              mate.house != -1 ? this.checkList.push({value:mate.house == 1 ? '已购房' : mate.house == 0 ? '未购房': ''  }) : ''
              mate.car != -1 ? this.checkList.push({value:  mate.car == 1 ? '已买车' : mate.car == 0 ? '未买车': '' } ) : ''
             // mate.desc != -1 ?  this.checkList.push({value:  mate.desc } ) : ''
              mate.drink != -1 ? this.checkList.push({value: drinks2[mate.drink].name}   ) : ''
              mate.smoke != -1 ? this.checkList.push({value:  smokes2[mate.smoke].name }) : ''
              mate.job_addr ? this.checkList.push({value:  `工作地点:${this.areaList.city_list[mate.job_addr] ? this.areaList.city_list[mate.job_addr] : this.areaList.county_list[mate.job_addr]}`}  ) : ''
              mate.child != -1 ? this.checkList.push({value:  `有无子女：${mate.child == 1 ? '有' : mate.child == 0 ? '无': ''}` } ) : ''
             mate.wanna_child != -1 ? this.checkList.push({value:  mate.wanna_child == 1 ? '是否想要孩子：想要孩子' : mate.wanna_child == 0 ? '是否想要孩子：不想要孩子': '' } ) : ''
           }
            this.userMes.user.job = job ? job : 0
            if (this.userMes.base) {
              this.userMes.user.salary = this.vipActionSheet.salary2[this.userMes.base.salary] ? this.vipActionSheet.salary2[this.userMes.base.salary].name : this.userMes.user.salary
              this.userMes.base.age = this.userMes.user.age
              if (job_addr) {
                this.userMes.base.job_addr =  this.areaList.city_list[job_addr] || this.areaList.county_list[job_addr]
                this.userMes.base.job_addr  ? this.baseList.push({value:  `工作地点:${this.userMes.base.job_addr}`}  ) : ''
              }  
              constellation != -1 ? this.baseList.push( {value: `${constellations[constellation].name}(${constellations[constellation].Start}~${constellations[constellation].End})`} ) : ''
              education != -1 ? this.baseList.push({value:  educations[education].name}  ) : ''
              salary  ? this.baseList.push({value:  `月收入:${ salary2[salary] ? salary2[salary].name : salary}`}  ) : ''
              job  ? this.baseList.push({value:  job}  ) : ''
              drink != -1 ? this.baseList.push({value: drinks2[drink].name}   ) : ''
              smoke != -1 ? this.baseList.push({value:  smokes2[smoke].name }) : ''
              child != -1 ? this.baseList.push({value:   child == 1 ? '有小孩' : child == 0 ? '没有小孩' : ''}) : ''
              house != -1 ? this.baseList.push({value:house == 1 ? '已购房' : house == 0 ? '未购房': ''  }) : ''
              car != -1 ? this.baseList.push({value:  car == 1 ? '已买车' : car == 0 ? '未买车': '' } ) : ''
              wanna_child != -1 ? this.baseList.push({value:  wanna_child == 1 ? '是否想要孩子：想要孩子' : wanna_child == 0 ? '是否想要孩子：不想要孩子': '' } ) : ''
              // nation != -1 ? this.baseList.push( {value: nations2[nation].name} ) : ''
              marital_status != -1 ? this.baseList.push({value:  marital[marital_status].name} ) : ''
              weight != -1 ? this.baseList.push({value:  `${weight}kg` }) : ''
              height != -1 ? this.baseList.push({value:  `${height}cm`} ) : ''
              graduated_school != -1 ? this.baseList.push({value:  `${graduated_school}`} ) : ''
              when_marry != -1 ? this.baseList.push({value:  `期望结婚时间:${mariDate[when_marry].name}`} ) : ''
              hometown != -1 ? this.baseList.push({value:  `籍贯:${hometown}`} ) : ''
             this.baseMessage.forEach(item => {
             if (this.userMes.base) {
               item.value = this.userMes.base[item.filed]
             } else {
               item.value = ''
             }
            
           }) 
           if(this.userMes.base.birthday) {
             this.$set(this.userMes.user, 'age', moment().diff(moment(this.userMes.base.birthday), "years") != NaN ? moment().diff(moment(this.userMes.base.birthday), "years") : '')
             console.log('this.userMes.user.age', this.userMes.user.age);
             if (isNaN(this.userMes.user.age)) {
               this.userMes.user.age= ''
             } else {
                this.baseList.push({value: `${this.userMes.user.age}岁`})
             }
             
            

           }else {
             this.$set(this.userMes.user, 'age', 0)
           }
          }
            
          
          this.userMes.album ?  this.userMes.album.forEach(item => {
            item.url = decodeURIComponent(item.url)
          }) : ''
          
        } else {
           this.$toast(res.Msg);
          this.dialogShow = true
        }
      })
      }
    },
    loveClick() {
      if (this.userMes2.openid) {
        addLove({operate: 'addLove', to: this.userMes2.openid}).then(res => {
          if (res.Code == 0) {
          //  this.getList()
            this.getMessageById(this.userMes2)
        } else {
            this.$toast(res.Msg);
        }
      })
      }
      
    },
    getCount(item) {
      if (item) {
        getBeLoveCountById({operate: 'getBeLoveCountById', user_openid: item.openid}).then(res => {
          if (res.Code == 0) {
            this.loveCount = JSON.parse(res.Result)
          }
        })
      }
      
    },
    goBackHome() {
      this.$router.push({name: 'Main'})
    },
    showHomeItem() {

    },
    goMoreMes() {
      this.$router.push({ name: 'moreMes', params: { baseMes: this.userMes.base } })

    },
    goMoreChoose() {
      this.$router.push({ name: 'moreChose', params: { moreMes: this.userMes.mate }})

    },
    toVisite() {
      if (this.userMes.vipinfo.vip_id > 0) {
        this.$router.push({ name: 'customerVisite', params: { userMes: this.userMes.user }})
      } else {
        this.dialogShow = true
      }
    },
    sureSet() {
        this.$router.push({ name: 'vip',})
    }
  }
}
</script>

<style lang="scss" scoped>
@import '../../style/mixin';
  

  .nav_other_class {
    background-color: rgba(0,0,0,0) !important;
    // opacity: 0
  }
  .img_show {
    position: relative;
    width: 100%;
    // @include wh(100%, 20rem);
   
  }
  .img_show img{
    width: 100%;
    // @include wh(100%, 100%);

  }
  .link_content {
    margin-top: 0rem;
  }
  .show_more_left {
    right: 0.9rem;
  }
  .message_head {
    padding: 1.1rem 1.1rem;
    border-bottom: 1px solid #E0E0E0;
     font-family: PingFangSC-Semibold, PingFang SC;
  }
  .name {
    @include wh(100%, 1.3rem);
    @include sc(1.1rem, #262B40);
    display: flex;
    font-weight: 600;
    line-height: 1.6rem;
  }
  .name span {
    flex: 1;
  }
  .name img {
    margin-right: 0.8rem;
    @include wh(1.5rem, 1.5rem);

  }
   .address {
     display: flex;
     margin-top: 0.7rem;
   }
   .address::before {
    content: '';
    @include wh(0.9rem, 0.9rem);
    
    position: absolute;
    background: url('../../assets/icon_address.png') no-repeat center;
    background-size: cover;
  }
 
  .address .message_address {
    @include sc(0.8rem, #505050);
    height: 0.9rem;
    font-weight: 400;
    line-height: 0.9rem;
    padding-left: 1rem;
    flex: 1;
  }
  .like_num {
   height: 0.9rem;
    @include sc(0.8rem, #8C8C8C);

    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;

    line-height: 0.9rem;
  }

  
  .van-row {
   
    height: 2rem;
    color: #646464 !important;
    font-size: 0.8rem !important;
      // @include sc(0.8rem,#646464);
    font-family: PingFangSC-Regular, PingFang SC !important;
    font-weight: 400 !important;
    
    line-height: 2rem;
  }
  .introduce_mes {
    @include sc(0.9rem,#646464);
    margin-top: 0.9rem;
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    line-height: 1.1rem;
  }
  .van-grid-item:last-child .van-image::before {
    content: '';
    position: absolute;
    
      @include wh(100%, 100%);
   
    opacity: 0.39;
    background-color: #000;

  }
  .more_picture {
    position: absolute;
    @include sc(1rem,#FFFFFF);
    
  }

  .sure_check {
      @include wh(100%, 6.5rem);
      background: #FAFAFA;
      border-radius: 0.3rem;
      margin-top: 0.9rem;
      border: 2px solid #E0E0E0;
      display: flex;
      font-size: 12px;
  }
  .sure_check div {
    padding: 0.9rem;
    text-align: center;
    flex: 1;
  }
  .sure_check img {
    display: block;
    margin-left: 0.8rem;
      @include wh(3.2rem, 3.2rem);

  }
 
  .sure_check span {
    @include sc(0.5rem,#262B40);
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    
    line-height: 24px;
  }
  .van-tag--primary.van-tag--plain {
    @include sc(0.8rem,#505050);

  }
  .van-tag--primary {
    background-color:#f6f6f6;
  }
  .van-tag {
    margin-left: 0.3rem;
    margin-top: 0.4rem;
    padding: 0.4rem 1rem;
     background: #f6f6f6;
    border-radius: 0.8rem;
  }
  .lw_look {
    @include wh(3.2rem, 3.2rem);
  }

  .gave_more {
      @include wh(100%, 6.5rem);
      display: flex;
  }
  .gave_more .sure_name {
    padding: 0.9rem;
    text-align: center;
    flex: 1;
   

  }
  .sure_name div {
     @include wh(5rem, 5rem);
    border-radius: 50%;
    border: 1px solid #fff;
    margin: 0 auto;
  }
  .pink {
    // border: 1px solid ;
   
    box-shadow: 0px 6px 30px 0px rgba(255, 128, 123, 0.3);
    
  }
  .gold {
    
box-shadow: 0px 6px 30px 0px rgba(206, 164, 118, 0.4);
  }
  .blue {
    
box-shadow: 0px 6px 30px 0px rgba(64, 72, 104, 0.16);
  }
  .gave_more img {
    display: block;
    margin-top: 1rem;
    margin-left: 1.5rem;
      @include wh(1.9rem, 1.9rem);

  }
  .gave_more span {
    @include sc(0.7rem,#CEA476);
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    
    line-height: 0.9rem;
  }
  .love_message {
    @include sc(0.7rem,#646464);
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    line-height: 1.4rem;
  }
</style>