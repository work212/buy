<template>
  <div id="buyBox">
    <buy-tab v-bind:type="type"></buy-tab>
    <div id="addBox">
      <!--input type="text" v-model="name" class="base_input"><button v-on:click="doAdd"
        class="base_button on_button">追加</button-->

        <div class="list_title">
          商品一覧
        </div>
        <span v-on:click="modal()" class="add_button_box"><img src="./assets/img/add.png"
            class="add_button">追加</span>
      <table class="list_table_min">
        <tbody is="draggable" v-model="additems" tag="tbody" @end="draggableEnd">
          <tr v-for="item, index in additems" :key="item.no">
            <td class="edit_box" v-on:click="modal2(item)"><img src="./assets/img/edit.png" class="list_edit"></td>
            
            <td class="name_box">{{ item.name }}</td>
            <td class="del_box" v-on:click="doDelete(item)"><img src="./assets/img/del_gray.png" class="list_del">
            </td>
          </tr>
          </tbody>
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
              <td><input type="text" id="add_name" class="modal_input" v-model="add_name"></td>
            </tr>
          </table>
          <div class="button">
          <button v-on:click="doAdd()" class="modal_button">追加</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>

.list_table_min{
  max-width: 400px;
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
      type: 'buy_add',
      additems: [],
      items: [],
      newNo: 0,
      add_buy_id: "",
      add_name: "",
    }
  },
  components: {
    'buy-tab': httpVueLoader('./BuyTab.vue')
  },
  beforeMount: function () {
    this.getItem();
  },
  methods: {
    getItem() {
      this.additems = []
      let params = new URLSearchParams();
      params.append('type', 'select');
      axios.post("./php/db_buy.php", params)
        .then(response => {
          if(response.data && response.data != "error"){
            this.additems = response.data
          }
        })
    },
    modal: function () {
      this.add_buy_id=""
      this.add_name=""
      $('.js-modal').addClass('is-active');
    },
    modal2: function (item) {
      console.log(item)
      this.add_buy_id = item.buy_id;
     this.add_name= item.name
      $('.js-modal').addClass('is-active');
    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
    doDelete: function (item) {
      //console.log(item)
      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('buy_id', item.buy_id);
      axios.post("./php/db_buy.php", params)
        .then(response => {
          //ソート
          let params = new URLSearchParams();
          params.append('type', 'sort_delete');
          params.append('status', item.status);
          params.append('sort_no', item.sort_no);
          params.append('status_sort_no', item.status_sort_no);
          axios.post("./php/db_buy.php", params)
          .then(response => {
          })
          this.getItem();
        })

    },
    doAdd: function () {
      var self = this;
      var no = 0;
      // itemsの中の一番大きなnoを取得して１を足す
      if (self.additems.concat().length > 0) {
        sort_no = Math.max.apply(null, self.additems.concat().map(function (item) {
          return item.sort_no;
        })) + 1;
        self.newNo = self.newNo < sort_no ? sort_no : self.newNo;
      }

      var category_max_no = 0;
      for (let i = 0; i < self.additems.concat().length; i++){
        if(self.additems[i]['status'] == 2) {
          if(category_max_no < self.additems[i]['status_sort_no']) 
          category_max_no = self.additems[i]['status_sort_no']
        }
      }
      var category_no = Number(category_max_no) + 1

      let params = new URLSearchParams();
      if(this.add_buy_id){
        params.append('type', 'update');
        params.append('buy_id', this.add_buy_id);
      }else{
        params.append('type', 'insert');
        params.append('status', '2');
        params.append('sort_no', this.newNo);
        params.append('status_sort_no', category_no);
      }
      console.log("!!!")
      console.log(this.add_buy_id)

      params.append('name', this.add_name);
      axios.post("./php/db_buy.php", params)
        .then(response => {
          console.log(response)
            this.getItem();
            this.close();
        })
    },
    draggableEnd(event) {
      console.log("!!!")
      console.log(this.additems)
      //ソート処理無い★
      let params = new URLSearchParams();
      params.append('item_data', JSON.stringify(this.additems));
      axios.post("./php/db_buy.php", params)
        .then(response => { })
    },

  },

  computed: {
  },
  watch: {
  }
}
</script>
 v-model="additems"