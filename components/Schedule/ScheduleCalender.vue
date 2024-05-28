<template>
  <div>
    <div v-for="item, index in disp_list" :key="index">
      <div v-on:click="modalEdit(item)">{{ item.title }} 編集</div>
      <div v-on:click="del(item)">{{ item.name }} </div>
      <div>{{ item.detail | omittedText20 }}</div>
      <div>{{ item.dialy }}</div>
      <div>{{ item.date }}</div>
    </div>

  </div>

</template>
<script>
module.exports = {

  props: ["disp_list"],
  methods:
  {
    modalEdit: function (item) {
      this.$emit('childs-event-modal', item);
    },
    del: function (item) {
      this.$emit('childs-event-del', item);
    },
  },


}
</script>