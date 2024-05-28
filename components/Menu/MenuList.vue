<template>
  <div id="buyBox">
    <menu-tab v-bind:type="type"></menu-tab>
    <div id="shopAddBox">
      <div id=""><button v-on:click="next(-1)" class="mark_button">&lt;</button>
        <span class="base_title">{{ year }}/{{ month }}</span>
        <button v-on:click="next(1)" class="mark_button">&gt;</button>
      </div>
      <table>
        <tr>
          <th>日付</th>
          <th>お弁当</th>
          <th>朝</th>
          <th>昼</th>
          <th>晩</th>
          <th>メモ</th>
        </tr>
        <tr v-for="item, index in items" :key="index" :class="classObject(item.day, item.dow)">
          <td class="day">{{ item.day }}({{ item.dow }})</td>
          <td><input type="text" v-model="item.menu1" class="menu obe" @change="onChange(index)"></td>
          <td><input type="text" v-model="item.menu2" class="menu" @change="onChange(index)"></td>
          <td><input type="text" v-model="item.menu3" class="menu" @change="onChange(index)"></td>
          <td><input type="text" v-model="item.menu4" class="menu" @change="onChange(index)"></td>
          <td><input type="text" v-model="item.memo" class="menu" @change="onChange(index)"></td>
        </tr>
      </table>

    </div>
  </div>
</template>

<style scoped>
table{
  margin-top:20px;
  font-size: 14px;
}
th{
  background-color: #333;
  color:#fff;
}
.day{
  padding: 4px 6px;
}
input{
  border: 1px solid #aaa;
  border-radius: 4px;
  height: 24px;
}
.saturday {
  background-color: #d5e9ed;
}

.sunday {
  background-color: #edbec2;
}

.holiday {
  background-color: #ddedd5;
}
</style>


<script>
module.exports = {
  data: function () {
    return {
      type: 'menu_list',
      items: [],
      year: "",
      month: "",
      day: 0
    }
  },
  components: {
    'menu-tab': httpVueLoader('./MenuTab.vue')
  },
  beforeMount: function () {
    let date = new Date();
    this.year = date.getFullYear()
    this.month = ('0' + Number(date.getMonth() + 1)).slice(-2);
    this.day = this.getLastDay(this.year, this.month)
    this.getItem();
  },
  methods: {
    getW: function (yearStr, monthStr, dayStr) {
      var jsMonth = monthStr - 1;
      var dayOfWeekStrJP = ["日", "月", "火", "水", "木", "金", "土"];
      var date = new Date(yearStr, jsMonth, dayStr);
      return dayOfWeekStrJP[date.getDay()]
    },

    classObject: function (day, dow) {
      var class_name = ""
      if (dow == "土") {
        class_name = "saturday"
      } else if (dow == "日") {
        class_name = "sunday"
      } else {
        var check_date = this.year + '-' + this.month + '-' + ('00' + day).slice(-2);
        var holidays = window.holiday_jp.between(new Date(check_date), new Date(check_date));
        if (holidays.length != 0) {
          class_name = "holiday"
        }
      }
      return class_name
    },

    onChange: function (index) {
      let params = new URLSearchParams();
      if (this.items[index]['menu_data_id'] == "") {
        params.append('type', 'insert');
        params.append('menu_date', this.year + '-' + this.month + '-' + this.items[index]['day']);
      } else {
        console.log("!!!")
        params.append('type', 'update');
        params.append('menu_data_id', this.items[index]['menu_data_id']);
      }

      params.append('menu1', this.items[index]['menu1']);
      params.append('menu2', this.items[index]['menu2']);
      params.append('menu3', this.items[index]['menu3']);
      params.append('menu4', this.items[index]['menu4']);
      params.append('memo', this.items[index]['memo']);

      axios.post("./php/db_menu_data.php", params)
        .then(response => {
          console.log(response)
        })
    },

    next(type) {
      var nextDate = new Date(this.year, this.month);
      nextDate.setMonth(nextDate.getMonth() + type);
      this.year = nextDate.getFullYear()
      this.month = ('0' + Number(nextDate.getMonth())).slice(-2);
      this.day = this.getLastDay(this.year, this.month)
      this.getItem()
    },

    getLastDay: function (year, month) {
      let date = new Date(year, month, 1);
      date.setMonth(date.getMonth() + 1, 0);
      return date.getDate()
    },
    getItem() {
      var dow = ""
      var now_day = ""

      let params = new URLSearchParams();
      params.append('type', 'select');
      params.append('menu_date', this.year + '-' + this.month);
      axios.post("./php/db_menu_data.php", params)
        .then(response => {
          if (response.data != "error") {
            this.items = []
            for (let i = 0; i < this.day; i++) {
              var menu_data_id = "";
              var menu1 = "";
              var menu2 = "";
              var menu3 = "";
              var menu4 = "";
              var memo = "";
              now_day = ('00' + (i + 1)).slice(-2)
              dow = this.getW(this.year, this.month, now_day)
              if (response.data[now_day] != undefined) {
                menu_data_id = response.data[now_day]["menu_data_id"]
                menu1 = response.data[now_day]["menu1"]
                menu2 = response.data[now_day]["menu2"]
                menu3 = response.data[now_day]["menu3"]
                menu4 = response.data[now_day]["menu4"]
                memo = response.data[now_day]["memo"]
              }
              this.items[i] = {
                "day": now_day,
                "dow": dow,
                "menu_data_id": menu_data_id,
                "menu1": menu1,
                "menu2": menu2,
                "menu3": menu3,
                "menu4": menu4,
                "memo": memo
              };
            }
          }
        })
    }

  },

  watch: {
  }
}
</script>
