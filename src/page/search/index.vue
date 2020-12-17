<template>

  <div>
    
     <van-tabs 
    @change="getIndex" 
    v-model="index" 
    class="accset" 
    color= "#FF807B"  
    line-width="1.1rem" 
    ine-height="0.25rem" 
    swipeable
    sticky  >
    <div class="search">
    <van-row class="goBack_search">
      <van-col span="2">
          <img @click="goHome" src="../../assets/icon_return.png" alt="">
      </van-col>
      
    </van-row>
  </div>
    <van-tab 
      v-for="(item, index) in homeTabList" 
      :title="item" :key="index" 
      title-inactive-color="#FF807B"
      >
      <div v-if="index == 1">
         <van-search 
          class="search_input" 
          v-model="value" 
          placeholder="搜索用户昵称或ID" 
          background="#FFF"
          @click="doneSearch"
          />
      </div>
      <div v-else>
        <div class="link_content">
      <div class="base_search">
        <div class="main_title">
          <span>基本搜索</span>
        </div>
        <van-cell 
          class="cell_other" 
          v-for="(item, index) in actions" 
          :title="item.name" 
          value-class="valur_class" 
          :value="item.value" 
          title-class="cell_class" 
          @click="nikeSet(item,index)"
          :key="index" 
          is-link />
       <van-action-sheet 
            v-for="(item, index2) in actions" 
            v-model="item.show" 
            :actions="vipActionSheet[item.selectList]" 
            :key="index2" 
            @select="onSelect(item, $event)"
            close-on-click-action 
          >
           <div v-if="index2 == 2" class="content">
             <van-area 
              title="标题" 
             
              :area-list="areaList" 
              columns-num="2"
              @cancel="item.show = false"
              @confirm="sureArea(item, $event)"/>
           </div>
           
        </van-action-sheet>
      </div>
      
  </div>
 
  <div class="vip_content">
    <div class="base_search_vip">
        <div class="main_title" style="display: inline-block; width: 19.2rem">
          <span style="width: 23%">高级搜索</span>
          <div class="vip_user">升级会员后即可使用</div>
        </div>
        <van-cell 
          class="cell_other" 
          v-for="(item, index) in actions2" 
         
          :title="item.name" 
          value-class="valur_class" 
          :value="item.value" 
          title-class="cell_class" 
          :key="index"
          @click="setVip(item, index)" 
          is-link />
         <van-action-sheet 
            v-for="(item, index2) in actions2" 
           
            v-model="item.showVip" 
            :actions="vipActionSheet[item.selectList]" 
            :key="index2" 
            @select="onSelectVip(item, $event)"
            close-on-click-action 
          >
           <!-- <div v-if="index2 == 1" class="content">
             <van-area 
              title="标题" 
             
              :area-list="areaList" 
              columns-num="2"
               @cancel="item.showVip = false"
              @confirm="sureAreaVip(item, $event)"/>
           </div> -->
        </van-action-sheet>
        
      </div>
  </div>
      </div>
      <!-- 搜索内容 -->
      <div   
      class="article_item" 
      v-for="(item, index) in searchList"
      :key="index"
      @click="visiteMes(item)"
      >
      <div class="img_item" >
        <img :src="item.photo" alt="">
      </div>
      <div class="content_item">
        <div style="line-height: 1.1rem;">
          <h3>
            {{ item.nickname }}
          </h3>
        </div>
        <div style="line-height: 1rem; margin-top: 0.5rem">
          <p>
            {{ item.job_addr != -1 ? item.job_addr : '' }}
          </p>
        </div>
        <div style="line-height: 0.7rem; margin-top: 1rem">
          <span>
            {{ item.desc != -1 ? item.desc : '' }}
          </span>
        </div>
      </div>
    </div>
     <van-row style="margin:2rem 0">
      <van-col span="12">
       
         <van-button type="primary" @click="clearSearchOptions">重置</van-button>
        
      </van-col>
      <van-col  span="12">
       <van-button class="mainBtn" type="primary" @click="handleSearch">确定</van-button>
      </van-col>
      
    </van-row>
    </van-tab>
  </van-tabs>
 
 
  
  
   
    

    <van-dialog  
        
        class="login_dialog"
        style="height: 14rem" 
        title="年龄范围" 
        closeOnClickOverlay 
        closeOnPopstate 
        :showConfirmButton="false"
        v-model="ageDialog"
        v-if="ageDialog"
        >
        <choose-age :activeName="activeName" @setAge="setAge"></choose-age>
        
    </van-dialog> 
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

  </div>
