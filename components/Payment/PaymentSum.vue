<template>
  <div id="mainBox">
    <payment-tab v-bind:type="type"></payment-tab>

      <div id="">
        <button v-on:click="next(-1)" class="mark_button">
          &lt;</button> <span class="base_title">{{ year }}</span> <button v-on:click="next(1)"
          class="mark_button">&gt;</button>
      </div>
      <div v-if="category_list[1] && category_list[1] != 0" id="list">
        <table id="month">
          <tr>
            <td class="nocolor"></td>
            <th class="w">支出</th>
            <th class="w">収入</th>
          </tr>

          <tr v-for="i in 12">
            <th class="h">{{ i }}月</th>
            <td class="list" v-for="payment_type in payment_type_list">
              <div>
                <div>
                  <div v-for="item, index in category_list[payment_type]">
                    <div>
                      {{ item['name'] }}:{{ category_sum_data[('00' +
          (i)).slice(-2)][payment_type]['category_total'][item['payment_category_id']]
                      }}
                    </div>
                  </div>
                </div>

                <div class="month_total">合計：
                  <span v-if="category_sum_data[('00' + (i)).slice(-2)][payment_type]['total']">
                    {{ category_sum_data[('00' + (i)).slice(-2)][payment_type]['total'] }}
                  </span>
                  <span v-else>0</span>
                </div>
              </div>
            </td>
          </tr>

        </table>

        <div id="total" v-if="category_list[1] && category_list[1] != 0 ">
          <div id="total_box">
            <div id="total_minus" v-for="payment_type in payment_type_list">
              <div class="total_sub_title"><span v-if="payment_type == 1">支出</span><span v-else>収入</span></div>
              <div v-for="item, index in category_list[payment_type]">
                {{ item['name'] }}{{ category_total[payment_type][item['payment_category_id']] }}<br>
              </div>
              <div class="total_sub_sum">{{ total[payment_type] }}</div>
            </div>
          </div>
          <div id="total_all">
            合計：{{ total[2] - total[1] }}
          </div>
        </div>

      </div>
    </div>


</template>

<style scoped>
#list {
  overflow: hidden;
  margin-top: 20px;

  #month {
    float: left;
    margin-right: 30px;
    font-size: 12px;
    color: #333;

    .month_total {
      font-weight: 600;
      color: #ee8992;
    }
  }

  #total {
    float: left;
    font-size: 14px;
    color: #333;
  }

  #total_box {
    border-radius: 4px;
    background: #eee;
    padding: 10px 20px;
    font-size: 14px;
    overflow: hidden;

    #total_minus,
    #total_plus {
      float: left;

      .total_sub_title,
      .total_sub_sum {
        font-weight: 600;
      }
    }

    #total_minus {
      margin-right: 30px;
    }
  }
}

#total_all {
  margin-top: 14px;
  text-align: right;
  font-weight: 600;
}

th {
  color: #fff;
}

th.w {
  background-color: #333;
  border-radius: 4px 4px 0px 0px;
  padding: 4px;
}

th.h {
  border-radius: 4px 0px 0px 4px;
  background-color: #333;
  padding: 4px 10px;
}

td.nocolor {
  background-color: #fff;
}

tr:nth-child(2n+1) {
  background: #eee;
}

td {
  padding: 4px 6px;
}
</style>


<script>
module.exports = {
  data: function () {
    return {
      type: 'payment_sum',
      year: "",
      item_list: [],
      category_list: [],
      total: [],
      category_total: [],
      category_sum_data: [],
      payment_type_list:[1,2]
    }
  },
  components: {
    'payment-tab': httpVueLoader('./paymentTab.vue')
  },
  mounted: function () {
  },
  beforeMount: function () {
    let date = new Date();
    this.year = date.getFullYear()
    this.getItem();
  },
  mounted: function () {

  },
  methods: {
    async fetchSample2() {
      let ret = []
      for (const elem of this.payment_type_list) {
        ret[elem] = []
        let params = new URLSearchParams();
        params.append('type', 'select');
        params.append('payment_type', elem);
        await axios.post("./php/db_payment_category.php", params)
          .then(response => {
            if(response.data && response.data != "error"){
              ret[elem] = response.data;
            }
          })
      }

      return ret
    },
    async fetchSample() {
      let ret2 = []
      let params = new URLSearchParams();
      params.append('type', 'select');
      params.append('year', this.year);
      const results = await axios.post("./php/db_payment_data.php", params)
      return results.data
    },
    async makeDate(data) {
      var category_sum_data = []
      var category_total = { 1: [], 2: [] }
      var total = { 1: 0, 2: 0 }

      for (var i = 1; i <= 12; i++) {
        month = ('00' + (i)).slice(-2)
        category_sum_data[month] = []
        for (const payment_type of this.payment_type_list) {
          category_sum_data[month][payment_type] = []
          category_sum_data[month][payment_type]['category_total'] = []
          category_sum_data[month][payment_type]['total'] = 0
          for (const result of this.category_list[payment_type]) {
            category_sum_data[month][payment_type]['category_total'][result['payment_category_id']] = 0
          }
          for (const result of this.category_list[payment_type]) {
            category_total[payment_type][result['payment_category_id']] = 0
          }
        }
      }
      console.log(category_sum_data)
          
      $.each(data, function (index, val) {
        console.log(val)
        category_sum_data[val['month']][val['payment_type']]['total'] += Number(val['money'])
        category_sum_data[val['month']][val['payment_type']]['category_total'][val['payment_category_id']] += Number(val['money'])
        category_total[val['payment_type']][val['payment_category_id']] += Number(val['money'])
        total[val['payment_type']] += Number(val['money'])
      })
      return [category_sum_data, category_total, total]
    },
    async getItem() {

      //カテゴリ取得
      this.category_list = await this.fetchSample2()
      
      //データ取得
      var data = await this.fetchSample()

      //データ整形
      var [category_sum_data, category_total, total] = await this.makeDate(data)

      this.category_sum_data = category_sum_data
      this.category_total = category_total
      this.total = total

    },

    next(type) {
      var nextDate = new Date(this.year, '01');
      nextDate.setYear(nextDate.getFullYear() + type);
      this.year = nextDate.getFullYear()
      this.getItem()
    }

  },

  computed: {
  },
  watch: {
  }
}
</script>
