<?php
include('connect.php');

if(isset($_GET['del_id'])){
    $del_id = $_GET['del_id'];
    
    // Delete query execution
    $del_query = "DELETE FROM `category` WHERE `category_id` = '$del_id'";
    $del_result = mysqli_query($con, $del_query);
    
    if($del_result){
        echo "<script>alert('Category Deleted Successfully'); window.location.href='viewcat.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "'); window.location.href='viewcat.php';</script>";
    }
} else {
    // Agar koi direct is file ko khole to wapas view page par bhej dein
    header("Location: viewcat.php");
    exit();
}
?>
