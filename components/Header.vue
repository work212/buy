
<template>
<header>

    <ul id="header">
    <li :class="{'active': root_type == 'buy'}"><a href="./index.html#/buy_list">
      <div class="header_img"><img src="./assets/img/buy.png"></div>
      <div class="header_title">買い物</div></a></li>
    <li :class="{'active': root_type == 'menu'}"><a href="./index.html#/menu_list"><div class="header_img"><img src="./assets/img/menu.png"></div><div class="header_title">献立</div></a></li>
    <li :class="{'active': root_type == 'payment'}"><a href="./index.html#/payment/1"><div class="header_img"><img src="./assets/img/payment.png"></div><div class="header_title">家計簿</div></a></li>
    <li :class="{'active': root_type == 'goal'}"><a href="./index.html#/goal_top"><div class="header_img"><img src="./assets/img/goal.png"></div><div class="header_title">目標</div></a></li>
    <li :class="{'active': root_type == 'schedule'}"><a href="./index.html#/schedule/1"><div class="header_img"><img src="./assets/img/schedule.png"></div><div class="header_title">推し活</div></a></li>
    <li><a href="https://www.notion.so/Wiki-74844c102b1743b894d263189a5607d8?pvs=4">aaa</a></li>
  </ul>

  </header>
</template>
<style scoped>

  header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 40px;
    background-color: #333;
    color: #FFFFFF;
    z-index:100;
  }

  header div {
    height: 100%;
   /* position: absolute;*/
  }

  header ul {
    position: relative;
    margin: 0;
    padding: 0;
    height: 100%;
    overflow: hidden;
  }

  header ul li {
    display: inline-block;
    height: 20px;
    text-align: center;
    margin: 10px;
    font-size: 14px;

  }

  header ul li a {
    height: 20px;
    display: block;
    line-height: 20px;
    text-decoration:none;
    overflow: hidden;
    color: rgb(238, 137, 146);
    font-weight: bold;;
  }
  header ul li a div{
    float:left;
  }
  .header_title{
    padding-top:4px;
  }

  header ul li img {
    height: 20px;
    width: auto;
    margin-right: 4px;
  }



</style>
<script>
module.exports = {

props: ["root_type"],
methods:
{

},


}
</script>
