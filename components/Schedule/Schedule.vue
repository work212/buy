<template>
  <div id="scheduleBox">
    <schedule-tab v-bind:type="type" v-bind:id="$route.params.id"></schedule-tab>
    <button v-on:click="next(-1, 'month')" class="mark_button">&lt;</button>
    {{ target.year }}/{{ target.month }}
    <button v-on:click="next(1, 'month')" class="mark_button">&gt;</button>
    <div v-on:click="today()" class="now">[Now]</div>

    <span v-on:click="modalNew()" class="add_button_box">
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
        カテゴリ
        <select id="search_category" v-model="search_category" class="search_select">
          <option value="">全て</option>
          <option v-for="tag in category_list" v-bind:value="tag.schedule_category_id">
            {{ tag.name }}
          </option>
        </select>
        フリーワード<input type="text" id="search_detail" v-model="search_detail" class="search_input">
      </div>
    <div class="search_disp">
      表示方法　
<a href="./index.html#/schedule/1" :class="{'active': $route.params.id ==1}"><img src="./assets/img/list.png"></a>
<a href="./index.html#/schedule/2" :class="{'active': $route.params.id ==2}"><img src="./assets/img/dialy.png"></a>
<a href="./index.html#/schedule/3" :class="{'active': $route.params.id ==3}"><img src="./assets/img/img.png"></a>
<a href="./index.html#/schedule/4" :class="{'active': $route.params.id ==4}"><img src="./assets/img/calender.png"></a>
    </div>
      

    </div>

    <div id="list_area">
      <schedule-list v-if="$route.params.id == 1" v-bind:disp_list="disp_list" v-on:childs-event-modal="modalEdit"
        v-on:childs-event-del="del"></schedule-list>
      <schedule-dialy v-if="$route.params.id == 2" v-bind:disp_list="disp_list" v-on:childs-event-modal="modalEdit"
        v-on:childs-event-del="del"></schedule-dialy>
      <schedule-album v-if="$route.params.id == 3" v-bind:disp_list="disp_list" v-on:childs-event-modal="modalEdit"
        v-on:childs-event-del="del"></schedule-album>
      <schedule-calender v-if="$route.params.id == 4" v-bind:disp_list="disp_list" v-on:childs-event-modal="modalEdit"
        v-on:childs-event-del="del"></schedule-calender>
    </div>

    <!-- モーダル本体 -->
    <div class="modal js-modal">
      <div class="modal-container">
        <div class="modal-close js-modal-close" v-on:click="close()">×</div>
        <input type="hidden" id="update_id">
        <div class="modal-content">
          <table>
            <tr>
              <th>日付</th>
              <td><input type="date" id="date" class="modal_input" v-model="add_date"></td>
            </tr>

            <tr>
              <th>カテゴリ</th>
              <td><select id="add_category" v-model="add_category" class="modal_select">
                  <option v-for="tag in category_list" v-bind:value="tag.schedule_category_id">
                    {{ tag.name }}
                  </option>
                </select></td>
            </tr>
            <tr>
              <th>タイトル</th>
              <td><input type="" id="title" value="" class="modal_input" v-model="add_title"></td>
            </tr>
            <tr>
              <th>会場</th>
              <td><select id="add_spot" v-model="add_spot" class="modal_select">
                  <option v-for="tag in spot_list" v-bind:value="tag.spot_id">
                    {{ tag.name }}
                  </option>
                </select></td>
            </tr>

            <tr>
              <th>ステータス</th>
              <td><select id="add_status" v-model="add_status" class="modal_select">
                  <option v-for="tag in status_list" v-bind:value="tag.schedule_status_id">
                    {{ tag.name }}
                  </option>
                </select></td>
            </tr>
            <tr>
              <th>詳細</th>
              <td><textarea class="modal_textarea" id="detail" v-model="add_detail"></textarea></td>
            </tr>
            <tr>
              <th>日記</th>
              <td><textarea class="modal_textarea" id="dialy" c-model="add_dialy"></textarea></td>
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

<style scoped>
.search_disp img{
width: 20px;
}
</style>

