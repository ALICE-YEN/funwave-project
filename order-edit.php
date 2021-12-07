<!--還沒做欄位檢查-->

<?php
require_once ("pdo-connect.php");

if(isset($_GET["order_id"])){
    $order_id=$_GET["order_id"];
}else{
    $order_id=0;
}
$sqlOrderList="SELECT * FROM order_list WHERE id='$order_id'";
$stmtOrderList=$db_host->prepare($sqlOrderList);
try{
    $stmtOrderList->execute();
    $rowOrderList=$stmtOrderList->fetchAll(PDO::FETCH_ASSOC);
    $orderCount=$stmtOrderList->rowCount();
}catch (PDOException $e){
    echo $e->getMessage();
}


?>

<!doctype html>
<html lang="en">
<head>
    <title>Order edit</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                    <form action="doUpdateOrder.php" method="post" class="m-3">
                        <?php foreach ($rowOrderList as $value): ?>
                            <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="">訂單編號</label>
                                    <input id="" type="number" name="order_id" class="form-control" value="<?=$value["id"]?>" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="">會員編號</label>
                                    <input id="" type="number" name="member_id" class="form-control" value="<?=$value["member_id"]?>" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="">訂單總金額</label>
                                    <input id="" type="number" name="amount" class="form-control" value="<?=$value["amount"]?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="receiver">收件人姓名</label>
                            <input id="receiver" type="text" name="receiver" class="form-control" value="<?=$value["receiver"]?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="receiver_phone">收件人電話</label>
                            <input id="receiver_phone" type="number" name="receiver_phone" class="form-control" value="<?=$value["receiver_phone"]?>" required>
                        </div>
<!--                    依送貨方式，對應顯現收件人地址or超商門市-->
                        <div class="mb-3">
                            <div>送貨方式</div>
                            <select class="form-select" aria-label="delivery select" name="delivery" id="delivery_select">
                                <option value="#delivery1" <?php if ($value["delivery"]==="宅配到府")echo "selected" ?>>宅配到府</option>
                                <option value="#delivery2" <?php if ($value["delivery"]==="超商取貨")echo "selected" ?>>超商取貨</option>
                            </select>
                        </div>
                        <div class="mb-3" id="delivery1">
                            <label for="address">收件人地址</label>
                            <input id="address" type="text" name="address" class="form-control" value="<?=$value["address"]?>" required>
                        </div>
                        <div class="mb-3" id="delivery2">
                            <div>超商門市</div>
                            <select class="form-select" aria-label="convenient_store select" name="convenient_store">
                                <option value="一零一門市" <?php if ($value["convenient_store"]==="一零一門市")echo "selected" ?>>一零一門市</option>
                                <option value="中興門市" <?php if ($value["convenient_store"]==="中興門市")echo "selected" ?>>中興門市</option>
                                <option value="世貿門市" <?php if ($value["convenient_store"]==="世貿門市")echo "selected" ?>>世貿門市</option>
                                <option value="湯圍門市" <?php if ($value["convenient_store"]==="湯圍門市")echo "selected" ?>>湯圍門市</option>
                                <option value="上美崙門市" <?php if ($value["convenient_store"]==="上美崙門市")echo "selected" ?>>上美崙門市</option>
                                <option value="東大門市" <?php if ($value["convenient_store"]==="東大門市")echo "selected" ?>>東大門市</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div>付款方式</div>
                            <select class="form-select" aria-label="payment select" name="payment">
                                <option value="信用卡" <?php if ($value["payment"]==="信用卡")echo "selected" ?>>信用卡</option>
                                <option value="貨到付款" <?php if ($value["payment"]==="貨到付款")echo "selected" ?>>貨到付款</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div>付款狀態</div>
                            <select class="form-select" aria-label="payment_status select" name="payment_status">
                                <option value="未付款" <?php if ($value["payment_status"]==="未付款")echo "selected" ?>>未付款</option>
                                <option value="已付款" <?php if ($value["payment_status"]==="已付款")echo "selected" ?>>已付款</option>
                                <option value="退款中" <?php if ($value["payment_status"]==="退款中")echo "selected" ?>>退款中</option>
                                <option value="已退款" <?php if ($value["payment_status"]==="已退款")echo "selected" ?>>已退款</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div>訂單狀態</div>
                            <select class="form-select" aria-label="status select" name="status">
                                <option value="訂單處理中" <?php if ($value["status"]==="訂單處理中")echo "selected" ?>>訂單處理中</option>
                                <option value="訂單已完成" <?php if ($value["status"]==="訂單已完成")echo "selected" ?>>訂單已完成</option>
                                <option value="訂單已取消" <?php if ($value["status"]==="訂單已取消")echo "selected" ?>>訂單已取消</option>
                            </select>
                        </div>
                        <?php endforeach; ?>
                        <button class="btn btn-primary" type="submit">送出更新</button>
                    </form>
            </div>
        </div>
    </div>


<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script>
        // 依送貨方式，對應顯現收件人地址or超商門市
        <?php if (isset($value["delivery"]) && ($value["delivery"]==="宅配到府")): ?>
            $('div[id="delivery2"]').hide();
        <?php else:?>
            $('div[id="delivery1"]').hide();
        <?php endif; ?>

        $('#delivery_select').change(function(){
            let deliveryValue=$(this).val();
            // console.log(deliveryValue);
            $('div[id^="delivery"]').hide();
            $(deliveryValue).show();
        });
    </script>
</body>
</html>