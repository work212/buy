
<template>
<div id="ScheduleTab" class="sub_tab">
  <header>
    <ul>
    <li :class="{'active': type == 'schedule'}"><a href="./index.html#/schedule/1">一覧</a></li>
    <li :class="{'active': type == 'schedule_spot'}"><a href="./index.html#/schedule_spot">会場</a></li>
    <li :class="{'active': type == 'schedule_category'}"><a href="./index.html#/schedule_category">カテゴリー</a></li>
    <li :class="{'active': type == 'schedule_status'}"><a href="./index.html#/schedule_status">ステータス</a></li>
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