<template>
  <div id="scheduleBox">
    <schedule-tab v-bind:type="type"></schedule-tab>
    <div class="list_title">カテゴリー</div>
    <span v-on:click="modal()" class="add_button_box">
      <img src="./assets/img/add.png" class="add_button">追加</span>
  

    <div id="list_area">
    <table class="list_table_min">
      <tr v-for="item, index in disp_list" :key="index">
        <td class="edit_box" v-on:click="modal2(item)">
          <img src="./assets/img/edit.png" class="list_edit">
        </td>
        <td class="name_box">{{ item.name }}</td>
        <td v-on:click="del(item.schedule_category_id)" class="del_box">
          <img src="./assets/img/del_gray.png" class="list_del"></td>
      </tr>
    </table>
  </div>

    <!-- モーダル本体 -->
    <div class="modal js-modal">
      <div class="modal-container">
        <div class="modal-close js-modal-close" v-on:click="close()">×</div>
        <div class="modal-content">
          <table>
            <tr>
              <th>名前</th>
              <td><input type="text" id="name" class="modal_input" v-model="add_name"></td>
            </tr>
          </table>
          <div class="button">
          <button v-on:click="add()" class="modal_button">追加</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>
.list_table_min{
max-width:400px;
}
.modal-container{
  width: 300px;
}
.modal-content th{
  width: 60px;
}
</style>

<script>
module.exports = {
  data: function () {
    return {
      type: 'schedule_category',
      list: [],
      disp_list: [],
      search:"",
      add_schedule_category_id:"",
      add_name:""
    }
  },

  components: {
    'schedule-tab': httpVueLoader('./ScheduleTab.vue')
  },
  beforeMount: function () {
    this.getItem();
  },
  methods: {
    getItem() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_schedule_category.php", params)
        .then(response => {
          if(response.data && response.data != "error"){
            this.list = response.data
            this.disp_list = this.list
          }
        })
    },
    modal: function () {
      this.add_schedule_category_id = ""
      this.add_name = ""
      $('.js-modal').addClass('is-active');
    },
    modal2: function (item) {
      console.log(item)
      this.add_schedule_category_id = item.schedule_category_id
      this.add_name = item.name
      $('.js-modal').addClass('is-active');
    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
    add: function () {

      let params = new URLSearchParams();
      if (this.add_schedule_category_id) {
        params.append('type', 'update');
        params.append('schedule_category_id', this.add_schedule_category_id);
      } else {
        params.append('type', 'insert');
      }

      params.append('name', this.add_name);

      axios.post("./php/db_schedule_category.php", params)
        .then(response => {
          $('.js-modal').removeClass('is-active');
          this.getItem()
        })

    },
    del(id) {
      console.log(id)
      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('schedule_category_id', id);
      axios.post("./php/db_schedule_category.php", params)
        .then(response => {
          console.log(response)
          this.getItem()
        })
    },
    sort(type) {
      if (type == 'desk') {
        var sort_type = -1
        var sort_type2 = 1
      } else {
        var sort_type = 1
        var sort_type2 = -1
      }
      this.list.sort(function (a, b) {
        if (Number(a.capa) < Number(b.capa)) return sort_type;
        if (Number(a.capa) > Number(b.capa)) return sort_type2;
        return 0;
      });
    }

  },


}
</script>
