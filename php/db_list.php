<?php
include('db_common.php');

if ($type == "select" || $type == "select_type") {

$str =<<<__LONG_STRRING__
SELECT *,list.name as list,list_category.name as list_category
FROM list
INNER JOIN list_category ON list.list_category_id = list_category.list_category_id
order by list.list_category_id
__LONG_STRRING__;
//print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

if($type == "select_type"){
    $kekka[$row['list_category']][] = array(
        "list_id" => $row['list_id'],
        "name" => $row['list'],
        "list_category_id" => $row['list_category_id'],
        "list_category" => $row['list_category'],
        "list_date" => $row['list_date']
    );
}else{
            $kekka[] = array(
                "list_id" => $row['list_id'],
                "name" => $row['list'],
                "list_category_id" => $row['list_category_id'],
                "list_category" => $row['list_category'],
                "list_date" => $row['list_date']
            );
        }
    }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

$str =<<<__LONG_STRRING__
INSERT INTO list (
    name,list_category_id
) VALUES (
    '{$_REQUEST['name']}',{$_REQUEST['list_category_id']}
)
__LONG_STRRING__;
print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update") {

$str =<<<__LONG_STRRING__
UPDATE list SET 
name = '{$_REQUEST['name']}',
list_category_id = {$_REQUEST['list_category_id']},
list_date = '{$_REQUEST['list_date']}'
WHERE list_id = {$_REQUEST['list_id']}
__LONG_STRRING__;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update_comp") {

    
    if($_REQUEST['list_date']){
        $sql = "list_date = '{$_REQUEST['list_date']}'";
    }else{
        $sql = "list_date = null";
    }
    $str =<<<__LONG_STRRING__
    UPDATE list SET 
    $sql
    WHERE list_id = {$_REQUEST['list_id']}
    __LONG_STRRING__;
    print $str;
        $stmt = $pdo->prepare($str);
        $res = $stmt->execute();

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM list 
    WHERE list_id = :list_id");

    $stmt->bindValue(':list_id', $_REQUEST['list_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
