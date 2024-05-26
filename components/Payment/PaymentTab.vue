
<template>
<div id="PaymentTab" class="sub_tab">
  <header>
    <ul>
    <li :class="{'active': type == 'payment' && id == 1}"><a href="./index.html#/payment/1">支出</a></li>
    <li :class="{'active': type == 'payment' && id == 2}"><a href="./index.html#/payment/2">収入</a></li>
    <li :class="{'active': type == 'payment_sum'}"><a href="./index.html#/payment_sum">集計</a></li>
    <li :class="{'active': type == 'payment_add'}"><a href="./index.html#/payment_add">カテゴリ追加</a></li>
  </ul>
  </header>
</div>
</template>

<style scoped>

</style>
<script>
module.exports = {

  props: ["type","id"],
  methods:
  {
  },

}
</script>