<script>
module.exports = {
  data: function () {
    return {
      type: 'schedule',
      list: [],
      disp_list: [],
      target: {
        'year': "",
        'month': ""
      },
      spot_list: [],
      category_list: [],
      status_list: [],
      add_schedule_data_id: "",
      add_title:"",
      add_detail: "",
      add_diay: "",
      add_category: "",
      add_status: "",
      add_spot: "",
      add_date: "",
      search_category: "",
      search_detail: ""
    }
  },
  filters: {
    omittedText20(text) {
      // 20文字目以降は"…"
      return text.length > 20 ? text.slice(0, 10) + "…" : text;
    }
  },
  components: {
    'schedule-tab': httpVueLoader('./ScheduleTab.vue'),
    'schedule-list': httpVueLoader('./ScheduleList.vue'),
    'schedule-dialy': httpVueLoader('./ScheduleDialy.vue'),
    'schedule-album': httpVueLoader('./ScheduleAlbum.vue'),
    'schedule-calender': httpVueLoader('./ScheduleCalender.vue')
  },
  beforeMount: function () {

    if ($cookies.isKey(this.type)) {
      this.target = this.$cookies.get(this.type);
    }

    if (!this.target.year || !this.target.month) {
      let date = new Date();
      this.target.year = date.getFullYear()
      this.target.month = ('0' + Number(date.getMonth() + 1)).slice(-2);
    }
    this.target.last_login = new Date();
    this.$cookies.set(this.type, this.target);

    this.getCategory();
    this.getItem();

  },
  methods: {
    getItem() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      params.append('target_month', this.target.year + '-' + this.target.month);
      axios.post("./php/db_schedule_data.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            this.list = response.data
            this.disp_list = this.list
          }
        })
    },
    next(type, type2) {
      var nextDate = new Date(this.target.year, this.target.month - 1, "01");
      if (type2 == "year") nextDate.setYear(nextDate.getFullYear() + type);
      if (type2 == "month") nextDate.setMonth(nextDate.getMonth() + type);
      this.target.year = nextDate.getFullYear()
      this.target.month = ('0' + Number(nextDate.getMonth() + 1)).slice(-2);
      this.$cookies.set(this.type, this.target);
      this.getItem();
    },
    getSpot() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_spot.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            this.spot_list = response.data;
          }
        })
    },
    getCategory() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_schedule_category.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            this.category_list = response.data;
          }
        })
    },
    getStatus() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_schedule_status.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            this.status_list = response.data;
          }
        })
    },
    modalNew: function () {
      this.getSpot();
      this.getCategory();
      this.getStatus();
      this.add_schedule_data_id= "";
      this.add_title = ""
      this.add_detail = ""
      this.add_dialy= ""
      this.add_category = ""
      this.add_status = ""
      this.add_spot = ""
      this.add_date = ""
      $('.js-modal').addClass('is-active');
    },
    modalEdit: function (item) {
      this.getSpot();
      this.getCategory();
      this.getStatus();
      this.add_schedule_data_id= item.schedule_data_id;
      this.add_title = item.title
      this.add_detail = item.detail
      this.add_dialy= item.dialy
      this.add_category = item.schedule_category_id
      this.add_status = item.schedule_status_id
      this.add_spot = item.spot_id
      this.add_date = item.date
      $('.js-modal').addClass('is-active');
    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
    add: function () {

      let params = new URLSearchParams();
      if (this.add_schedule_data_id) {
        params.append('type', 'update');
        params.append('schedule_data_id', this.add_schedule_data_id);
      } else {
        params.append('type', 'insert');
      }

      params.append('title',  this.add_title);
      params.append('detail',this.add_detail);
      params.append('dialy', this.add_dialy);
      params.append('schedule_category_id', this.add_category);
      params.append('schedule_status_id',this.add_status);
      params.append('spot_id', this.add_spot );
      params.append('date', this.add_date);
      axios.post("./php/db_schedule_data.php", params)
        .then(response => {
          $('.js-modal').removeClass('is-active');
          this.getItem()
        })

    },
    del(id) {
      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('schedule_data_id', id);
      axios.post("./php/db_schedule_data.php", params)
        .then(response => {
          this.getItem()
        })
    }

  },

  watch: {
    search_category: function () {
      this.disp_list = this.list.filter(function (item) {
        if (item.schedule_category_id == $('#search_category').val() || $('#search_category').val() == "") {
          return item;
        }
      });
    },
    search_detail: function () {
      this.disp_list = this.list.filter(function (item) {
        if (item.name.indexOf($('#search_detail').val()) >= 0 ||
          item.title.indexOf($('#search_detail').val()) >= 0 ||
          item.detail.indexOf($('#search_detail').val()) >= 0 || $('#search_detail').val() == "") {
          return item;
        }
      });
    }
  }
}
</script>
