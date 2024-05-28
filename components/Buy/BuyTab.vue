
<template>
<div id="BuyTab" class="sub_tab">
    <ul>
    <li :class="{'active': type == 'buy_list'}"><a href="./index.html#/buy_list">買い物リスト</a></li>
    <li :class="{'active': type == 'buy_swap'}"><a href="./index.html#/buy_swap">入れ替え</a></li>
    <li :class="{'active': type == 'buy_add'}"><a href="./index.html#/buy_add">追加</a></li>
  </ul>
</div>
</template>

<style scoped>

</style>
<script>
module.exports = {

  props: ["type"],
  methods:
  {
  },

}
</script>