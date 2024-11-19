<?php
include('connect.php');
session_start();

if(isset($_POST['message']) && isset($_POST['order_details']) && isset($_POST['username'])) {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $order_details = mysqli_real_escape_string($conn, $_POST['order_details']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    $query = "INSERT INTO notifications (username, message, order_details, created_at) 
              VALUES ('$username', '$message', '$order_details', NOW())";
    
    if(mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?> 