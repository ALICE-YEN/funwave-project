<!--    待研究modal跳出已成功刪除。好像是jQuery 可以看看filtering、event-->

<?php
require_once ("pdo-connect.php");

$order_id=$_GET["order_id"];
//軟性刪除，訂單狀態=訂單已取消
$status="訂單已取消";
$sqlOrderList="UPDATE order_list SET status='$status' WHERE id='$order_id'";
//硬性刪除，將資料庫資料刪除
//$sqlOrderList="DELETE FROM order_list WHERE id='$order_id'";

$stmtOrderList=$db_host->prepare($sqlOrderList);
try{
    $stmtOrderList->execute();
    $orderCount=$stmtOrderList->rowCount();
     echo "資料移除完成";
//    header("location: order-edit.php?order_id=".$order_id);
}catch (PDOException $e){
    echo "資料移除錯誤: ".$e->getMessage();
}
?>
