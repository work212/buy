<template>
  <div id="mainBox">
    <payment-tab v-bind:type="type" v-bind:id="$route.params.id"></payment-tab>

      <div id="">
        <button v-on:click="next(-1)" class="mark_button">&lt;</button> <span class="base_title">{{ target.year }}/{{
      target.month }}</span>
        <button v-on:click="next(1)" class="mark_button">&gt;</button>
        <span class="base_title"><span v-if="$route.params.id == 0">支出</span>
          <span v-else>収入</span> 合計：{{ total }}</span>
        <span v-on:click="modal()" class="add_button_box"><img src="./assets/img/add.png" class="add_button">追加</span>
      </div>
      

      <div id="list_area">
        <table class="base_list">
          <tr class="th">
            <th></th>
            <th class="day">日付</th>
            <th class="category">カテゴリ</th>
            <th class="money">金額</th>
            <th class="title">詳細</th>
            <th class="button"></th>
          </tr>

          <tr v-for="item, index in payment_items" :key="item.no">
            <td class="edit_box"><img src="./assets/img/edit.png" class="list_edit" v-on:click="modal2(item)"></td>
            <td class="day">
              {{ payment_items[index].day }}
            </td>
            <td class="category">
              {{ payment_items[index].payment_category }}
            </td>
            <td class="money">
              {{ payment_items[index].money }}</td>
            <td class="title">{{ payment_items[index].title }}</td>
            <td class="del_box">
              <div class="payment_del_button" v-on:click="doDelete(index, item.payment_data_id)"><img
                  src="./assets/img/del_gray.png" class="list_del">
              </div>
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

      <div class="modal2 js-modal">
        <div class="modal-container">
          <div class="modal-close js-modal-close" v-on:click="close()">×</div>
          <div class="modal-content">
            <input type="hidden" id="payment_data_id" v-model="payment_data_id">
            <table>
              <tr>
                <th>日付</th>
                <td>
                  <select v-model="day" class="modal_select" id="day">
                    <option v-for="tag in day_list" :value="tag.id">
                      {{ tag.name }}
                    </option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>カテゴリ</th>
                <td>
                  <select id="payment_category_id" v-model="payment_category_id" class="modal_select">
                    <option v-for="tag in category_list" :value="tag.payment_category_id">
                      {{ tag.name }}
                    </option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>金額</th>
                <td>
                  <input type="number" v-model="money" class="modal_input" id="money">
                </td>
              </tr>
              <tr>
                <th>詳細</th>
                <td>
                  <input type="text" v-model="title" class="modal_input" id="title">
                </td>
              </tr>
            </table>
            <div class="button"><button class="modal_button" v-on:click="doAdd">追加</button></div>
          </div>
        </div>
      </div>

    </div>

</template>

<style scoped>
.day {
  width: 40px;
}

.category {
  width: 80px;
}

.money {
  width: 80px;
}


.modal-container {
  width: 420px;
}

.modal-container th {
  width: 100px;
}
</style>

<script>
module.exports = {
  data: function () {
    return {
      type: 'payment',
      target: {
        'year': "",
        'month': ""
      },
      payment_items: [],
      total: 0,
      memo: '',
      category_list: [],
      day_list: [],
      payment_data_id: "",
      day: "",
      payment_category_id: "",
      money: "",
      title: ""
    }
  },
  components: {
    'payment-tab': httpVueLoader('./paymentTab.vue')
  },
  beforeMount: function () {
    console.log(this.$route.params.id)
    if ($cookies.isKey(this.type + "_" + this.$route.params.id)) {
      this.target = this.$cookies.get(this.type + "_" + this.$route.params.id);
    }

    if (!this.target.year || !this.target.month) {
      let date = new Date();
      this.target.year = date.getFullYear()
      this.target.month = ('0' + Number(date.getMonth() + 1)).slice(-2);
    }
    this.$cookies.set(this.type + "_" + this.$route.params.id, this.target);

    this.getItem();
    axios.get("./php/memo.php?type=" + this.type + "_" + this.$route.params.id)
      .then(response => {
        if (response.data && response.data != "error") {
          this.memo = response.data
        }
      })

  },
  methods: {

    next(type) {
      var nextDate = new Date(this.target.year, this.target.month);
      nextDate.setMonth(nextDate.getMonth() + type);
      this.target.year = nextDate.getFullYear()
      this.target.month = ('0' + Number(nextDate.getMonth())).slice(-2);
      this.$cookies.set(this.type + "_" + this.$route.params.id, this.target);
      this.getItem()
      this.getDaySelect()
    },
    getItem() {
      this.payment_items = []
      let params = new URLSearchParams();
      params.append('type', 'select');
      params.append('payment_type', this.$route.params.id);
      params.append('year_month', this.target.year + '-' + this.target.month);
      axios.post("./php/db_payment_data.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            this.payment_items = response.data;
            if (this.payment_items) {
              var total = 0;
              $.each(this.payment_items, function (index, val) {
                if (val.money) {
                  console.log(Number(val.money))
                  total += Number(val.money)
                }
              })
              this.total = total;
            }
          }
        })
    },
    getPaymentCategory() {

      let params = new URLSearchParams();
      params.append('type', 'select');
      params.append('payment_type', this.$route.params.id);
      axios.post("./php/db_payment_category.php", params)
        .then(response => {
          if (response.data && response.data != "error") {
            this.category_list = response.data
          }
        })
    },
    getDaySelect() {

      var baseDate = new Date(this.target.year, this.target.month);
      baseDate.setMonth(Number(this.target.month), 0);

      var day_str = 0;
      for (i = 1; i <= baseDate.getDate(); i++) {
        day_str = ('0' + i).slice(-2);
        var obj = { id: day_str, name: day_str };
        this.day_list.push(obj);
      }
    },

    modal: function () {
      this.getPaymentCategory()
      this.getDaySelect()
      this.payment_data_id = ""
      this.day = ""
      this.payment_category_id = ""
      this.money = ""
      this.title =""
      $('.js-modal').addClass('is-active');
    },

    modal2: function (item) {
      this.getPaymentCategory()
      this.getDaySelect()

      this.payment_data_id = item.payment_data_id
      this.day = item.day
      this.payment_category_id = item.payment_category_id
      this.money = item.money
      this.title = item.title
      $('.js-modal').addClass('is-active');
    },
    doAdd: function () {
      var new_data = {
        day: this.day,
        payment_category_id: this.payment_category_id,
        money: this.money,
        title: this.title
      }

      let params = new URLSearchParams();
      if ($('#payment_data_id').val()) {
        params.append('type', 'update');
        params.append('payment_data_id', $('#payment_data_id').val());
      } else {
        params.append('type', 'insert');
      }

      params.append('query', JSON.stringify(new_data));
      params.append('year_month', this.target.year + '-' + this.target.month);
      axios.post("./php/db_payment_data.php", params)
        .then(response => {
          this.getItem();
        })
      this.day = ''
      this.payment_category_id = ''
      this.money = ''
      this.title = ''
      this.close();
    },
    doDelete: function (index, no) {

      let params = new URLSearchParams();
      params.append('type', 'delete');
      params.append('payment_data_id', no);
      axios.post("./php/db_payment_data.php", params)
        .then(response => {
          this.getItem()
        })

    },
    close: function () {
      $('.js-modal').removeClass('is-active');
    },
  },

  watch: {
    memo: function (newVal) {
      let params = new URLSearchParams();
      params.append('input_val', newVal);
      params.append('type', this.type + "_" + this.$route.params.id);
      axios.post("./php/memo.php", params)
        .then(response => {
        })
    }
  }
}
</script>
