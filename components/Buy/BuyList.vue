<template>
  <div id="buyBox">
    
    <buy-tab v-bind:type="type"></buy-tab>
    <div class="buyList">
      <ul v-if="buyitems.length > 0">
        <li v-for="item, index in buyitems" :key="item.no">
          <div class="boxes">
            <img src="./assets/img/check.png"
            v-on:click="doBuy(item.buy_id)" class="check_img"
            v-bind:id="['box-' + item.buy_id]">
          <label v-bind:for="['box-' + item.buy_id]">{{ item.name }}</label>
          </div>
        </li>
      </ul>
      <ul v-else>
        <li>「在庫なし」はありません</li>
      </ul>
    </div>
    
    <div id="memoBox">
      <h2 class="base_title">共通メモ</h2>
      <textarea id="app2" class="textlines" v-model="memo"></textarea>
    </div>
  </div>
</template>

<style scoped>
.buyList {
  position: relative;
  margin: 120px 0 40px 0;
  background: #eee;
  box-shadow: 0 2px 3px rgba(0, 0, 0, .22);

  .base_button {
    margin-right: 10px;
  }
}

.buyList ul {
  position: relative;
  margin: 0;
  padding: 14px 0.5em 10px 0.5em;
  color: #333;
  border: none;
  list-style-type: none;
}

.buyList ul li {
  line-height: 1.5;
  padding: 6px 0 6px 6px;
  border-bottom: dashed 1px #333;
  font-size: 13px;
}

.buyList:after {
  position: absolute;
  content: "";
  top: 20px;
  width: 30%;
  height: 35px;
  opacity: 0.9;
  margin: -35px auto 10px 35%;
  background: repeating-linear-gradient(-45deg, #eee, #ddd 2px, #ccc 3px, #999 7px);
  transform: rotate(-2deg);
  left: 10px;
  right: 10px;
}

.check_img{
  width:20px;
  height: auto;
}
.check_img {
  opacity: 0.3;
}
.check_img.active {
  animation: itemMove 0.5s ease both;
}
@keyframes itemMove {
  0% {
    opacity: 0;
    transform: scale(2, 2);
  }
  
  90% {
    opacity: 1;
  }
  
  100% {
    opacity: 1;
    transform: scale(1, 1);
  }
}


</style>

<script>
module.exports = {
  data: function () {
    return {
      type: 'buy_list',
      memo: '',
      buyitems: [],
    }
  },
  components: {
    'buy-tab': httpVueLoader('./BuyTab.vue')
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

    doBuy: function (buy_id) {
      console.log(buy_id)
      const item1 = document.querySelector('#box-'+buy_id);
	
      $('#box-'+buy_id).addClass("active");
console.log(item1)
item1.addEventListener('animationend', () => {
  $('#box-'+buy_id).removeClass("active");
  //item1のアニメーションが完了したらitem2に.activeを付与する
  console.log("!!!")
  let params = new URLSearchParams();
      params.append('type', 'update');
      params.append('buy_id', buy_id);
      params.append('status', '2');
      axios.post("./php/db_buy.php", params)
        .then(response => {
            this.getItem();
        })
});
console.log("###")
return

    },
    getItem() {
      this.additems = []
      let params = new URLSearchParams();
      params.append('type', 'select');
      params.append('status', '1');
      axios.post("./php/db_buy.php", params)
        .then(response => {
          this.buyitems = []
          if (response.data && response.data != "error") {
           // console.log(response)
            this.buyitems = response.data
          }
        })
    },

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