</template>

<script>
import { actionSheet, vipActionSheet, areaList } from '../components/actioneSheet'
import {  preciseSearch, getSearch} from '../../service/getData'
import nameForm from '../components/nikenameForm'
import { getSession, setSession, setIdxCity } from '../../utils/auth' // get token from cookie


export default {
  components: {  nameForm,},
  data() {
    return {
      iconUrl: './samll_search.png',
      value: '',
      show: true,
      activeName2: '',
      nikeNameDialog: false,
      ageDialog: false,
      workForm: {},
      homeTabList: [ '条件搜索', '精准搜索',],
      actions: [
        { name: '性别',selectList: 'sex', value: '不限',show: false, filed: 'sex' }, 
        { name: '年龄范围',selectList: 'age', value: '不限',show: false, filed: 'age' }, 
        { name: '工作生活地', value: '不限',areaList: 'areaList', show: false, filed: 'job_addr' }, 
        { name: '身高范围',value: '不限', show: false,selectList: 'height' , filed: 'height' }, 
        { name: '月收入',value: '不限', show: false,selectList: 'salary', filed: 'salary' }],
      actions2: [
          // { name: '职业', value: '不限',showVip: false, filed: 'job' },
          // { name: '户籍', value: '不限',showVip: false, filed: 'hometown', house: true },
          // { name: '星座', value: '不限',selectList: 'constellations',showVip: false, filed: 'constellation', selectList: 'constellations' },
          { name: '学历', value: '不限',selectList: 'educations',showVip: false, filed: 'education', selectList: 'educations2'},
          { name: '抽烟', value: '不限',showVip: false, filed: 'smoke', selectList: 'smokes2' },
          { name: '喝酒', value: '不限',showVip: false, filed: 'drink', selectList: 'drinks2' },
          { name: '婚姻状态', value: '不限',showVip: false, filed: 'marital_status', selectList: 'marital2' },
          { name: '是否想要孩子', value: '不限',showVip: false, filed: 'child_status', selectList: 'checkName2' },
          // { name: '实名认证', value: '不限',showVip: false, filed: 'min_salary6', selectList: 'checkName'},
          // { name: '视频认证', value: '不限',showVip: false, filed: 'min_salary7', selectList: 'checkVideo' },
          
      ],
     actionSheet: actionSheet,
      vipActionSheet: vipActionSheet,
      areaList: areaList,
      searchList: [],
      ary: {},
      index: 0,
      ageForm: {},
      heightForm : {},
      area: [],
      session: {}
    }
  },
  created() {
    this.session = JSON.parse(getSession())
    console.log('this.session ', this.session );

  },
  methods: {
    sureLogin(val) {
       if (this.activeName2 == '工作') {
         this.actions2[0].value = val
      } 
      this.nikeNameDialog = false
    },
    
   
    setWork(val) {
      this.actions2[0].value = val.work
      this.workeDialog = false
    },
    nikeSet(item, index) {
     
      item.show = true
    
    },
    setVip(item,index) {
       item.showVip = true
      if (this.session.isvip > 0) {
       item.showVip = true
      } else {
           this.$toast('请先成为会员');
      }
      
      
    },
    handleSearch() {
      this.searchList = []
     if (this.index == 1) {
       if (this.value) {
          getSearch({operate: 'getSearch', sid: this.value}).then(res => {
          console.log('userLiat', res);
          if (res.Code == 0) {
            this.searchList = res.Result ? JSON.parse(res.Result) : []
            if ( this.searchList.length > 0) {
              this.searchList.forEach(item => {
                  item.nickname = decodeURIComponent(item.nickname)
                  item.photo = decodeURIComponent(item.photo)
                  item.job_addr ? item.job_addr = (this.areaList.city_list[item.job_addr] || this.areaList.county_list[item.job_addr]) : ''
              })
            }
          } else {
            this.$toast(res.Msg);
          }
        })
       } else {
            this.$toast('请输入搜索内容');

       }
       
     } else {
        this.actions2.forEach(v => {
         if (v.value == '不限') {
          this.ary[v.filed] = -1
        } else {
          this.ary[v.filed] = v.code
        }
        
      })
      this.actions.forEach(v => {
         if (v.filed == 'sex' || v.filed == 'salary') {
          this.ary[v.filed] = v.code
        }
      })
      this.ary.family_status = this.ary.family_status ? this.ary.family_status : -1
      // this.ary.money_status = this.ary.money_status ? this.ary.money_status : -1
      this.ary.min_age = this.ary.min_age ? this.ary.min_age : -1
      this.ary.max_age = this.ary.max_age ? this.ary.max_age : -1
      this.ary.min_height = this.ary.min_height ? this.ary.min_height : -1
      this.ary.max_height = this.ary.max_height ? this.ary.max_height : -1
     this.ary.job_addr = this.area[1] ? this.area[1].code : -1
      console.log('this.ary', JSON.stringify(this.ary));
      preciseSearch({ operate: 'preciseSearch', ary: JSON.stringify(this.ary)}).then(res => {
        if (res.Code == 0) {
          this.searchList = res.Result ? JSON.parse(res.Result) : []
          if ( this.searchList.length > 0) {
             this.searchList.forEach(item => {
                item.nickname = decodeURIComponent(item.nickname)
                item.photo = decodeURIComponent(item.photo)
                item.job_addr ? item.job_addr = (this.areaList.city_list[item.job_addr] || this.areaList.county_list[item.job_addr]) : ''
             })
          }
        } else {
          this.$toast(res.Msg);
        }
      })
     }
      
    },
    doneSearch() {
      console.log(111);
    },
    getUserListByName() {
      getSearch({operate: 'getSearch', sid: this.value}).then(res => {
        console.log('userLiat', res);
      })
    },
    clearSearchOptions() {
      this.ary.min_age = -1
      this.ary.max_age = -1
      this.ary.min_height = -1
      this.ary.max_height = -1
      this.ary.job_addr = -1
      this.area = []
      if (this.index == 1) {
        this.value = null
      } else {
         this.actions.forEach(v => {
          v.value = '不限'
          v.code = -1
          })
        this.actions2.forEach(v => {
            v.value = '不限'
            v.code = -1
        })
      }
      
    },
    getIndex() {
      this.searchList = [] 
    },
    visiteMes(val) {
      this.$router.push({name: 'customer', params: { item: val}})
    },
    onSelect(item, val) {
      console.log(item);
      console.log(val);
      if (item.filed == 'age') {
        this.ary.min_age = val.min
        this.ary.max_age = val.max
      } else if (item.filed == 'height'){
        this.ary.min_height = val.min
        this.ary.max_height = val.max
      }
      item.value = val.name
      item.code = val.code
    },
    onSelectVip(item, val) {
    
      item.value = val.name
      item.code = val.code
    },
    sureArea(val, eve) {
     
      val.show = false
      val.value = ''
      this.area = eve
      eve.forEach(v => {
        val.value += v.name
      })
     
    },
    sureAreaVip(val, eve) {
      val.showVip = false
      val.value = ''
      eve.forEach(v => {
        val.value += v.name
      })
    },
    goHome() {
      this.$router.go(-1)
    }
  }
}
</script>

