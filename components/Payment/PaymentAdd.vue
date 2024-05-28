<template>
  <div id="mainBox">
    <payment-tab v-bind:type="type"></payment-tab>
    <div id="addBox">


      <div v-for="payment_type in payment_type_list" class="add_type_box">
        <!--input type="text" v-model="name[payment_type]" class="base_input"-->
        <div class="list_title"><span v-if="payment_type == 1">支出</span>
          <span v-if="payment_type == 2">収入</span>
          カテゴリ
        </div>
        <span v-on:click="modal(payment_type)" class="add_button_box"><img src="./assets/img/add.png"
            class="add_button">追加</span>

        <table class="list_table_min">
          <tbody is="draggable" v-model="additems[payment_type]" tag="tbody" @end="draggableEnd">
          <tr v-for="item, index in additems[payment_type]" :key="item.no"
            v-bind:class="{ 'item1': payment_type === 1, 'item2': payment_type === 2 }">
            <td class="edit_box" v-on:click="modal2(item)"><img src="./assets/img/edit.png" class="list_edit"></td>
            <td class="name_box">
                {{ item.name }}
            </td>
            <td class="del_box" v-on:click="doDelete(item)"><img src="./assets/img/del_gray.png" class="list_del"></td>
          </tr>
          </tbody>
        </table>

      </div>

    </div>



    <!-- モーダル本体 -->
    <div class="modal js-modal">
      <div class="modal-container">
        <div class="modal-close js-modal-close" v-on:click="close()">×</div>
        <div class="modal-content">
          <table>
            <tr>
              <th>カテゴリ</th>
              <td>
                <select id="add_payment_type" v-model="add_payment_type" class="modal_select">
                  <option value="1">支出</option>
                  <option value="2">収入</option>
                </select>
              </td>
            </tr>
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
#addBox {
  overflow: hidden;
}

.add_type_box {
  float: left;
  width: 47%;
}

.add_type_box:first-child {
  margin-right: 6%;
}



.modal-container {
  width: 300px;
}

.modal-container th {
  width: 100px;
}
</style>


<script>
module.exports = {
  data: function () {
    return {
      type: 'payment_add',
      additems: { 1: [], 2: [] },
      newNo: 0,
      newNo2: 0,
      name: { 1: "", 2: "" },
      payment_type_list: [1, 2],
      add_payment_type: "",
      add_payment_category_id:"",
      add_name:""
    }
  },
  components: {
    'payment-tab': httpVueLoader('./paymentTab.vue')
  },
  beforeMount: function () {
    this.getItem()
  },
  methods: {
    getItem() {
      for (var payment_type = 1; payment_type <= 2; payment_type++) {
        let params = new URLSearchParams();
        params.append('type', 'select');
        params.append('payment_type', payment_type);
        axios.post("./php/db_payment_category.php", params)
          .then(response => {
            if (response.data && response.data != "error") {
              //0件目が無い考慮が必要★　同期してthisを取得する？
              if (response.data[0]) {
                if (response.data[0]['payment_type'] == 1) {
                  this.additems[1] = response.data
                } else {
                  this.additems[2] = response.data
                }
              }
            }

          })
      }
    },
    doDelete: function (item) {

      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('payment_category_id', item.payment_category_id);
      axios.post("./php/db_payment_category.php", params)
        .then(response => {
          console.log("!!!!!!!!!!!!")
              console.log(response)
          //ソート
          let params = new URLSearchParams();
          params.append('type', 'sort_delete');
          params.append('payment_type', item.payment_type);
          params.append('sort_no', item.sort_no);
          axios.post("./php/db_payment_category.php", params)
            .then(response => {

              this.getItem()
            })
        })
    },


    modal: function (payment_type) {
      this.add_payment_type = payment_type;
      this.add_payment_category_id = ""
      this.add_name = ""
      $('.js-modal').addClass('is-active');
    },
    modal2: function (item) {
      this.add_payment_type = item.payment_type;
      this.add_payment_category_id = item.payment_category_id;
      this.add_name = item.name
      $('.js-modal').addClass('is-active');
    },

    doAdd: function () {
      var type = this.add_payment_type;
      var self = this.additems[type];
      var payment_type = type

      console.log("$$$")
      console.log(this.add_payment_type)
      var sort_no = 0;
      // itemsの中の一番大きなnoを取得して１を足す
      if (self.concat().length > 0) {
        sort_no = Math.max.apply(null, self.concat().map(function (item) {
          return item.sort_no;
        })) + 1;
        self.newNo = self.newNo < sort_no ? sort_no : self.newNo;
      }
      console.log("$$$1")


      let params = new URLSearchParams();
      if (this.add_payment_category_id) {
        var new_data = {
        name: this.add_name
      }
        params.append('type', 'update');
        params.append('payment_category_id', this.add_payment_category_id);
      } else {
        var new_data = {
        sort_no: sort_no,
        name: this.add_name,
        payment_type: payment_type
      }
        params.append('type', 'insert');
      }
      console.log("###")
      params.append('query', JSON.stringify(new_data));
      axios.post("./php/db_payment_category.php", params)
        .then(response => {
          this.name[type] = ''
          this.getItem()
          this.close();
        })

    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
    draggableEnd(event) {
      console.log("!!!")
      const className = $(event.target).attr("class")
      if (className == "item1") {
        var change_data = this.additems[1]
        var payment_type = 1
      } else {
        var change_data = this.additems[2]
        var payment_type = 2
      }

      var sort_no = 0
      if (event.newIndex == 0) {
        sort_no = 1
      } else {
        sort_no = change_data[event.newIndex - 1].sort_no
        if (event.newIndex < event.oldIndex) sort_no = Number(sort_no) + 1
      }
      let params = new URLSearchParams();
      params.append('type', 'update');
      params.append('payment_category_id', change_data[event.newIndex].payment_category_id);
      params.append('sort_no', sort_no);
      axios.post("./php/db_payment_category.php", params)
        .then(response => {
          let params = new URLSearchParams();
          params.append('type', 'sort');
          params.append('payment_type', payment_type);
          params.append('payment_category_id', change_data[event.newIndex].payment_category_id);
          params.append('sort_no', sort_no);
          params.append('moto_sort_no', change_data[event.newIndex]['sort_no']);
          axios.post("./php/db_payment_category.php", params)
            .then(response => {
              console.log(response)
              this.getItem()
            })

        })
    },


  },

  computed: {
  },
  watch: {
  }
}
</script>
