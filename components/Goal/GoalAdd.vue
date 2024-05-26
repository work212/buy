<template>
  <div id="todoBox">
    <todo-tab v-bind:type="type"></todo-tab>
    <div class="list_title">
      ゴール
    </div>
    <span v-on:click="modal()" class="add_button_box"><img src="./assets/img/add.png" class="add_button">追加</span>




    <table class="list_table_min">
      <tr v-for="item, index in additems" :key="index">
        <td class="edit_box" v-on:click="modal2(item)">
          <img src="./assets/img/edit.png" class="list_edit">
        </td>
        <td class="name_box">{{ item.name }} </td>
        <td class="del_box" v-on:click="del(item.goal_id)">
          <img src="./assets/img/del_gray.png" class="list_del">
        </td>
      </tr>
    </table>

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
          <div class="button"></div>
          <button v-on:click="add()" class="modal_button">追加</button>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>
.list_table_min {
  max-width: 400px;
}
.modal-container {
  width: 300px;
}
.modal-container th {
  width: 60px;
}
</style>


<script>
module.exports = {
  data: function () {
    return {
      type: 'goal_add',
      additems: [],
      add_goal_id:"",
      add_name:""
    }
  },
  components: {
    'todo-tab': httpVueLoader('./GoalTab.vue')
  },
  beforeMount: function () {
    this.getItem();

  },
  methods: {
    getItem() {
      this.additems = []
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_goal.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            this.additems = response.data
          }
        })
    },

    modal: function () {
      this.add_goal_id = ""
      this.add_name = ""
      $('.js-modal').addClass('is-active');
    },
    modal2: function (item) {
      this.add_goal_id = item.goal_id
      this.add_name = item.name
      $('.js-modal').addClass('is-active');
    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
    add: function () {
      let params = new URLSearchParams();
      if (this.add_goal_id) {
        params.append('type', 'update');
        params.append('goal_id', this.add_goal_id);
      } else {
        params.append('type', 'insert');
      }

      params.append('name', this.add_name);
      axios.post("./php/db_goal.php", params)
        .then(response => {
          $('.js-modal').removeClass('is-active');
          this.getItem()
        })

    },
    del(goal_id) {
      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('goal_id', goal_id);
      axios.post("./php/db_goal.php", params)
        .then(response => {
          this.getItem()
        })

    }

  },

  computed: {
  },
  watch: {
  }
}
</script>
