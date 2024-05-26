<?php
include('db_common.php');

if ($type == "select") {

$str =<<<__LONG_STRRING__
SELECT * FROM todo_interval
__LONG_STRRING__;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    // (6) 該当するデータを取得
    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

            $kekka[] = array(
                "todo_interval_id" => $row['todo_interval_id'],
                "name" => $row['name']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

    $stmt = $pdo->prepare("INSERT INTO todo_interval (
        name
    ) VALUES (
        :name
    )");
    $stmt->bindValue(':name', $_REQUEST['name'], PDO::PARAM_STR);
    $res = $stmt->execute();

} elseif ($type == "update") {

    $stmt = $pdo->prepare("UPDATE todo_interval SET 
    name = :name
    WHERE todo_interval_id = :todo_interval_id");

    $stmt->bindValue(':todo_interval_id', $_REQUEST['todo_interval_id'], PDO::PARAM_INT);
    $res = $stmt->execute();
print_r($res);

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM todo_interval 
    WHERE todo_interval_id = :todo_interval_id");

    $stmt->bindValue(':todo_interval_id', $_REQUEST['todo_interval_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
