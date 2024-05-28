<template>
  <div id="swapBox">
    <buy-tab v-bind:type="type"></buy-tab>
    <div id="mainBox">
      <div id="box1" class="box">
        <draggable v-model="items1" tag="ul" :options="{ group: 'ITEMS' }" @end="draggableEnd" class="status1">
          <li v-for="item, index in getItems1" :key="item.no">{{ item.name }}</li>
        </draggable>
      </div>
      <div id="box2" class="box">
        <draggable v-model="items2" tag="ul" :options="{ group: 'ITEMS' }" @end="draggableEnd" class="status2">
          <li v-for="item, index in getItems2" :key="item.no">{{ item.name }}</li>
        </draggable>
      </div>
    </div>
  </div>
</template>

<style scoped>

#mainBox{
  margin-top:120px;
}
.box {
  width: 48%;
  float: left;
}

.box#box1 {
  margin-right: 4%;
}

.box ul {
  position: relative;
  padding: 15px 15px 15px 20px;
  font-size: 14px;
  border: solid 2px #333;
  border-radius: 8px;
  color: #333;
  background: #fff;
  height: 100%;
}

#box1 ul:before {
  content: "在庫なし";
}

#box2 ul:before {
  content: "在庫あり";
}

.box ul:before {
  position: absolute;
  display: block;
  top: -15px;
  left: 15px;
  background: #fff;
  font-size: 14px;
  font-weight: bold;
  padding: 0 10px;
}
</style>

<script>
module.exports = {
  data: function () {
    return {
      type: 'buy_swap',
      items1: [],
      items2: []
    }
  },
  components: {
    'buy-tab': httpVueLoader('./BuyTab.vue')
  },
  beforeMount: function () {
    this.getSwapItem();
  },
  methods: {

    getSwapItem() {

      let params = new URLSearchParams();
      params.append('type', 'select');

      params.append('status', '1');
      axios.post("./php/db_buy.php", params)
        .then(response => {
          if(response.data && response.data != "error"){
            this.items1 = response.data
          }
        })

      params.append('status', '2');
      axios.post("./php/db_buy.php", params)
        .then(response => {
          if(response.data && response.data != "error"){
            this.items2 = response.data
          }
        })

    },
    draggableEnd(event) {

      //ソート順 現在位置より-1のsort_noを+1
      if (event.to.className == "status1") {
        var data = this.items1
        var status = 1
      } else {
        var data = this.items2
        var status = 2
      }

      new_id = data[event.newIndex]['buy_id']

      if (event.from.className == event.to.className) {
        if (event.newIndex == 0) {
          status_sort_no = 1
        } else if (event.newIndex > event.oldIndex) {
          status_sort_no = Number(data[event.newIndex - 1]['status_sort_no'])
        } else {
          status_sort_no = Number(data[event.newIndex - 1]['status_sort_no']) + 1
        }
      } else {
        if (event.newIndex == 0) {
          status_sort_no = 1
        } else {
          status_sort_no = Number(data[event.newIndex - 1]['status_sort_no']) + 1
        }
      }

      //データ挿入
      let params = new URLSearchParams();
      params.append('type', 'update_sort');
      params.append('status', status);
      params.append('buy_id', new_id);
      params.append('status_sort_no', status_sort_no);
      axios.post("./php/db_buy.php", params)
        .then(response => {

          //ソート
          let params = new URLSearchParams();
          var type_name = (event.from.className == event.to.className) ? "sort2" : "sort";
          params.append('status', status);
          params.append('target_sort', status_sort_no);
          params.append('no_target', new_id);
          params.append('moto_no', data[event.newIndex]['status_sort_no']);
          params.append('type', type_name);
          axios.post("./php/db_buy.php", params)
            .then(response2 => {
            })
          this.getSwapItem();
        })
    }

  },

  computed: {
    getItems1: {
      get: function () {
        return this.items1;
      },
      set: function (value) {
        this.items1 = value;
      }
    },
    getItems2: {
      get: function () {
        return this.items2;
      },
      set: function (value) {
        this.items2 = value;
      }
    }

  },
  watch: {
  }
}
</script>
