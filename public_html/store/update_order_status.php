<?php
session_start();
include('../connect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if (isset($_POST['invoice']) && isset($_POST['status'])) {
    $invoice = mysqli_real_escape_string($conn, $_POST['invoice']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Update the order status
    $update_query = "UPDATE cart SET status = '$status' WHERE invoice = '$invoice'";
    
    if (mysqli_query($conn, $update_query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Missing required parameters'
    ]);
}

mysqli_close($conn);
?> 