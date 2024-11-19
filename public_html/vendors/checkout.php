<?php
session_start();
include('./connect.php');
$username = $_SESSION['username'];
$a = mt_rand(100000,999999); 

$result1 = $conn->query("UPDATE cart SET invoice = '$a' WHERE username = '$username' AND status = 'Cart'");
$result1 = $conn->query("UPDATE cart SET status = 'Pending' WHERE username = '$username' AND status = 'Cart'");

?>
<script>
alert("Item/s has been checked out. Please wait for a notification for the status of your request");
window.location='cart.php';
</script>