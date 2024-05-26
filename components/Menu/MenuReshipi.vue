<template>
  <div id="buyBox">
    <menu-tab v-bind:type="type"></menu-tab>
    <div id="shopAddBox">
      <div id="memoBox">
        <div class="menuMemo">
          <h2 class="base_title">レシピ　検討中</h2>
          <textarea id="memo" class="textlines" v-model="memo"></textarea>
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
      type: 'menu_reshipi',
      memo: ''
    }
  },
  components: {
    'menu-tab': httpVueLoader('./MenuTab.vue')
  },
  beforeMount: function () {
    axios.get("./php/memo.php?type=menu_reshipi")
      .then(response => {
        if(response.data && response.data != "error"){
          this.memo = response.data
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
      params.append('type', "menu_reshipi");
      axios.post("./php/memo.php", params)
        .then(response => {
        })
    }
  }
}
</script>
