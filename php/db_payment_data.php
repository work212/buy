<?php
include('db_common.php');

if ($type == "select") {

    if(isset($_REQUEST['year_month'])){
        $target = $_REQUEST['year_month'];
    }else{
        $target = $_REQUEST['year'];
    }

    $sql = "";
    if(isset($_REQUEST['payment_type'])) $sql = " AND payment_type = {$_REQUEST['payment_type']}";

$str =<<<__LONG_STRRING__
SELECT *,payment_category.name as payment_category FROM payment_data 
INNER JOIN payment_category ON payment_data.payment_category_id = payment_category.payment_category_id
WHERE date like '{$target}%'
{$sql}
ORDER BY date
__LONG_STRRING__;
//print $str;
    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
            $aaa = explode("-",$row['date']);

            $kekka[] = array(
                "payment_data_id" => $row['payment_data_id'],
                "title" => $row['title'],
                "memo" => $row['memo'],
                "payment_category_id" => $row['payment_category_id'],
                "payment_category" => $row['payment_category'],
                "payment_type" => $row['payment_type'],
                "money" => $row['money'],
                "day" => $aaa[2],
                "month" => $aaa[1]
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

    $stmt = $pdo->prepare("INSERT INTO payment_data (
        title,payment_category_id,money,date
    ) VALUES (
        :title,:payment_category_id,:money,:date
    )");

    $query = json_decode($_REQUEST['query']);

    $stmt->bindValue(':title', $query->title, PDO::PARAM_STR);
    $stmt->bindValue(':payment_category_id', $query->payment_category_id, PDO::PARAM_INT);
    $stmt->bindValue(':money', $query->money, PDO::PARAM_INT);
    $stmt->bindValue(':date', $_REQUEST['year_month'] . '-' . $query->day, PDO::PARAM_STR);
    $res = $stmt->execute();

} elseif ($type == "update") {

    $stmt = $pdo->prepare("UPDATE payment_data SET 
    title = :title ,
    payment_category_id = :payment_category_id ,
    money = :money ,
    date = :date 
    WHERE payment_data_id = :payment_data_id");

    $query = json_decode($_REQUEST['query']);

    $stmt->bindValue(':title', $query->title, PDO::PARAM_STR);
    $stmt->bindValue(':payment_category_id', $query->payment_category_id, PDO::PARAM_INT);
    $stmt->bindValue(':money', $query->money, PDO::PARAM_INT);
    $stmt->bindValue(':date', $_REQUEST['year_month'] . '-' . $query->day, PDO::PARAM_STR);
    $stmt->bindValue(':payment_data_id', $_REQUEST['payment_data_id'], PDO::PARAM_INT);
    $res = $stmt->execute();
print_r($res);

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM payment_data 
    WHERE payment_data_id = :payment_data_id");

    $stmt->bindValue(':payment_data_id', $_REQUEST['payment_data_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

}

// 接続を閉じます
$pdo = null;
