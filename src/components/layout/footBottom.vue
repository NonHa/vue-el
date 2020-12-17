<template>
 <van-tabbar v-show="show" v-model="active" class="active_tab">
    <van-tabbar-item
            v-for="(item,index) in tabbars"
            :key="index"
            @click="tab(index,item.name)"
    >
      <span :class="currIndex == index ? active:''">{{item.title}}</span>
      <template slot="icon" slot-scope="props">
        <img :src="props.active ? item.active : item.normal">
      </template>
    </van-tabbar-item>
  </van-tabbar>
  
</template>

<script>
export default {
  name: 'foot',
  watch: {
    $route(to,from) {
      if (to.path == '/home') {
        this.currIndex = 0
        this.show = true
      } else if (to.path == '/active') {
        this.currIndex = 1
        this.show = true
      }else if (to.path == '/message') {
        this.currIndex = 2
        this.show = true
      }else if (to.path == '/mine') {
        this.currIndex = 3
        this.show = true
      } else {
        this.show = false
      }
      console.log('footTo', to);
    }
  },
  data() {
    return {
      active: 0,
      show: true,
      tabbars: [
          {
            name: "/",
            title: "首页",
            normal: require("../../assets/icon_home.png"),
            active: require("../../assets/icon_home_select.png")
          },
          {
            name: "active",
            title: "活动",
            normal: require("../../assets/icon_activity.png"),
            active: require("../../assets/icon_activity_select.png")
          },
           {
            name: "message",
            title: "消息",
            normal: require("../../assets/icon_news.png"),
            active: require("../../assets/icon_news_select.png")
          },
           {
            name: "mine",
            title: "我的",
            normal: require("../../assets/icon_mine.png"),
            active: require("../../assets/icon_mine_select.png")
          }
        ],
        currIndex: 0
        
    }
  },
  created() {
    let to = this.$route
     if (to.path == '/home') {
        this.currIndex = 0
        this.show = true
      } else if (to.path == '/active') {
        this.currIndex = 1
        this.show = true
      }else if (to.path == '/message') {
        this.currIndex = 2
        this.show = true
      }else if (to.path == '/mine') {
        this.currIndex = 3
        this.show = true
      } else {
        this.show = false
      }
    
  },
  methods: {
    tab(index, val) {
        this.currIndex = index;
        this.$router.push(val);
      }
  },
  
}
</script>



<style lang="scss" scoped>
// fix css style bug in open el-dialog
.el-popup-parent--hidden {
  .fixed-header {
   // padding-right: 15px;
  }
}
.van-tabbar {
  z-index: 50;
}
</style>
