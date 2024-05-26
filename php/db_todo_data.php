<?php
include('db_common.php');

if ($type == "select") {

    $sql = "";
    if($_REQUEST['todo_interval_id'] != 5) $sql = " and todo_data_date BETWEEN '" . $_REQUEST['start_date'] . "' AND '" . $_REQUEST['end_date'] . "'";

$str =<<<__LONG_STRRING__
SELECT * FROM todo_data
INNER JOIN todo ON todo_data.todo_id = todo.todo_id
INNER JOIN todo_interval ON todo.todo_interval_id = todo_interval.todo_interval_id
where todo_interval.todo_interval_id = {$_REQUEST['todo_interval_id']}
{$sql}
__LONG_STRRING__;
//print $str;
        $stmt = $pdo->prepare($str);

    $res = $stmt->execute();

    // todo_idで整える
    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

            $kekka[$row['todo_id']] = array(
                "todo_id" => $row['todo_id'],
                "todo_data_id" => $row['todo_data_id']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

$str =<<<__LONG_STRRING__
    INSERT INTO todo_data (
        todo_id,todo_data_date
    ) VALUES (
        {$_REQUEST['todo_id']},"{$_REQUEST['todo_data_date']}"
    )
__LONG_STRRING__;
print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update") {

    $stmt = $pdo->prepare("UPDATE todo_data SET 
    todo_data_status = :todo_data_status
    WHERE todo_id = :todo_id");

    $stmt->bindValue(':todo_data_status', $_REQUEST['todo_data_status'], PDO::PARAM_INT);
    $stmt->bindValue(':todo_id', $_REQUEST['todo_id'], PDO::PARAM_INT);
    $res = $stmt->execute();
print_r($res);
} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM todo_data 
    WHERE todo_data_id = :todo_data_id");

    $stmt->bindValue(':todo_data_id', $_REQUEST['todo_data_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
