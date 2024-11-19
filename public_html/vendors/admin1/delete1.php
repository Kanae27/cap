<?php
include('../connect.php');
session_start();
$username = $_GET['username'];
$trans_id = $_GET['trans_id'];
mysqli_query($conn,"UPDATE transaction SET status = 'Decline' WHERE username = '$username' AND trans_id = '$trans_id'");
mysqli_query($conn,"UPDATE cart SET status = 'Decline' WHERE username = '$username' AND status = 'Checkout'");
?>
<script>
alert("Orders has been deleted");
window.location='pending_orders.php';
</script>