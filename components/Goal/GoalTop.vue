<template>
  <div id="todoBox">
    <todo-tab v-bind:type="type"></todo-tab>
    {{ target.year }}/{{ target.month }}/{{ target.day }}
    <div class="now" v-on:click="today()">[TODAY]</div>


    <div id="goal_area">
      <div id="goal_left">

        <div id="todo_area">
          <div class="goal_title">TODO</div>
          <div>
            <div id="todo_left">
              <div class="table_title">
                <button v-on:click="next(-1, 'day')" class="mark_button">&lt;</button>日
                <button v-on:click="next(1, 'day')" class="mark_button">&gt;</button>
              </div>
              <ul class="todo_main">
                <li v-for="item, index in todoitems[1]" :key="index">

                  <div class="boxes">
                    <input type="checkbox" v-bind:id="['box-' + item.todo_id]" v-model="checked[1][item.todo_id]"
                      v-on:click="doChange(item.todo_id, checked[1][item.todo_id])">
                    <label v-bind:for="['box-' + item.todo_id]">{{ item.name }}
                      <span class="category_box">{{ item.goal_name }}</span>
                    </label>
                  </div>

                </li>
              </ul>
            </div>
          </div>
          <div id="todo_right">
            <div>
              <div class="table_title">
                <button v-on:click="next(-7, 'day')" class="mark_button">&lt;</button>週
                <button v-on:click="next(7, 'day')" class="mark_button">&gt;</button>
              </div>

              <ul class="todo_main">
                <li v-for="item, index in todoitems[2]" :key="index">
                  <div class="boxes">
                    <input type="checkbox" v-bind:id="['box-' + item.todo_id]" v-model="checked[2][item.todo_id]"
                      v-on:click="doChange(item.todo_id, checked[2][item.todo_id])">
                    <label v-bind:for="['box-' + item.todo_id]">{{ item.name }}
                      <span class="category_box">{{ item.goal_name }}</span>
                    </label>
                  </div>
                </li>
              </ul>
              <div class="table_title">
                <button v-on:click="next(-1, 'month')" class="mark_button">&lt;</button>月
                <button v-on:click="next(1, 'month')" class="mark_button">&gt;</button>
              </div>
              <ul class="todo_main">
                <li v-for="item, index in todoitems[3]" :key="index">
                  <div class="boxes">
                    <input type="checkbox" v-bind:id="['box-' + item.todo_id]" v-model="checked[3][item.todo_id]"
                      v-on:click="doChange(item.todo_id, checked[3][item.todo_id])">
                    <label v-bind:for="['box-' + item.todo_id]">{{ item.name }}
                      <span class="category_box">{{ item.goal_name }}</span>
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div id="task_area">
          <div class="goal_title">タスク</div>
          <table class="task_table">
            <tr class="table_title">
              <th>タスク名</th>
              <th>目標</th>
              <th>カテゴリ</th>
              <th>期間</th>
              <th>完了日</th>
              <th class="status">ステータス</th>
            </tr>
            <tr v-for="item, index in task_data" :key="index">
              <td>{{ item.name }} </td>
              <td>{{ item.goal }}</td>
              <td>{{ item.task_category }}</td>
              <td>{{ item.start_date }} ～ {{ item.end_date }}</td>
              <td>{{ item.comp_date }}</td>
              <td class="center">
                <select name="tag" v-model="task_data[index].task_status_id" @change="doChangeTask(index, item)"
                  class="list_select">
                  <option v-for="tag in status_list" v-bind:value="tag.task_status_id">
                    {{ tag.name }}
                  </option>
                </select>
              </td>
            </tr>
          </table>
        </div>

      </div>
      <div id="goal_right">

        <div class="goal_title">リスト</div>
        <ul class="">
          <li v-for="item, index in list_data" :key="index">
            <div class="table_title">{{ index }}</div>
            <ul>
              <li v-for="item2, index2 in list_data[index]" :key="index2">
                <div class="boxes">
                  <input type="checkbox" v-bind:id="['list-' + item2.list_id]"
                    v-model="list_data[index][index2].list_date" v-on:click="doChangeList(item2)">

                  <label v-bind:for="['list-' + item2.list_id]"> {{ item2.name }}
                  </label>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </div>





    <div class="menuMemo">
      <h2 class="base_title">メモ</h2>
      <textarea id="memo" class="textlines" v-model="memo"></textarea>
    </div>

    <!-- モーダル本体 -->
    <!--div class="modal js-modal">
      <div class="modal-container">
        <div class="modal-close js-modal-close" v-on:click="close()">×</div>
        <div class="modal-content">
          <table>
            <tr>
              <th>名前</th>
              <td><input type="" id="add" value=""></td>
            </tr>

            <tr>
              <th></th>
              <td>{{ category_list }}<select name="tag" v-model="add_category">
                  <option v-for="tag in category_list" v-bind:value="tag.todo_category_id">
                    {{ tag.name }}
                  </option>
                </select></td>
            </tr>

          </table>
          <div class="button"></div>
          <button v-on:click="add()" class="modal_button">追加</button>
          </div>
        </div>
      </div>
    </div-->



  </div>

