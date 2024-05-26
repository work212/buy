
<template>
<div id="BuyTab" class="sub_tab">
  <header>
    <ul>
    <li :class="{'active': type == 'menu_list'}"><a href="./index.html#/menu_list">献立</a></li>
    <li :class="{'active': type == 'menu_stock'}"><a href="./index.html#/menu_stock">在庫</a></li>
    <li :class="{'active': type == 'menu_reshipi'}"><a href="./index.html#/menu_reshipi">レシピ</a></li>
  </ul>
  </header>
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