<template>
  <div id="todoBox">
    <todo-tab></todo-tab>
    <button v-on:click="modal()">[追加]</button>

    <div v-for="item, index in todoitems" :key="index">
      <div><span v-on:click="modal2(item)">{{ item.name }}</span>
        <span class="todo_del_button" v-on:click="del(item.todo_category_id)"><img src="./assets/img/del_gray.png">
        </span>
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
        <!-- モーダルを閉じるボタン -->
        <div class="modal-close js-modal-close" v-on:click="close()">×</div>
        <input type="hidden" id="update_id">
        <!-- モーダル内部のコンテンツ -->
        <div class="modal-content">
          名前<input type="text" id="name">
          <button v-on:click="add()">追加</button>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>

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
      type: 'todo_category_add',
      memo: '',
      todoitems: [],
      interval_list: [],
      category_list: []
    }
  },
  components: {
    'todo-tab': httpVueLoader('./TaskTab.vue')
  },
  beforeMount: function () {

    this.getItem();

    axios.get("./php/memo.php?type=" + this.type)
      .then(response => {
        if(response.data && response.data != "error"){
          this.memo = response.data
        }
      })

  },
  methods: {
    getItem() {

      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_todo_category.php", params)
        .then((response) => {
          if(response.data && response.data != "error"){
            this.todoitems = response.data;
          }
        })
    },

    modal: function () {
      $('.js-modal').addClass('is-active');
    },
    modal2: function (item) {
      $('#update_id').val(item.todo_category_id);
      $('#name').val(item.name)
      $('.js-modal').addClass('is-active');
    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
    add: function () {

      let params = new URLSearchParams();
      if ($('#update_id').val()) {
        params.append('type', 'update');
        params.append('todo_category_id', $('#update_id').val());
      } else {
        params.append('type', 'insert');
      }

      params.append('name', $('#name').val());
      axios.post("./php/db_todo_category.php", params)
        .then(response => {
          $('.js-modal').removeClass('is-active');
          $('#update_id').val("")
          $('#name').val("")

          this.getItem()
        })

    },
    del(todo_category_id) {
      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('todo_category_id', todo_category_id);
      axios.post("./php/db_todo_category.php", params)
        .then(response => {
          this.getItem()
        })
    },
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
