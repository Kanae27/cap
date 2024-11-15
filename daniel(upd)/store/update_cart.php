<?php
session_start();
include('../connect.php');

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

try {
    if (!isset($input['product_id']) || !isset($input['quantity'])) {
        throw new Exception('Invalid input');
    }

    $product_id = intval($input['product_id']);
    $quantity = intval($input['quantity']);

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Update cart
    if ($quantity > 0) {
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        unset($_SESSION['cart'][$product_id]);
    }

    // Debug information
    error_log('Cart updated: ' . print_r($_SESSION['cart'], true));

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Cart updated',
        'cart' => $_SESSION['cart']  // Send back current cart state
    ]);

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 