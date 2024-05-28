<template>
  <div id="todoBox">
    <todo-tab v-bind:type="type"></todo-tab>
    <div class="list_title">TODO</div>
    <span v-on:click="modal()" class="add_button_box">
      <img src="./assets/img/add.png" class="add_button">追加</span>



    <div id="list_area">
      <div v-for="rating in ratings" class="list_box">
        <div v-if="rating == 1" class="goal_int_title">【日】</div>
        <div v-if="rating == 2" class="goal_int_title">【週】</div>
        <div v-if="rating == 3" class="goal_int_title">【月】</div>

        <table class="base_list">
          <tr>
            <th></th>
            <th>名前</th>
            <th>ゴール</th>
            <th>詳細</th>
            <th></th>
          </tr>
          <tr class="th" v-for="item, index in todoitems[rating]" :key="index">
            <td v-on:click="modal2(item)" class="edit_box">
              <img src="./assets/img/edit.png" class="list_edit">
            </td>
            <td>{{ item.name }}</td>
            <td>{{ item.goal_name }}</td>
            <td>{{ item.detail }}</td>
            <td v-on:click="del(item.todo_id)" class="del_box">
              <img src="./assets/img/del_gray.png" class="list_del">
            </td>

          </tr>
        </table>
      </div>
    </div>
    <div id="memoBox">
      <div class="menuMemo">
        <h2 class="base_title">メモ</h2>
        <textarea id="memo" class="textlines" v-model="memo"></textarea>
      </div>
    </div>

    <!-- モーダル本体 -->
    <div class="modal js-modal">
      <div class="modal-container">
        <div class="modal-close js-modal-close" v-on:click="close()">×</div>
        <div class="modal-content">
          <table>
            <tr>

              <th>名前</th>
              <td><input type="text" id="todo" class="modal_input" v-model="add_name"></td>
            </tr>
            <tr>
              <th>ゴール</th>
              <td><select id="" v-model="add_goal_id" class="modal_select">
                  <option v-for="tag in goal_list" v-bind:value="tag.goal_id">
                    {{ tag.name }}
                  </option>
                </select>
              </td>
            </tr>
            <tr>
              <th>間隔</th>
              <td><select id="" v-model="add_interval_id" class="modal_select">
                  <option v-for="tag in interval_list" v-bind:value="tag.todo_interval_id">
                    {{ tag.name }}
                  </option>
                </select>
              </td>
            </tr>
            <tr>
              <th>詳細</th>
              <td><textarea id="detail" class="modal_textarea" v-model="add_detail"></textarea>
              </td>
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
.list_box {
  margin-top: 20px;
}

.goal_int_title {
  font-weight: bold;
  ;
}
</style>


<script>
module.exports = {
  data: function () {
    return {
      type: 'goal_todo',
      memo: '',
      todoitems: { 1: [], 2: [], 3: [] },
      ratings: [1, 2, 3],
      goal_list: [],
      interval_list: [],
      add_todo_id: "",
      add_name: "",
      add_goal_id: "",
      add_interval_id: "",
      add_detail: ""
    }
  },
  components: {
    'todo-tab': httpVueLoader('./GoalTab.vue')
  },
  beforeMount: function () {
    this.getItem();

    axios.get("./php/memo.php?type=" + this.type)
      .then(response => {
        this.memo = response.data
      })
  },
  methods: {
    getItem() {
      //タスク
      const getTask = async (getItem) => {
        let params = new URLSearchParams();
        params.append('type', 'select');
        params.append('todo_interval_id', getItem);
        return await axios.post("./php/db_todo.php", params)
      }

      this.ratings.forEach(async (rating) => {
        getTask(rating) // 成功する
          .then((response) => {
            if (response.data && response.data != "error") {
              this.todoitems[rating] = response.data;
            }
          })
      })
    },

    getGoal() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_goal.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            this.goal_list = response.data;
          }
        })
    },
    getInterval() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_todo_interval.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            this.interval_list = response.data;
          }
        })
    },

    modal: function () {
      this.getGoal();
      this.getInterval();
      this.add_todo_id = ""
      this.add_name = ""
      this.add_detail = ""
      this.add_goal_id = ""
      this.add_interval = ""
      $('.js-modal').addClass('is-active');
    },
    modal2: function (item) {
      this.getGoal();
      this.getInterval();
      this.add_todo_id = item.todo_id;
      this.add_name = item.name
      this.add_detail = item.detail
      this.add_goal_id = item.goal_id
      this.add_interval_id = item.todo_interval_id
      $('.js-modal').addClass('is-active');
    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
    add: function () {
      let params = new URLSearchParams();
      if (this.add_todo_id) {
        params.append('type', 'update');
        params.append('todo_id', this.add_todo_id);
      } else {
        params.append('type', 'insert');
      }

      params.append('name', this.add_name);
      params.append('detail',this.add_detail);
      params.append('goal_id', this.add_goal_id);
      params.append('todo_interval_id', this.add_interval_id);
      axios.post("./php/db_todo.php", params)
        .then(response => {
          console.log(response)
          $('.js-modal').removeClass('is-active');
          this.getItem()
        })

    },
    del(todo_id) {
      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('todo_id', todo_id);
      axios.post("./php/db_todo.php", params)
        .then(response => {
          this.getItem()
        })

    }

  },

  computed: {
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
