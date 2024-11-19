<?php
session_start();
include('./connect.php');
$username = $_SESSION['username'];
$invoice_no = mt_rand(100000,999999); 

$result1 = $conn->query("UPDATE cart SET invoice = '$invoice_no' WHERE username = '$username' AND status = 'Cart'");
$result2 = $conn->query("UPDATE cart SET status = 'Pending' WHERE username = '$username' AND status = 'Cart'");

// Redirect to invoice page instead of cart
header("Location: invoice.php?invoice=" . $invoice_no);
exit();
?>