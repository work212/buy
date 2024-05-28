<?php

define("TESTFILE","./../data/memo/".$_REQUEST['type'].".txt");

if(isset($_REQUEST['input_val'])){
  $s = $_REQUEST['input_val'];
  //print_r("file_put_tcontents関数\n");
  file_put_contents(TESTFILE,$s);

  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: X-Requested-With, Origin, X-Csrftoken, Content-Type, Accept");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH, HEAD");

  echo($s);

}else{

  if (file_exists(TESTFILE)) {
    $content = file_get_contents(TESTFILE);
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: X-Requested-With, Origin, X-Csrftoken, Content-Type, Accept");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, CONNECT, OPTIONS, TRACE, PATCH, HEAD");
    echo($content);
  }

}
exit();
