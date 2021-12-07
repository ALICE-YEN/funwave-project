<!--    待研究modal跳出已成功修改。好像是jQuery 可以看看filtering、event-->

<?php
require_once ("pdo-connect.php");

$order_id=$_POST["order_id"];
$payment=$_POST["payment"];
$receiver=$_POST["receiver"];
$receiver_phone=$_POST["receiver_phone"];
$address=$_POST["address"];
$convenient_store=$_POST["convenient_store"];
if ($_POST["delivery"]==="#delivery1"):
    $delivery="宅配到府";
    $convenient_store="";
else:
    $delivery="超商取貨";
    $address="";
endif;
$payment=$_POST["payment"];
$payment_status=$_POST["payment_status"];
$status=$_POST["status"];

$sqlOrderList="UPDATE order_list SET delivery='$delivery', receiver='$receiver', receiver_phone='$receiver_phone', address='$address', convenient_store='$convenient_store', status='$status', payment='$payment', payment_status='$payment_status'  WHERE id='$order_id'";
$stmtOrderList=$db_host->prepare($sqlOrderList);
//var_dump($stmtOrderList);
try{
    $stmtOrderList->execute();
    $orderCount=$stmtOrderList->rowCount();
     echo "修改資料完成";
//    header("location: order-edit.php?order_id=".$order_id);
}catch (PDOException $e){
    echo "修改資料錯誤: ".$e->getMessage();
}
?>