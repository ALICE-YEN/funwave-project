<!--還沒做分頁、會員編號篩選、付款狀態篩選?訂單狀態篩選?。區間篩選待改-->


<?php
require_once ("pdo-connect.php");
$order_id=$_GET["order_id"]; //order id

//搜尋：訂單編號
if(isset($_GET["order_id"])){
    $order_id=$_GET["order_id"];
    $sqlOrderList="SELECT * FROM order_list WHERE id='$order_id'";
    $stmtOrderList=$db_host->prepare($sqlOrderList);
    try{
        $stmtOrderList->execute();
        $rowOrderList=$stmtOrderList->fetchAll(PDO::FETCH_ASSOC);
        $orderCount=$stmtOrderList->rowCount();
//        var_dump($rowOrderList);
//        var_dump(isset($order_id));
//        var_dump(empty($order_id));
        echo "order if";
//        時間區間還有很多bug要處理注意，有很多細節建議用網路上的套件！
        if(isset($_GET["startDate"])){
            $startDate=$_GET["startDate"];
            $endDate=$_GET["endDate"];
            $sqlOrderList="SELECT * FROM order_list WHERE id='$order_id' AND DATE(order_time) BETWEEN ? AND ? ORDER BY id ASC";
            $stmtOrderList=$db_host->prepare($sqlOrderList);
            try{
                $stmtOrderList->execute([$startDate, $endDate]);
                $rowOrderList=$stmtOrderList->fetchAll(PDO::FETCH_ASSOC);
                $orderCount=$stmtOrderList->rowCount();
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}else {
    $sqlOrderList="SELECT * FROM order_list ORDER BY id ASC";
    $stmtOrderList=$db_host->prepare($sqlOrderList);
    try{
        $stmtOrderList->execute();
        $rowOrderList=$stmtOrderList->fetchAll(PDO::FETCH_ASSOC);
        $orderCount=$stmtOrderList->rowCount();
//        echo "else";
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}
//    篩選訂單編號後，清除篩選要顯示完整清單！empty() 但非0
if(empty($_GET["order_id"]) && $order_id!=="0"){
    $sqlOrderList="SELECT * FROM order_list ORDER BY id ASC";
    $stmtOrderList=$db_host->prepare($sqlOrderList);
    try{
        $stmtOrderList->execute();
        $rowOrderList=$stmtOrderList->fetchAll(PDO::FETCH_ASSOC);
        $orderCount=$stmtOrderList->rowCount();
        echo "empty";
        if(isset($_GET["startDate"])){
            $startDate=$_GET["startDate"];
            $endDate=$_GET["endDate"];
            $sqlOrderList="SELECT * FROM order_list WHERE DATE(order_time) BETWEEN ? AND ? ORDER BY id ASC";
            $stmtOrderList=$db_host->prepare($sqlOrderList);
            try{
                $stmtOrderList->execute([$startDate, $endDate]);
                $rowOrderList=$stmtOrderList->fetchAll(PDO::FETCH_ASSOC);
                $orderCount=$stmtOrderList->rowCount();
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <title>Order list</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- fontawesome -->
    <link rel="stylesheet" href="fontawesome-free-5.15.4-web/css/all.css">

    <style>
        body{
            font-size: 15px;
        }
        .form-control{
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
<!--        之後再找適合的下拉式選單，分別觸動訂單編號、會員編號篩選-->
<!--        <div class="row justify-content-end">-->
<!--            <div class="col-3">-->
<!--                <select class="form-control" name="" id="">-->
<!--                    <option value="">訂單編號篩選</option>-->
<!--                    <option value="">會員編號篩選</option>-->
<!--                </select>-->
<!--            </div>-->
<!--        </div>-->
        <div class="row justify-content-end">
            <div class="col-3">
                <label for="order_id">訂單編號篩選</label>
                <form action="order-list.php" method="get">
                    <div class="d-flex align-items-center">
                        <div class="me-2"></div>
                        <input type="number" class="form-control me-2" id="order_id" name="order_id" value="<?=$order_id?>">
                        <button type="submit" class="btn btn-primary text-nowrap">篩選</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="py-2 d-flex justify-content-end">
            <form action="order-list.php" method="get">
                <div class="d-flex align-items-center">
                    <input type="hidden" name="order_id" value="<?=$order_id?>">
                    <input type="date" class="form-control me-2" name="startDate"
                           value="<?php if(isset($startDate))echo $startDate; ?>">
                    <div class="me-2">~</div>
                    <input type="date" class="form-control me-2" name="endDate"
                           value="<?php if(isset($endDate))echo $endDate; ?>">
                    <button type="submit" class="btn btn-primary text-nowrap">篩選</button>
                </div>
            </form>
        </div>

        <table class="table table-bordered m-3 text-center">
            <thead>
                <tr class="text-nowrap">
                    <th>訂單編號</th>
                    <th>會員編號</th>
                    <th>訂單總金額</th>
                    <th>付款方式</th>
                    <th>付款狀態</th>
                    <th>送貨方式</th>
                    <th>收件人姓名</th>
                    <th>收件人電話</th>
                    <th>收件人地址</th>
                    <th>收件超商門市</th>
                    <th>訂單狀態</th>
                    <th>訂單日期</th>
                    <th>查看詳細內容</th>
                    <th>修改訂單資訊</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rowOrderList as $value): ?>
                <tr class="text-nowrap">
                    <td><?=$value["id"]?></td>
                    <td><?=$value["member_id"]?></td>
                    <td class="text-end">$ <?=$value["amount"]?></td>
                    <td><?=$value["payment"]?></td>
                    <td><?=$value["payment_status"]?></td>
                    <td><?=$value["delivery"]?></td>
                    <td><?=$value["receiver"]?></td>
                    <td><?=$value["receiver_phone"]?></td>
                    <td><?=$value["address"]?></td>
                    <td><?=$value["convenient_store"]?></td>
                    <td><?=$value["status"]?></td>
                    <td><?=$value["order_time"]?></td>
                    <td><a href="order-detail.php?order_id=<?=$value["id"]?>">查看詳細內容</a></td>
                    <td><a href="order-edit.php?order_id=<?=$value["id"]?>"><i class="fas fa-edit"></i></a> /
                        <a href="doDeleteOrder.php?order_id=<?=$value["id"]?>"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>


<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

</body>
</html>