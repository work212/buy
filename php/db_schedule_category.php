<?php
include('db_common.php');

if ($type == "select") {

$str =<<<__LONG_STRRING__
SELECT * FROM schedule_category
__LONG_STRRING__;
//print $str;

$stmt = $pdo->prepare($str);
$res = $stmt->execute();
$kekka = [];
    if ($res) {
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
            $kekka[] = array(
                "schedule_category_id" => $row['schedule_category_id'],
                "name" => $row['name']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

$str =<<<__LONG_STRRING__
INSERT INTO schedule_category (
    name
) VALUES (
    '{$_REQUEST['name']}'
)
__LONG_STRRING__;
print $str;

   $stmt = $pdo->prepare($str);
   $res = $stmt->execute();

} elseif ($type == "update") {

    $stmt = $pdo->prepare("UPDATE schedule_category SET 
    name = :name 
    WHERE schedule_category_id = :schedule_category_id");

    $stmt->bindValue(':name', $_REQUEST['name'], PDO::PARAM_STR);
    $stmt->bindValue(':schedule_category_id', $_REQUEST['schedule_category_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

} elseif ($type == "delete") {
$str =<<<__LONG_STRRING__
DELETE from schedule_category 
where schedule_category_id = {$_REQUEST['schedule_category_id']}
__LONG_STRRING__;

    print $str;
    $stmt = $pdo->prepare($str);
$res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
