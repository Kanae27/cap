<?php
include('../connect.php');

if(isset($_POST['invoice'])) {
    $invoice = $_POST['invoice'];
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Update cart status
        $update_cart = "UPDATE cart SET status = 'Delivered' WHERE invoice = ?";
        $stmt = mysqli_prepare($conn, $update_cart);
        mysqli_stmt_bind_param($stmt, "s", $invoice);
        mysqli_stmt_execute($stmt);
        
        // Get cart ID
        $get_cart_id = "SELECT id FROM cart WHERE invoice = ?";
        $stmt = mysqli_prepare($conn, $get_cart_id);
        mysqli_stmt_bind_param($stmt, "s", $invoice);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $cart = mysqli_fetch_assoc($result);
        
        // Update or insert into order_status
        $update_status = "INSERT INTO order_status (cart_id, order_status, updated_at) 
                         VALUES (?, 'Delivered', NOW())
                         ON DUPLICATE KEY UPDATE 
                         order_status = 'Delivered', 
                         updated_at = NOW()";
        $stmt = mysqli_prepare($conn, $update_status);
        mysqli_stmt_bind_param($stmt, "i", $cart['id']);
        mysqli_stmt_execute($stmt);
        
        // Commit transaction
        mysqli_commit($conn);
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Rollback on error
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No invoice provided']);
}
?> 