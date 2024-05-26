<template>
  <div id="buyBox">
    <menu-tab v-bind:type="type"></menu-tab>
    <div id="shopAddBox">
      <div id="memoBox">
        <div class="menuMemo">
          <h2 class="base_title">在庫</h2>
          <textarea id="memo" class="textlines" v-model="memo"></textarea>
        </div>
        <div class="menuMemo">
          <h2 class="base_title">メモ</h2>
          <textarea id="memo2" class="textlines" v-model="memo2"></textarea>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>

<script>
module.exports = {
  data: function () {
    return {
      type: 'menu_stock',
      memo: '',
      memo2: ''
    }
  },
  components: {
    'menu-tab': httpVueLoader('./MenuTab.vue')
  },
  beforeMount: function () {

    axios.get("./php/memo.php?type=menu_stock")
      .then(response => {
        if(response.data && response.data != "error"){
          this.memo = response.data
        }
      })
    axios.get("./php/memo.php?type=menu_stock_memo")
      .then(response => {
        if(response.data && response.data != "error"){
          this.memo2 = response.data
        }
      })
  },
  methods: {
  },

  computed: {
  },

  watch: {
    memo: function (newVal) {
      let params = new URLSearchParams();
      params.append('input_val', newVal);
      params.append('type', "menu_stock");
      axios.post("./php/memo.php", params)
        .then(response => {
        })

    },
    memo2: function (newVal) {
      let params = new URLSearchParams();
      params.append('input_val', newVal);
      params.append('type', "menu_stock_memo");
      axios.post("./php/memo.php", params)
        .then(response => {
        })
    }
  }
}
</script>