</template>

<style scoped>
#goal_area {
  overflow: hidden;
  width: 100%;
}

#goal_left {
  float: left;
  overflow: hidden;
  width: 68%;
  margin-right: 2%;
}

#goal_right {
  float: left;
  width: 30%;
}

#todo_area,
#task_area,
#goal_right {
  overflow: hidden;

  padding: 10px;
  border-radius: 6px;
  margin-top: 16px;

  border: 1px solid rgb(238, 137, 146);
}

#todo_left {
  width: 48%;
  margin-right: 4%;
}

#todo_right {
  width: 48%;
}

#todo_left,
#todo_right {
  float: left;
}



.goal_title {
  font-weight: bold;
  ;
  color: #333;

}

.goal_title img {
  height: 14px;
  width: 14px;
}

.table_title {
  margin: 10px 0 10px;
  padding: 2px 4px;
  color: #fff;
  background-color: #333;
  font-size: 14px;
  font-weight: bold;
  /* border-radius: 4px; */
  ;
}

.table_title th {
  padding: 2px 4px;
}

.task_table {
  width: 100%;
  margin-bottom: 10px;
}

.todo_main li,
td,
#goal_right ul li ul li {
  padding: 2px 4px;
  background-color: #fff;
  border-bottom: 1px dashed rgb(238, 137, 146);
  color: rgb(238, 137, 146);
  font-size: 14px;
  margin-top: 10px;
}

.todo_main li:last-child,
td:last-child,
#goal_right ul li ul li:last-child {
  /* border:none; */

}


td {
  font-size: 11px;
  font-weight: 100;
  ;
}

.category_box {
  background-color: #ccc;
  border-radius: 4px;
  font-size: 10px;
  color: #fff;
  font-weight: bold;
  display: inline-block;
  padding: 2px 4px;
}




/*Checkboxes styles*/
input[type="checkbox"] {
  display: none;
}

input[type="checkbox"]+label {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 20px;
  color: #333;
  cursor: pointer;
}

input[type="checkbox"]+label:last-child {
  margin-bottom: 0;
}

input[type="checkbox"]+label:before {
  content: '';
  display: block;
  width: 14px;
  height: 14px;
  border: 2px solid #999;
  border-radius: 2px;
  ;
  position: absolute;
  left: 0;
  top: 2px;
  opacity: .6;
  -webkit-transition: all .12s, border-color .08s;
  transition: all .12s, border-color .08s;
}

input[type="checkbox"]:checked+label:before {
  border: 2px solid #333;
  width: 6px;
  top: -3px;
  left: 5px;
  border-radius: 0;
  opacity: 1;
  border-top-color: transparent;
  border-left-color: transparent;
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}

.status {
  width: 90px;
}

.center {
  text-align: center;

}

