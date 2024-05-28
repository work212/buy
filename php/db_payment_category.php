<?php
include('db_common.php');

if ($type == "select") {

$str =<<<__LONG_STRRING__
SELECT * FROM payment_category 
WHERE payment_type = {$_REQUEST['payment_type']}
ORDER BY sort_no
__LONG_STRRING__;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    if ($res) {
        $kekka= [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
            
            $kekka[] = array(
                "payment_category_id" => $row['payment_category_id'],
                "name" => $row['name'],
                "payment_type" => $row['payment_type'],
                "sort_no" => $row['sort_no']
            );
        }
        header('Content-type: application/json');
        if($kekka) echo json_encode($kekka);
        //var_dump($data);
    }

} elseif ($type == "insert") {

    $stmt = $pdo->prepare("INSERT INTO payment_category (
        name,payment_type,sort_no
    ) VALUES (
        :name,:payment_type,:sort_no
    )");
    $query = json_decode($_REQUEST['query']);
    $stmt->bindValue(':name', $query->name, PDO::PARAM_STR);
    $stmt->bindValue(':payment_type', $query->payment_type, PDO::PARAM_INT);
    $stmt->bindValue(':sort_no', $query->sort_no, PDO::PARAM_INT);
    $res = $stmt->execute();

} elseif ($type == "update") {

    $stmt = $pdo->prepare("UPDATE payment_category SET 
    name = :name ,
    sort_no = :sort_no 
    WHERE payment_category_id = :payment_category_id");


$query = json_decode($_REQUEST['query']);
$stmt->bindValue(':name', $query->name, PDO::PARAM_STR);
$stmt->bindValue(':sort_no', $query->sort_no, PDO::PARAM_INT);
    $stmt->bindValue(':payment_category_id', $_REQUEST['payment_category_id'], PDO::PARAM_INT);
    $res = $stmt->execute();

} elseif ($type == "sort") {

    if ($_REQUEST['moto_sort_no'] > $_REQUEST['sort_no']) {
        $sql = "sort_no = sort_no + 1";
        $sql2 = "and sort_no <  {$_REQUEST['moto_sort_no']} and sort_no >=  {$_REQUEST['sort_no']}";
    } else {
        $no = $_REQUEST['sort_no'];
        $sql = "sort_no = sort_no - 1";
        $sql2 = "and sort_no >  {$_REQUEST['moto_sort_no']} and sort_no <=  {$no}";
    }

$str = <<<__LONG_STRRING__
UPDATE payment_category SET 
{$sql}
WHERE payment_category_id != {$_REQUEST['payment_category_id']}
{$sql2}
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "sort_delete") {

$str = <<<__LONG_STRRING__
UPDATE payment_category SET 
sort_no = sort_no - 1
WHERE sort_no > {$_REQUEST['sort_no']}
and payment_type = {$_REQUEST['payment_type']}
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();


} elseif ($type == "delete") {

$str =<<<__LONG_STRRING__
DELETE FROM payment_category 
WHERE payment_category_id = {$_REQUEST['payment_category_id']}
__LONG_STRRING__;
    print $str;
        $stmt = $pdo->prepare($str);
    $res = $stmt->execute();



}

// 接続を閉じます
$pdo = null;
