<template>
  <div id="todoBox">
    <todo-tab v-bind:type="type"></todo-tab>
    <div class="list_title">タスク</div>
    <span v-on:click="modal()" class="add_button_box">
      <img src="./assets/img/add.png" class="add_button">追加</span>

    <div id="list_area">
      <table class="base_list">
        <tr>
          <th></th>
          <th>タスク</th>
          <th>カテゴリー</th>
          <th>ゴール</th>
          <th>開始日</th>
          <th>終了日</th>
          <th>ステータス</th>

          <th></th>
        </tr>
        <tr v-for="item, index in taskitems" :key="index">
          <td v-on:click="modal2(item)" class="edit_box">
            <img src="./assets/img/edit.png" class="list_edit">
          </td>
          <td>{{ item.name }} </td>
          <td> {{ item.task_category }}</td>
          <td>{{ item.goal }} </td>
          <td>{{ item.start_date }}</td>
          <td>{{ item.end_date }}</td>
          <td>{{ item.status }}</td>
          <td class="del_box" v-on:click="del(item.task_id)">
            <img src="./assets/img/del_gray.png" class="list_del">
          </td>
        </tr>
      </table>
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
              <td><input type="text" id="name" class="modal_input" v-model="add_name"></td>
            </tr>
            <tr>
              <th>カテゴリー</th>
              <td><select id="" v-model="add_category" class="modal_select">
                  <option v-for="tag in category_list" v-bind:value="tag.task_category_id">
                    {{ tag.name }}
                  </option>
                </select>
              </td>
            </tr>
            <tr>
              <th>目標</th>
              <td><select id="" v-model="add_goal" class="modal_select">
                  <option v-for="tag in goal_list" v-bind:value="tag.goal_id">
                    {{ tag.name }}
                  </option>
                </select>
              </td>
            </tr>
            <tr>
              <th>期間</th>
              <td><input type="date" id="start_date" class="modal_dete">
                <input type="date" id="end_date" class="modal_dete">
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

</style>


<script>
module.exports = {
  data: function () {
    return {
      type: 'goal_task',
      memo: '',
      taskitems: [],
      ratings: [1, 2, 3, 4, 5],
      goal_list: [],
      category_list: [],
      add_task_id:"",
      add_name:"",
      add_start_date:"",
      add_end_date:"",
      add_category: "",
      add_goal: ""
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
      this.additems = []
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_task.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            console.log(response)
            this.taskitems = response.data
          }
        })
    },

    getCategory() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_task_category.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            console.log(response)
            this.category_list = response.data;
          }
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

    modal: function () {
      console.log("!!!")
      this.getCategory();
      this.getGoal();
      this.add_task_id = ""
      this.add_name = ""
      this.add_start_date = ""
      this.add_end_date = ""
      this.add_category = ""
      this.add_goal = ""
      $('.js-modal').addClass('is-active');
    },
    modal2: function (item) {
      this.getCategory();
      this.getGoal();
      this.add_task_id = item.task_id
      this.add_name = item.name
      this.add_start_date = item.start_date
      this.add_end_date = item.end_date
      this.add_category = item.task_category_id
      this.add_goal = item.goal_id
      $('.js-modal').addClass('is-active');
    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
    add: function () {
      let params = new URLSearchParams();
      if (this.add_task_id ) {
        params.append('type', 'update');
        params.append('task_id', this.add_task_id );
      } else {
        params.append('type', 'insert');
      }
      console.log("!!!")
      params.append('name', this.add_name);
      params.append('start_date', this.add_start_date);
      params.append('end_date', this.add_end_date);
      params.append('task_category_id', this.add_category);
      params.append('goal_id', this.add_goal);
      axios.post("./php/db_task.php", params)
        .then(response => {
          console.log(response);
          $('.js-modal').removeClass('is-active');
          this.getItem()
        })

    },
    del(task_id) {
      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('task_id', task_id);
      axios.post("./php/db_task.php", params)
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
