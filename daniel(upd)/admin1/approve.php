<?php
include('../connect.php');
session_start();
$username = $_GET['username'];
$trans_id = $_GET['trans_id'];
mysqli_query($conn,"UPDATE transaction SET status = 'Approved' WHERE username = '$username' AND trans_id = '$trans_id'");
mysqli_query($conn,"UPDATE cart SET status = 'Approved' WHERE username = '$username' AND trans_id = '$trans_id'");
?>
<script>
alert("Purchases has been approved");
window.location='pending_orders.php';
</script>