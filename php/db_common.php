<?php
$db_status = 0;
//API
if(!@$_REQUEST['type']){
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
}else{
    $type = $_REQUEST['type'];
}

$dsn = 'mysql:host=localhost;dbname=matiday1_base;charset=utf8mb4';
$db_user = 'matiday1_admin';
$db_pass = 'ms1357';
$driver_options = [];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $driver_options);
} catch (PDOException $e) {
    $db_status = 1;
    exit('error');
}
