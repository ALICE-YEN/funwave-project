<!--是否需要在資料表order-detail添加會員編號欄位-->

<?php
require_once ("pdo-connect.php");
$order_id=$_GET["order_id"]; //order id
$sqlOrder="SELECT * FROM order_list WHERE id=?";
$stmtOrder=$db_host->prepare($sqlOrder);
try{
    $stmtOrder->execute([$order_id]);
    $rowOrder=$stmtOrder->fetch();
}catch(PDOException $e){
    echo "取得訂單資訊錯誤<br>";
    echo $e->getMessage();
}

//join:user_order_detail、products
$sqlOrderProducts="SELECT order_details.*, products.*
FROM order_details
JOIN products ON order_details.product_id = products.product_id 
WHERE order_details.order_id=?";
$stmtOrderProducts=$db_host->prepare($sqlOrderProducts);
try{
    $stmtOrderProducts->execute([$order_id]);
    $rowsOrderProducts=$stmtOrderProducts->fetchAll(PDO::FETCH_ASSOC);
//    var_dump($rowsOrderProducts);
}catch(PDOException $e){
    echo "取得訂單細節錯誤<br>";
    echo $e->getMessage();
}
?>


<!doctype html>
<html lang="en">
<head>
    <title>Order detail</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <div class="container m-2">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>訂單編號</th>
<!--                    <th>會員編號</th>-->
                    <th>產品編號</th>
                    <th>產品名稱</th>
                    <th>產品圖片</th>
                    <th>單價</th>
                    <th>數量</th>
                    <th>小計</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rowsOrderProducts as $value): ?>
                <tr>
                    <td><?=$order_id?></td>
<!--                    <td>--><?//=$member_id?><!--</td>-->
                    <td><?=$value["product_id"]?></td>
                    <td><?=$value["product_name"]?></td>
                    <td><?=$value["image"]?></td>
                    <td class="text-end">$<?=$value["unit_price"]?></td>
                    <td class="text-end"><?=$value["quantity"]?></td>
                    <td class="text-end"><?php
                        $subtotal=$value["quantity"]*$value["unit_price"];
                        echo "$".$subtotal;
                        $total+=$subtotal;
                        ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td class="fw-bold">總計</td>
                <td class="text-end" colspan="6">$<?=$total?></td>
            </tr>
            </tfoot>
    </div>


<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>