<template>
  <div id="todoBox">
    <todo-tab v-bind:type="type"></todo-tab>
    <div id="todoAddBox" class="red">

</div>
  </div>
</template>

<style scoped>
#todoAddBox {
  margin-top: 60px;

  .day {
    width: 40px;
  }

  .category {
    width: 80px;
  }

  .money {
    width: 80px;
  }

  .detail {
    width: 400px;
  }

  ul li {
    overflow: hidden;
    margin-bottom: 4px;
  }

  ul li div {
    padding: 0 4px;
    float: left;
  }

  ul li.th div {
    text-align: center;
    font-weight: 600;
    color: #999;
  }

  input {
    width: 100%;
    height: 26px;
    border-color: #999;
  }

  ul li.todoAdd {
    margin-bottom: 16px;
  }

  ul li.todoAdd div input {
    border: #ee8992 1px solid;

  }

}

.button {
  width: 100px;
}

.todo_del_button {
  height: 20px;
  width: 100%;
  margin: 2px 0;

  img {
    height: 100%;
    width: auto;
  }
}
</style>


<script>
module.exports = {
  data: function () {
    return {
      type: 'goal_graf'
    }
  },
  components: {
    'todo-tab': httpVueLoader('./GoalTab.vue')
  },
  beforeMount: function () {

  },
  methods: {

  },

  computed: {

  },
  watch: {

  }
}
</script>
