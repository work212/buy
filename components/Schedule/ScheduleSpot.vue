<template>
  <div id="scheduleBox">
    <schedule-tab v-bind:type="type"></schedule-tab>
    <div class="list_title">会場</div>
    <span v-on:click="modal()" class="add_button_box">
      <img src="./assets/img/add.png" class="add_button">追加</span>

      <div id="serach_area">
      <div class="search_title">
        <div class="search_title_left">
          <img src="./assets/img/search.png" class="search_img">
          絞り込み
        </div>
        <div class="search_title_right">
          <img src="./assets/img/clear.png" class="clear_img">clear
        </div>
      </div>
      <div class="search_box">
      名前<input type="text" id="area_name" v-model="search" class="search_input">
    </div>
    </div>
    <div id="list_area">
    <table class="base_list">
      <tr>
        <th></th>
        <th>名前</th>
        <th>エリア</th>
        <th>キャパ <span v-on:click="sort('desk')">▼</span><span v-on:click="sort('ask')">▲</span></th>
        <th>メモ</th>
        <th></th>
      </tr>
      <tr v-for="item, index in disp_list" :key="index">
        <td v-on:click="modal2(item)" class="edit_box"><img src="./assets/img/edit.png" class="list_edit"></td>
        <td v-on:click="modal2(item)">{{ item.name }} </td>
        <td>{{ item.area }}</td>
        <td>{{ item.capa }}<span v-if="item.capa_stand">({{ item.capa_stand }})</span></td>
        <td>{{ item.memo }}</td>
        <td v-on:click="del(item.spot_id)" class="del_box"><img src="./assets/img/del_gray.png" class="list_del"></td>
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
            <tr>
              <th>エリア</th>
              <td><input type="text" id="area" value="" class="modal_input" v-model="add_area"></td>
            </tr>
            <tr>
              <th>キャパ</th>
              <td><input type="number" id="capa" value="" class="modal_input" v-model="add_capa"></td>
            </tr>
            <tr>
              <th>スタンディングキャパ</th>
              <td><input type="number" id="capa_stand" value="" class="modal_input" v-model="add_capa_stand"></td>
            </tr>
            <tr>
              <th>メモ</th>
              <td><textarea id="memo" class="modal_textarea" v-model="add_memo"></textarea></td>
            </tr>
          </table>
          <div class="button">
          <button class="modal_button" v-on:click="add()">追加</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped></style>

<script>
module.exports = {
  data: function () {
    return {
      type: 'schedule_spot',
      list: [],
      disp_list: [],
      search:"",
      add_spot_id:"",
      add_name:"",
      add_area:"",
      add_capa:"",
      add_capa_stand:"",
      add_memo:""
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
      axios.post("./php/db_spot.php", params)
        .then(response => {
          if(response.data && response.data != "error"){
            this.list = response.data
            this.disp_list = this.list
          }
        })
    },
    modal: function () {
      this.add_spot_id = ""
      this.add_name = ""
      this.add_area = ""
      this.add_capa = ""
     this.add_capa_stand = ""
      this.add_memo = ""
      $('.js-modal').addClass('is-active');
    },
    modal2: function (item) {
      this.add_spot_id = item.spot_id
      this.add_name = item.name
      this.add_area = item.area
      this.add_capa = item.capa
     this.add_capa_stand = item.capa_stand
      this.add_memo = item.memo
      $('.js-modal').addClass('is-active');
    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
    add: function () {

      let params = new URLSearchParams();
      if (this.add_spot_id) {
        params.append('type', 'update');
        params.append('spot_id', this.add_spot_id);
      } else {
        params.append('type', 'insert');
      }

      params.append('name',  this.add_name);
      params.append('area', this.add_area);
      params.append('capa',  this.add_capa);
      params.append('capa_stand', this.add_capa_stand);
      params.append('memo', this.add_memo);

      axios.post("./php/db_spot.php", params)
        .then(response => {
          $('.js-modal').removeClass('is-active');
          this.getItem()
        })

    },
    del(id) {
      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('spot_id', id);
      axios.post("./php/db_spot.php", params)
        .then(response => {
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

  watch: {
    search: function () {
      this.disp_list = this.list.filter(function (item) {
        if (item.name.indexOf($('#area_name').val()) >= 0 || $('#area_name').val() == "") {
          return item;
        }
      });
    }
  }
}
</script>
