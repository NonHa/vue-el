<template>
  <div>
    <van-calendar
      :title="timeSet"
      :show-mark="false"
      color="#FFFFFF"
      :show-subtitle="false"
      :lazy-render="false"
      :poppable="false"
      row-height="3rem"
      
      :show-confirm="false"
      @confirm="confirm"
      @select="select"
      :formatter="formatter"
    />
    <van-action-sheet 
    class="sheet"
      v-model="show" 
      :actions="actions"
      @select="onSelect($event)"
      title="请选择见面时间"
      
       >
       
      </van-action-sheet>
    
  </div>
</template>

<script>
import moment from 'moment'

export default {
  data() {
    return {
      show: false,
      currentTime: '12: 00',
      data: '',
      topInfo: '',
      timeSet: '请选择邀约日期',
      actions: [
        {name: '08:30'},
        {name: '09:00'},
        {name: '09:30'},
        {name: '10:00'},
        {name: '10:30'},
        {name: '11:00'},
        {name: '11:30'},
        {name: '12:00'},
        {name: '12:30'},
        {name: '13:00'},
        {name: '13:30'},
        {name: '14:00'},
        {name: '14:30'},
        {name: '15:00'},
        {name: '15:30'},
        {name: '16:00'},
        {name: '16:30'},
        {name: '17:00'},
        {name: '17:30'},
        {name: '18:00'},
        {name: '18:30'},
        {name: '19:00'},
        {name: '19:30'},
        {name: '20:00'},
        {name: '20:30'},
        {name: '21:00'},
        {name: '21:30'},
        {name: '22:00'},
        {name: '22:30'},
       
      ]
    }
  },
  methods: {
    confirm(data) {
      this.show = true
      this.data = data
     
    },
    onSelect(item) {
      this.topInfo = item.name
      this.show = false;
      this.data =  moment(this.data).format('YYYY-MM-DD')
      this.show = false;
      this.timeSet = '邀约日期: ' + `${this.data} ${item.name}`
    
      this.$emit('confirm', `${this.data} ${item.name}`)
    },
    getconfirm(item) {
     

    },
    select(day) {
      this.topInfo = ''
      this.dayItem = day
      this.nowDay = moment(day).format('YYYY-MM-DD')
      console.log(this.nowDay);
      
    },
    formatter(day) {
    
      const date =  moment(day.date).format('YYYY-MM-DD')

       if (date === this.nowDay) {
          day.topInfo = this.topInfo;
         
        }
     

      return day;
    },
  }
}
</script>

<style lang="scss" scoped>
@import '../../style/mixin';

  .van-calendar__days {
    @include sc(1.1rem, #FF807B);

  }
  .sheet  {
    height: 20rem;
    border-radius: 0;
  }
 .sheet  .van-action-sheet__item {
   border-bottom: 1px solid #ccc;
 }
 
</style>