<?php
include('db_common.php');

if ($type == "select") {

$str =<<<__LONG_STRRING__
SELECT * FROM goal
__LONG_STRRING__;
//print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

            $kekka[] = array(
                "goal_id" => $row['goal_id'],
                "name" => $row['name']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

$str =<<<__LONG_STRRING__
INSERT INTO goal (
    name
) VALUES (
    '{$_REQUEST['name']}'
)
__LONG_STRRING__;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update") {

$str =<<<__LONG_STRRING__
UPDATE goal SET 
name = '{$_REQUEST['name']}'
WHERE goal_id = {$_REQUEST['goal_id']}
__LONG_STRRING__;
//print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM goal 
    WHERE goal_id = :goal_id");

    $stmt->bindValue(':goal_id', $_REQUEST['goal_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
