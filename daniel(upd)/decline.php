<?php
include('./connect.php');
session_start();
$username = $_GET['username'];
mysqli_query($conn,"UPDATE cart SET status = 'Decline' WHERE username = '$username' AND status = 'Checkout'");
?>
<script>
alert("Purchases has been approved");
window.location='pending_orders.php';
</script>