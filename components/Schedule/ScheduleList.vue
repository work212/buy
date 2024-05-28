<template>
  <div>
    <table class="base_list">
      <tr>
        <th></th>
        <th>日付</th>
        <th>カテゴリ</th>
        <th>タイトル</th>
        <th>会場</th>
        <th>詳細</th>
        <th>日記</th>
        <th></th>
      </tr>
      <tr v-for="item, index in disp_list" :key="index">
        <td v-on:click="modalEdit(item)" class="edit_box"><img src="./assets/img/add_gray2.png" class="list_edit"></td>
        <td>{{ item.date }}</td>
        <td>{{ item.category_name }}</td>
        <td>{{ item.title }} </td>
        <td>{{ item.name }}</td>
        <td>{{ item.detail | omittedText20 }}</td>
        <td>
          <p v-if="item.dialy">あり</p>
        </td>
        <td v-on:click="del(item.schedule_data_id)" class="del_box"><img src="./assets/img/del_gray.png" class="list_del"></td>
      </tr>
    </table>


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