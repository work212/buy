<?php
include('db_common.php');

if ($type == "select") {

    $sql = "";
    if(isset($_REQUEST['date'])) $sql = "where start_date < '{$_REQUEST['date']}' and end_date > '{$_REQUEST['date']}'";
$str =<<<__LONG_STRRING__
SELECT *,task.name as task,task_category.name as task_category,goal.name as goal,
task_status.name as task_status 
FROM task
INNER JOIN task_category ON task.task_category_id = task_category.task_category_id
INNER JOIN goal ON task.goal_id = goal.goal_id
INNER JOIN task_status ON task.task_status_id = task_status.task_status_id
{$sql}
__LONG_STRRING__;
//print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

            $kekka[] = array(
                "task_id" => $row['task_id'],
                "name" => $row['task'],
                "task_category_id" => $row['task_category_id'],
                "task_category" => $row['task_category'],
                "goal_id" => $row['goal_id'],
                "goal" => $row['goal'],
                "start_date" => $row['start_date'],
                "end_date" => $row['end_date'],
                "task_status_id" => $row['task_status_id'],
                "status" => $row['task_status']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

$str =<<<__LONG_STRRING__
INSERT INTO task (
    name,start_date,end_date,task_category_id,goal_id
) VALUES (
    '{$_REQUEST['name']}','{$_REQUEST['start_date']}','{$_REQUEST['end_date']}',{$_REQUEST['task_category_id']},{$_REQUEST['goal_id']}
)
__LONG_STRRING__;
print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update") {

$str =<<<__LONG_STRRING__
UPDATE task SET 
name = '{$_REQUEST['name']}',
start_date = '{$_REQUEST['start_date']}',
end_date = '{$_REQUEST['end_date']}',
task_category_id = {$_REQUEST['task_category_id']},
goal_id = {$_REQUEST['goal_id']}
WHERE task_id = {$_REQUEST['task_id']}
__LONG_STRRING__;
print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();
} elseif ($type == "update_status") {

    $str =<<<__LONG_STRRING__
    UPDATE task SET 
    task_status_id = '{$_REQUEST['task_status_id']}'
    WHERE task_id = {$_REQUEST['task_id']}
    __LONG_STRRING__;
    print $str;
        $stmt = $pdo->prepare($str);
        $res = $stmt->execute();
    
} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM task 
    WHERE task_id = :task_id");

    $stmt->bindValue(':task_id', $_REQUEST['task_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
