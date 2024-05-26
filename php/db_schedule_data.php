<?php
include('db_common.php');

if ($type == "select") {

$str =<<<__LONG_STRRING__
SELECT *,schedule_category.name as category_name,spot.name as spot_name 
FROM schedule_data
LEFT JOIN spot ON spot.spot_id = schedule_data.spot_id
LEFT JOIN schedule_category ON schedule_category.schedule_category_id = schedule_data.schedule_category_id
where date like "{$_REQUEST['target_month']}%"
ORDER BY date
__LONG_STRRING__;
//print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    $kekka = [];
    if ($res) {
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
            $kekka[] = array(
                "schedule_data_id" => $row['schedule_data_id'],
                "title" => $row['title'],
                "name" => $row['spot_name'],
                "category_name" => $row['category_name'],
                "detail" => $row['detail'],
                "dialy" => $row['dialy'],
                "schedule_category_id" => $row['schedule_category_id'],
                "schedule_status_id" => $row['schedule_status_id'],
                "spot_id" => $row['spot_id'],
                "date" => $row['date']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

    $str =<<<__LONG_STRRING__
    INSERT INTO schedule_data (
        title,detail,dialy,schedule_category_id,schedule_status_id,spot_id,date
    ) VALUES (
        '{$_REQUEST['title']}','{$_REQUEST['detail']}','{$_REQUEST['dialy']}',
        {$_REQUEST['schedule_category_id']},{$_REQUEST['schedule_status_id']},{$_REQUEST['spot_id']},'{$_REQUEST['date']}'
    )
    __LONG_STRRING__;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update") {

$str =<<<__LONG_STRRING__
UPDATE schedule_data SET 
title = '{$_REQUEST['title']}',
detail = '{$_REQUEST['detail']}',
dialy = '{$_REQUEST['dialy']}',
schedule_category_id = {$_REQUEST['schedule_category_id']},
schedule_status_id = {$_REQUEST['schedule_status_id']},
spot_id = {$_REQUEST['spot_id']},
date = '{$_REQUEST['date']}'
WHERE schedule_data_id = {$_REQUEST['schedule_data_id']}
__LONG_STRRING__;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("delete from schedule_data 
    WHERE schedule_data_id = :schedule_data_id");
    $stmt->bindValue(':schedule_data_id', $_REQUEST['schedule_data_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
