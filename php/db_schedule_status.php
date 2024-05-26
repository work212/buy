<?php
include('db_common.php');

if ($type == "select") {

$str =<<<__LONG_STRRING__
SELECT * FROM schedule_status
__LONG_STRRING__;
//print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    $kekka = [];
    if ($res) {
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
            $kekka[] = array(
                "schedule_status_id" => $row['schedule_status_id'],
                "name" => $row['name']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

    $stmt = $pdo->prepare("INSERT INTO schedule_status (
        name
    ) VALUES (
        :name
    )");

    $stmt->bindValue(':name', $_REQUEST['name'], PDO::PARAM_STR);
    $res = $stmt->execute();

} elseif ($type == "update") {

    $str =<<<__LONG_STRRING__
    UPDATE schedule_status SET 
    name = '{$_REQUEST['name']}'
    WHERE schedule_status_id = {$_REQUEST['schedule_status_id']}
__LONG_STRRING__;
print $str;
    $stmt = $pdo->prepare($str);
$res = $stmt->execute();

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM schedule_status 
    WHERE schedule_status_id = :schedule_status_id");
    
    $stmt->bindValue(':schedule_status_id', $_REQUEST['schedule_status_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
