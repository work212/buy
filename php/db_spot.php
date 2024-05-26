<?php
include('db_common.php');

if ($type == "select") {

$str =<<<__LONG_STRRING__
SELECT * FROM spot
__LONG_STRRING__;
//print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

            $kekka[] = array(
                "spot_id" => $row['spot_id'],
                "name" => $row['name'],
                "area" => $row['area'],
                "capa" => $row['capa'],
                "capa_stand" => $row['capa_stand'],
                "url" => $row['url'],
                "memo" => $row['memo']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

$str =<<<__LONG_STRRING__
INSERT INTO spot (
    name,area,capa,capa_stand,memo
) VALUES (
    '{$_REQUEST['name']}','{$_REQUEST['area']}',
    '{$_REQUEST['capa']}','{$_REQUEST['capa_stand']}','{$_REQUEST['memo']}'
)
__LONG_STRRING__;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update") {

$str =<<<__LONG_STRRING__
UPDATE spot SET 
name = '{$_REQUEST['name']}' ,
area = '{$_REQUEST['area']}',
capa = '{$_REQUEST['capa']}' ,
capa_stand = '{$_REQUEST['capa_stand']}' ,
memo = '{$_REQUEST['memo']}' 
WHERE spot_id = {$_REQUEST['spot_id']}
__LONG_STRRING__;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM spot 
    WHERE spot_id = :spot_id");

    $stmt->bindValue(':spot_id', $_REQUEST['spot_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
