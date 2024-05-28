<?php
include('db_common.php');

if ($type == "select") {

    $sql = "";
    if(isset($_REQUEST['todo_interval_id'])) $sql = " where todo.todo_interval_id = {$_REQUEST['todo_interval_id']}";

$str =<<<__LONG_STRRING__
SELECT *,todo_interval.name as todo_interval,goal.name as goal_name,todo.name as name
FROM todo
INNER JOIN todo_interval ON todo.todo_interval_id = todo_interval.todo_interval_id
INNER JOIN goal ON todo.goal_id = goal.goal_id
{$sql}
__LONG_STRRING__;

        $stmt = $pdo->prepare($str);

    $res = $stmt->execute();

    // (6) 該当するデータを取得
    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

            $kekka[] = array(
                "todo_id" => $row['todo_id'],
                "name" => $row['name'],
                "goal_name" => $row['goal_name'],
                "goal_id" => $row['goal_id'],
                "todo_interval_id" => $row['todo_interval_id'],
                "todo_interval" => $row['todo_interval'],
                "detail" => $row['detail']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

$str =<<<__LONG_STRRING__
INSERT INTO todo (
    name,goal_id,todo_interval_id,detail
) VALUES (
    '{$_REQUEST['name']}',{$_REQUEST['goal_id']},
    {$_REQUEST['todo_interval_id']},'{$_REQUEST['detail']}'
)
__LONG_STRRING__;
print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update") {

    $str =<<<__LONG_STRRING__
    UPDATE todo SET 
    name = '{$_REQUEST['name']}' ,
    goal_id = {$_REQUEST['goal_id']},
    todo_interval_id = {$_REQUEST['todo_interval_id']},
    detail = '{$_REQUEST['detail']}' 
    WHERE todo_id = {$_REQUEST['todo_id']}
    __LONG_STRRING__;
    print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();
print_r($res);

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM todo 
    WHERE todo_id = :todo_id");

    $stmt->bindValue(':todo_id', $_REQUEST['todo_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