<style lang="scss" scoped>
    @import '../../style/mixin';
      html,body{
   
    background-color: #fff;
}
  .van-search {
    height: 2.1rem;
    margin-top: 0.5rem;
    overflow: hidden;
  }
  .van-search__content {
    padding-left: 0.5rem;
  }
  .search_input  .van-search__content .van-cell .van-field__left-icon {
    margin-top: 2rem !important;
  }
  .search {
    position: absolute;
    top: 1.2rem;
    left: 1rem;
   
  }
 
  .search img {
    position: absolute;
    @include ct;
    top: 58%;
    @include wh(1.1rem, 1.1rem);
  }
  .vip_user {
    display: inline-block;
    width: 150px;
    // @include wh(7rem, 1.2rem);
    font-size: 12px;
    color: #CEA476;
    font-family: PingFangSC-Regular, PingFang SC;
    font-weight: 400;
    text-align: center;
    line-height: 1.2rem; 
    border-radius: 4px;
    border: 1px solid #CEA476;
  }
  .link_content {
    padding: 0 0.9rem;
    margin-top: 0.5rem;
     background-color: #fff;
    border-top: 1px solid #E0E0E0; 
    font-family: PingFangSC-Semibold, PingFang SC;
  }
  .base_search {
    margin-top: 1.1rem;
  }
  .main_title {
    line-height: 1.1rem;
      @include sc(0.9rem,#262B40);
  }
  .main_title::before {
   content: '';
    
    display: inline-block;
    background: #FF807B;
    border-radius: 0.1rem;
    @include wh(0.3rem, 0.9rem);
  }
   .main_title span {
      font-weight: 600; 
     display: inline-block;
     padding-left: 0.3rem;
      @include wh(90%, 1.1rem);

     
   }
   .cell_class {
     
  font-family: PingFangSC-Regular, PingFang SC;
      @include sc(0.8rem,#262B40);

   }
   .valur_class {
      @include sc(0.8rem,#8C8C8C);
    font-family: PingFangSC-Regular, PingFang SC;
   }
 
   
   .box {
     background-color: #E0E0E0;
      @include wh(100%, 0.4rem);
     
   }
   .vip_content {
    padding: 0 0.9rem;
    padding-top: 0.9rem;
    background-color: #fff;
    font-family: PingFangSC-Semibold, PingFang SC;
    // margin-top: 1.1rem;
   }
   .van-button--primary {
     background-color: #ACAFBA;
     border: 1px solid #ACAFBA;
   }
   .van-button {
      @include wh(100%, 3rem);

   }
   .mainBtn {
      background-color:#404868;
     border: 1px solid #404868;
   }
   .van-button__text {
      @include sc(0.8rem,#FFFFFF);
     
   }

   .main_head {
      position: relative;
        @include wh(100%, 11rem);
        font-family: PingFangSC-Semibold, PingFang SC;
        
    }
    .main_head img {
        @include wh(100%, 100%);

    }
    .content_show {
    position: relative;
    height: 5rem;
    font-family: PingFangSC-Regular, PingFang SC;
  }
  .avator_content {
   
    @include wh(4rem, 4rem);
    border-radius: 50%;
    margin-right: 0.5rem;
    background-color: #f2f3f5;
    overflow: hidden;
  }

  .avator_content img {
    @include wh(100%, 100%);

  }
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
   position: relative;
    @include sc(0.6rem,#505050);
    font-weight: 400;
    margin-top: 1.4rem;
    margin-left: 4.5rem;
    width: 5rem;
  }
   .time::after {
      content: '';
    @include wh(0.7rem, 0.5rem);
    
    position: absolute;
    top:0.2rem ;
    background: url('../../assets/icon_more_small_black.png') no-repeat center;
    background-size: cover;
   }
     .van-tabs__nav {
      width: 14rem !important;
      margin-left: 4rem !important;
    }
  
</style>