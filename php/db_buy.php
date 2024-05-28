<?php
include('db_common.php');

if ($type == "select") {

    $sql = "";
    if (isset($_REQUEST['status'])){
        $sql = "where status = '{$_REQUEST['status']}'";
        $sql2 = "order by status_sort_no";
    }else{
        $sql2 = "order by sort_no";
    }

$str = <<<__LONG_STRRING__
SELECT * FROM buy
$sql
$sql2
__LONG_STRRING__;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    if ($res) {
        $kekka = [];
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {

            $kekka[] = array(
                "buy_id" => $row['buy_id'],
                "name" => $row['name'],
                "status" => $row['status'],
                "buy_category_id" => $row['buy_category_id'],
                "sort_no" => $row['sort_no'],
                "status_sort_no" => $row['status_sort_no']
            );
        }
        header('Content-type: application/json');
        if ($kekka) echo json_encode($kekka);

    }

} elseif ($type == "insert") {

$str = <<<__LONG_STRRING__
INSERT INTO buy (
    name,status,buy_category_id,status_sort_no,sort_no
) VALUES (
    '{$_REQUEST['name']}',{$_REQUEST['status']},
    0,{$_REQUEST['status_sort_no']},{$_REQUEST['sort_no']}
)
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update") {

    $sql = "";
    if (isset($_REQUEST['status_sort_no'])) $sql .= ",status_sort_no = {$_REQUEST['status_sort_no']}";
    if (isset($_REQUEST['sort_no'])) $sql .= ",sort_no = {$_REQUEST['sort_no']}";

    $str = <<<__LONG_STRRING__
UPDATE buy SET 
name = '{$_REQUEST['name']}'
{$sql}
WHERE buy_id = {$_REQUEST['buy_id']}
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "update_sort") {

    $sql = "";
    if (isset($_REQUEST['status_sort_no'])) $sql = ",status_sort_no = {$_REQUEST['status_sort_no']}";

$str = <<<__LONG_STRRING__
UPDATE buy SET 
status = {$_REQUEST['status']}
{$sql}
WHERE buy_id = {$_REQUEST['buy_id']}
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "sort") {

    $str = <<<__LONG_STRRING__
UPDATE buy SET 
status_sort_no = status_sort_no + 1
WHERE status = {$_REQUEST['status']}
and status_sort_no >=  {$_REQUEST['target_sort']}
and buy_id != {$_REQUEST['no_target']}
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

    if ($_REQUEST['status'] == 1) {
        $status = 2;
    } else {
        $status = 1;
    }

$str = <<<__LONG_STRRING__
UPDATE buy SET 
status_sort_no = status_sort_no - 1
WHERE status = {$status}
and status_sort_no >  {$_REQUEST['moto_no']}
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "sort2") {

    if ($_REQUEST['moto_no'] > $_REQUEST['target_sort']) {
        $sql = "status_sort_no = status_sort_no + 1";
        $sql2 = "and status_sort_no <  {$_REQUEST['moto_no']} and status_sort_no >=  {$_REQUEST['target_sort']}";
    } else {
        $no = $_REQUEST['target_sort'];
        $sql = "status_sort_no = status_sort_no - 1";
        $sql2 = "and status_sort_no >  {$_REQUEST['moto_no']} and status_sort_no <=  {$no}";
    }

$str = <<<__LONG_STRRING__
UPDATE buy SET 
{$sql}
WHERE status = {$_REQUEST['status']}
and buy_id != {$_REQUEST['no_target']}
{$sql2}
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "sort_delete") {

$str = <<<__LONG_STRRING__
UPDATE buy SET 
sort_no = sort_no - 1
WHERE sort_no > {$_REQUEST['sort_no']}
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

$str = <<<__LONG_STRRING__
UPDATE buy SET 
status_sort_no = status_sort_no - 1
WHERE status_sort_no > {$_REQUEST['status_sort_no']}
and status = {$_REQUEST['status']}
__LONG_STRRING__;
print $str;

    $stmt = $pdo->prepare($str);
    $res = $stmt->execute();

} elseif ($type == "delete") {

    $stmt = $pdo->prepare("DELETE FROM buy WHERE buy_id = :buy_id");

    $stmt->bindValue(':buy_id', $_REQUEST['buy_id'], PDO::PARAM_INT);
    $res = $stmt->execute();
    print $res;
}

$pdo = null;
