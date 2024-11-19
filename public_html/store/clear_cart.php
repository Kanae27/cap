<?php
session_start();

try {
    // Clear only the cart array from session
    unset($_SESSION['cart']);
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Cart cleared successfully'
    ]);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 