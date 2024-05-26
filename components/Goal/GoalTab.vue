
<template>
<div id="BuyTab" class="sub_tab">
  <header>
    <ul>
    <li :class="{'active': type == 'goal_top'}"><a href="./index.html#/goal_top">TOP</a></li>
    <li :class="{'active': type == 'goal_add'}"><a href="./index.html#/goal_add">ゴール</a></li>
    <li :class="{'active': type == 'goal_todo'}"><a href="./index.html#/goal_todo">TODO</a></li>
    <li :class="{'active': type == 'goal_task'}"><a href="./index.html#/goal_task">タスク</a></li>
    <li :class="{'active': type == 'goal_list'}"><a href="./index.html#/goal_list">リスト</a></li>
    <li :class="{'active': type == 'goal_graf'}"><a href="./index.html#/goal_graf">達成度</a></li>
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