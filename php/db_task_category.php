<?php
include('db_common.php');

if ($type == "select") {

$str =<<<__LONG_STRRING__
SELECT * FROM task_category
__LONG_STRRING__;

        $stmt = $pdo->prepare($str);

    $res = $stmt->execute();

    // (6) 該当するデータを取得
    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

            $kekka[] = array(
                "task_category_id" => $row['task_category_id'],
                "name" => $row['name']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

    $stmt = $pdo->prepare("INSERT INTO task_category (
        name
    ) VALUES (
        :name
    )");
    $stmt->bindValue(':name', $_REQUEST['name'], PDO::PARAM_STR);
    $res = $stmt->execute();

} elseif ($type == "update") {

    $stmt = $pdo->prepare("UPDATE task_category SET 
    name = :name 
    WHERE task_category_id = :task_category_id");

    $stmt->bindValue(':name', $_REQUEST['name'], PDO::PARAM_STR);
    $stmt->bindValue(':task_category_id', $_REQUEST['task_category_id'], PDO::PARAM_INT);
    $res = $stmt->execute();
print_r($res);

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM task_category 
    WHERE task_category_id = :task_category_id");

    $stmt->bindValue(':task_category_id', $_REQUEST['task_category_id'], PDO::PARAM_INT);
    $res = $stmt->execute();
    print_r($res);
}

// 接続を閉じます
$pdo = null;
