<?php
session_start();
$servername="localhost";
$username="funwave";
$password="20211013";
$dbname="project";

try{
    $db_host = new PDO(
        "mysql:host={$servername};dbname={$dbname};charset=UTF8", $username, $password
    );
//    echo "資料庫連線成功";
}catch(PDOException $e){
    echo "資料庫連線失敗";
    echo "error: ".$e->getMessage();
}
?>