.list_select {
  font-size: 12px;
}


</style>

<script>
module.exports = {
  data: function () {
    return {
      memo: '',
      todoitems: { 1: [], 2: [], 3: [] },
      type: 'goal_top',
      target: {
        'year': "",
        'month': "",
        'day': "",
        'ymd': "",
        'last_login': ""
      },
      ratings: [1, 2, 3],
      checked: [],
      add_interval_id: "",
      category_list: [],
      task_data: [],
      list_data: [],
      add_category: "",
      task_status_id: [],
      status_list: []
    }
  },
  components: {
    'todo-tab': httpVueLoader('./GoalTab.vue')
  },
  beforeMount: function () {

    if ($cookies.isKey(this.type)) {
      this.target = this.$cookies.get(this.type);
    }

    if (!this.target.year || !this.target.month || !this.target.day) {
      let date = new Date();
      this.target.year = date.getFullYear()
      this.target.month = ('0' + Number(date.getMonth() + 1)).slice(-2);
      this.target.day = date.getDate()
      this.target.ymd = date.toLocaleDateString('sv-SE')
    }
    this.target.last_login = new Date();
    this.$cookies.set(this.type, this.target);
    this.getStatusList();
    this.getItem();

    this.getList();
    this.getTask();

  },
  methods: {
    getStatusList() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_task_status.php", params)
        .then(response => {
          console.log("!!!")
          console.log(response)
          if (response.data && response.data != "error") {

            this.status_list = response.data;
          }
        })
    },
    getList() {
      let params = new URLSearchParams();
      params.append('type', 'select_type');
      axios.post("./php/db_list.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            //console.log(response)
            this.list_data = response.data;
          }
        })
    },
    getTask() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      date = this.target.year + "-" + this.target.month + "-" + this.target.day
      params.append('date', date);
      axios.post("./php/db_task.php", params)
        .then(response => {
          //console.log("!!!")
          //console.log(response)
          if (response.data && response.data != "error") {

            this.task_data = response.data;
          }
        })
    },
    getItem() {
      axios.get("./php/memo.php?type=" + this.type)
        .then(response => {
          if (response.data && response.data != "error") {
            this.memo = response.data
          }
        })

      //タスク
      const getTask = async (getItem) => {
        let params = new URLSearchParams();
        params.append('type', 'select');
        params.append('todo_interval_id', getItem);
        return await axios.post("./php/db_todo.php", params)
      };

      //タスクデータ
      const getTaskData = async (getItem) => {
        var start_date = "";
        var end_date = "";
        let params = new URLSearchParams();
        params.append('type', 'select');
        params.append('todo_interval_id', getItem);

        let date = new Date(this.target.ymd);
        var keisan = 0;
        if (getItem == 1) {
          start_date = this.target.ymd
          end_date = this.target.ymd
          //1週間
        } else if (getItem == 2) {
          var dayOfWeek = date.getDay()
          if (dayOfWeek == 0) {
            keisan = 6
          } else {
            keisan = dayOfWeek - 1
          }
          date.setDate(date.getDate() - keisan);
          start_date = date.getFullYear() + "-" + ('0' + Number(date.getMonth() + 1)).slice(-2) + "-" + ('0' + Number(date.getDate())).slice(-2)
          let date2 = new Date(this.target.ymd);
          date2.setDate(date2.getDate() + (6 - keisan));
          end_date = date2.getFullYear() + "-" + ('0' + Number(date2.getMonth() + 1)).slice(-2) + "-" + ('0' + Number(date2.getDate())).slice(-2)
          //月
        } else if (getItem == 3) {
          start_date = this.target.year + "-" + ('0' + Number(date.getMonth() + 1)).slice(-2) + "-" + "01"
          date.setMonth(date.getMonth() + 1, 0);
          end_date = date.getFullYear() + "-" + ('0' + Number(date.getMonth() + 1)).slice(-2) + "-" + ('0' + Number(date.getDate())).slice(-2)
        } else if (getItem == 4) {
          start_date = date.getFullYear() + "-01-01"
          end_date = date.getFullYear() + "-12-31"
        }
        //console.log(start_date);
        //console.log(end_date);
        params.append('start_date', start_date);
        params.append('end_date', end_date);
        return await axios.post("./php/db_todo_data.php", params)
      };

      this.ratings.forEach(async (rating) => {
        getTask(rating) // 成功する
          .then((response) => {
            if (response.data && response.data != "error") {
              var getItem = response.data;
              this.todoitems[rating] = getItem
            }
          })

        getTaskData(rating)
          .then((response) => {
            //console.log(response)
            if (response.data && response.data != "error") {
              this.checked[rating] = response.data;
            } else {
              this.checked[rating] = []
            }
          })

      })
    },
    today() {
      var todayDate = new Date();

      this.target.year = todayDate.getFullYear()
      this.target.month = todayDate.getMonth() + 1
      this.target.day = todayDate.getDate()
      this.target.ymd = todayDate.toLocaleDateString('sv-SE')

      this.$cookies.set(this.type, this.target);
      this.getItem();
    },
    next(type, type2) {
      var nextDate = new Date(this.target.year, this.target.month - 1, this.target.day);
      if (type2 == "year") nextDate.setYear(nextDate.getFullYear() + type);
      if (type2 == "month") nextDate.setMonth(nextDate.getMonth() + type);
      if (type2 == "day") nextDate.setDate(nextDate.getDate() + type);
      this.target.year = nextDate.getFullYear()
      this.target.month = ('0' + Number(nextDate.getMonth() + 1)).slice(-2);
      this.target.day = nextDate.getDate()
      this.target.ymd = nextDate.toLocaleDateString('sv-SE')
      this.$cookies.set(this.type, this.target);
      this.getItem();
    },
    doChange: function (newVal, getItem) {

      let params = new URLSearchParams();
      if (typeof getItem !== 'undefined') {
        params.append('type', 'delete');
        params.append('todo_data_id', getItem['todo_data_id']);
      } else {
        params.append('type', 'insert');
        params.append('todo_id', newVal);
        params.append('todo_data_date', this.target.ymd);
      }
      axios.post("./php/db_todo_data.php", params)
        .then(response => {
          console.log(response)
        })

    },
    doChangeList: function (item) {

      let params = new URLSearchParams();

      params.append('type', 'update_comp');
      if (item.list_date == null) {
        params.append('list_date', this.target.ymd);
      } else {
        params.append('list_date', "");
      }

      params.append('list_id', item.list_id);

      axios.post("./php/db_list.php", params)
        .then(response => {
          console.log(response)
        })

    },
    doChangeTask: function (index, item) {
      console.log(item)
      console.log(this.task_data[index].task_status_id)

      let params = new URLSearchParams();

      params.append('type', 'update_status');

      params.append('task_status_id', this.task_data[index].task_status_id);


      params.append('task_id', item.task_id);

      axios.post("./php/db_task.php", params)
        .then(response => {
          console.log(response)
        })

    },
    getCategoy() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_todo_category.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            this.category_list = response.data;
            console.log(this.category_list)
          }
        })

    },
    
    addCategory: function () {
      let params = new URLSearchParams();
      params.append('type', 'insert');
      params.append('name', $('#addCategory').val());
      axios.post("./php/db_todo_category.php", params)
        .then(response => {
          this.getItem()
        })

    },
    onChange(id, status) {
      let params = new URLSearchParams();
      params.append('type', 'update_status');
      params.append('task_id', id);
      params.append('task_status_id', status);
      axios.post("./php/db_task.php", params)
        .then(response => {
          $('.js-modal').removeClass('is-active');
          this.getItem()
        })
    }

  },

  watch: {
    memo: function (newVal) {
      let params = new URLSearchParams();
      params.append('input_val', newVal);
      params.append('type', this.type);
      axios.post("./php/memo.php", params)
        .then(response => {
        })
    }
  }
}
</script>
