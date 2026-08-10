<?php
session_start();
$id = $_GET['cartid'];
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
 $_SESSION['cart'][] = $id;
 header("Location: cakes.php");

 exit();
?>