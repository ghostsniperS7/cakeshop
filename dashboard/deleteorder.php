<?php
include('connect.php');

if(isset($_GET['del_id'])){
    $del_id = $_GET['del_id'];
    
    // Delete query execution
    $del_query = "DELETE FROM `orders` WHERE `order_id` = '$del_id'";
    $del_result = mysqli_query($con, $del_query);
    
    if($del_result){
        echo "<script>alert('Order Deleted Successfully'); window.location.href='order_details.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "'); window.location.href='order_details.php';</script>";
    }
} else {
    // Agar koi direct is file ko khole to wapas view page par bhej dein
    header("Location: order_details.php");
    exit();
}
?>
