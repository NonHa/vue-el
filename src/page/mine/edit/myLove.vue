<template style="background-color: #fff">

  <div class="login_dialog name_dialog"  style="background-color: #fff">
    <div class="go_back_right">
          <img @click="goBackHome" src="../../../assets/icon_return_black.png" alt="">
         
        </div>
    <div class="head_title">
      我的爱好
    </div>
  <div class="link_content" >
      <div class="base_search">
        <div class="main_title">
          <span>喜欢的一道菜</span>
        </div>
        <van-field
          v-model="loveForm.hobby.hobby_food"
          rows="1"
          autosize
          class="field_padding"
          type="textarea"
          placeholder="填写最符合你口味的菜…"
        />
       </div>
      
    </div>
    <div class="link_content" >

     <div class="base_search">
        <div class="main_title">
          <span>喜欢的电影</span>
        </div>
        <van-field
          v-model="loveForm.hobby.hobby_film"
          rows="1"
          autosize
          class="field_padding"
          type="textarea"
          
          placeholder="填写最触动你的电影…"
        />
       </div>
      
    </div>
   <div class="link_content" >

     <div class="base_search">
        <div class="main_title">
          <span>喜欢的一首歌</span>
        </div>
        <van-field
          v-model="loveForm.hobby.hobby_song"
          rows="1"
          autosize
          class="field_padding"
          type="textarea"
          
          placeholder="填写最让你感动的歌…"
        />
       </div>
      
    </div>
     <div class="link_content" >

     <div class="base_search">
        <div class="main_title">
          <span>喜欢的一本书</span>
        </div>
        <van-field
          v-model="loveForm.hobby.hobby_book"
          rows="1"
          autosize
          class="field_padding"
          type="textarea"
          
          placeholder="填写让你印象深刻的书…"
        />
       </div>
      
    </div>
     <div class="link_content" >

     <div class="base_search">
        <div class="main_title">
          <span>最喜欢做的事</span>
        </div>
        <van-field
          v-model="loveForm.hobby.hobby_thing"
          rows="1"
          autosize
          class="field_padding"
          type="textarea"
          
          placeholder="旅行、看电影"
        />
       </div>
      
    </div>
    
    
    <van-button class="btn_color" type="primary" @click="addRealEduVerifySet">确定</van-button>
    
  </div>
</template>

<script>
import { 
  actionSheet, 
  vipActionSheet, 
  areaList 
  } from '../../components/actioneSheet'
import { getSession, setSession, setIdxCity } from '../../../utils/auth' // get token from cookie

import { doAddOrUpdateHobby, getHobby } from '../../../service/getData'
export default {
  data() {
    return {
      loveForm: {
        operate: 'doAddOrUpdateHobby',
        hobby: {
          hobby_food: '',
          hobby_film: '',
          hobby_song: '',
          hobby_book: '',
          hobby_thing: '',
        }
      },
      value: '',
      show: false,
      vipActionSheet: vipActionSheet,
      userId: null,
    }
  },
  created() {
    this.userId = this.$route.params.id
    this.session = setSession()
    this.getHobbyId()
  },
  methods: {
    addRealEduVerifySet() {
      this.loveForm.hobby = JSON.stringify(this.loveForm.hobby)
      console.log('this.loveForm.hobby', this.loveForm.hobby);
      doAddOrUpdateHobby(this.loveForm).then(res => {
        console.log('name', res);
        if (res.Code == 0) {
          console.log('resH', res);
           this.$toast(res.Msg);
           this.getHobbyId()
           
        }
      })
    },
    goBackHome() {
      this.$router.push({ name: 'mineEdit' })
    },
    getHobbyId() {
      if (this.userId) {
         getHobby({operate: 'getHobby', user_openid: this.userId}).then(res => {
        if (res.Code == 0) {
          var likeList = JSON.parse(JSON.stringify(JSON.parse(res.Result)))
          if (!(this.loveForm.hobby instanceof Object)) {
            this.loveForm.hobby = JSON.parse(this.loveForm.hobby)
          } 
          this.loveForm.hobby.hobby_food = likeList.hobby_food
            this.loveForm.hobby.hobby_film = likeList.hobby_film
            this.loveForm.hobby.hobby_song = likeList.hobby_song
            this.loveForm.hobby.hobby_thing = likeList.hobby_thing
            this.loveForm.hobby.hobby_book = likeList.hobby_book
          console.log('JSON.parse(res.Result)', likeList);
          
         
          console.log('this.loveForm', this.loveForm);
        }
      })
      }
     
    }
  }
}
</script>

<style lang="scss" scoped>
  .link_content {
     background-color: #fff;
     padding: 0 1rem;
     margin-top: 3rem;
   }
   .link_content, .base_search {
     border: 0;
    //  padding: 1rem;
   }
   .van-cell  {
     padding: 5px ;
     background-color: #F8F8F8;
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
  .btn_color {
    width: 20rem;
    margin: 0.6rem;
    border: 0;
  }
  .go_back_right {
    width: 1rem;
    height: 1rem;
    top: 0.8rem;
    left: 1.5rem;
  }
  .go_back_right img{
    height: 100%;
    width: 100%;
  }
</style>