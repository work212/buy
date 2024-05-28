<?php
include('db_common.php');

if ($type == "select") {

$str =<<<__LONG_STRRING__
SELECT * FROM menu_data
where menu_date like '{$_REQUEST['menu_date']}%'
__LONG_STRRING__;
//print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    // dateで整える
    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

            $pieces = explode("-", $row['menu_date']);
            $kekka[$pieces[2]] = array(
                "menu_data_id" => $row['menu_data_id'],
                "menu1" => $row['menu1'],
                "menu2" => $row['menu2'],
                "menu3" => $row['menu3'],
                "menu4" => $row['menu4'],
                "memo" => $row['memo'],
                "menu_date" => $pieces[2]
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

$str =<<<__LONG_STRRING__
INSERT INTO menu_data (
    menu1,menu2,menu3,menu4,memo,menu_date
) VALUES (
    "{$_REQUEST['menu1']}","{$_REQUEST['menu2']}","{$_REQUEST['menu3']}","{$_REQUEST['menu4']}"
    ,"{$_REQUEST['memo']}","{$_REQUEST['menu_date']}"
)
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update") {

    $str =<<<__LONG_STRRING__
    UPDATE menu_data SET 
    menu1 = '{$_REQUEST['menu1']}',
    menu2 = '{$_REQUEST['menu2']}',
    menu3 = '{$_REQUEST['menu3']}',
    menu4 = '{$_REQUEST['menu4']}',
    memo = '{$_REQUEST['memo']}'
    WHERE menu_data_id = {$_REQUEST['menu_data_id']}
    __LONG_STRRING__;
    
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();
    print_r($res);

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM task_data 
    WHERE task_data_id = :task_data_id");

    $stmt->bindValue(':task_data_id', $_REQUEST['task_data_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
