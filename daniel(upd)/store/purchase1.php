<?php
include('../connect.php');
session_start();

if (!isset($_SESSION['invoice1'])) {
    echo "<script>alert('No order to process'); window.location='pos_.php';</script>";
    exit;
}

// Get the invoice number
$invoice = $_SESSION['invoice1'];

// Update only the status
$stmt = $conn->prepare("UPDATE cart_items SET status = 'Approved' WHERE status = 'cart' AND username = ?");

if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    echo "<script>alert('Error processing order'); window.location='pos_.php';</script>";
    exit;
}

$stmt->bind_param("s", $_SESSION['username']);

if (!$stmt->execute()) {
    error_log("Execute failed: " . $stmt->error);
    echo "<script>alert('Error processing order'); window.location='pos_.php';</script>";
    exit;
}

// Clear the invoice from session
unset($_SESSION['invoice1']);

// Redirect back to POS
echo "<script>alert('Order processed successfully'); window.location='pos_.php';</script>";
?>