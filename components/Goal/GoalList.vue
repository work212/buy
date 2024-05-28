<template>
  <div id="todoBox">
    <todo-tab v-bind:type="type"></todo-tab>
    <div class="list_title">リスト</div>
    <span v-on:click="modal()" class="add_button_box">
      <img src="./assets/img/add.png" class="add_button">追加</span>

    <div id="list_area">
      <table class="base_list">
        <tr>
          <th></th>
          <th>リスト</th>
          <th>カテゴリ</th>
          <th>完了日</th>
          <th></th>
        </tr>
    <tr v-for="item, index in listitems" :key="index">
      <td v-on:click="modal2(item)"  class="edit_box">
              <img src="./assets/img/edit.png" class="list_edit"></td>
        <td>{{ item.name }} </td>
        <td>{{ item.list_category }} </td>
        <td>{{ item.list_date }}</td>
        <td class="del_box" v-on:click="del(item.list_id)">
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
            <td><input type="text" id="name" v-model="add_name"></td>
          </tr>
          <tr>
          <th>カテゴリー</th>
          <td><select id="" v-model="add_category">
            <option v-for="tag in category_list" v-bind:value="tag.list_category_id">
              {{ tag.name }}
            </option>
          </select>
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
/* モーダルと背景の指定 */
.detail {
  width: 100%;
  height: 100px;
}

.todo_del_button {
  height: 20px;
  width: 20px;
  margin: 2px 0;
  display: inline-block;

  img {
    height: 100%;
    width: auto;
  }
}
</style>


<script>
module.exports = {
  data: function () {
    return {
      type: 'goal_list',
      memo: '',
      listitems: [],
      category_list: [],
      add_list_id:"",
      add_name:"",
      add_category: ""
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
      axios.post("./php/db_list.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            console.log(response)
            this.listitems = response.data
          }
        })
    },

    getCategory() {
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_list_category.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            console.log(response)
            this.category_list = response.data;
          }
        })
    },

    modal: function () {
      this.add_list_id = ""
      this.add_name = ""
      this.add_category =""
      this.getCategory();
      $('.js-modal').addClass('is-active');
    },
    modal2: function (item) {
      this.getCategory();
      this.add_list_id = item.list_id
      this.add_name = item.name
      this.add_category = item.list_category_id
      $('.js-modal').addClass('is-active');
    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
    add: function () {
      let params = new URLSearchParams();
      if (this.add_list_id) {
        params.append('type', 'update');
        params.append('list_id', this.add_list_id);
      } else {
        params.append('type', 'insert');
      }

      params.append('name',  this.add_name );
      params.append('list_category_id', this.add_category);
      axios.post("./php/db_list.php", params)
        .then(response => {
          console.log(response);
          $('.js-modal').removeClass('is-active');
          this.getItem()
        })

    },
    del(list_id) {
      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('list_id', list_id);
      axios.post("./php/db_list.php", params)
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
