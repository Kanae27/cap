<?php
session_start();
include('../connect.php');

// Get JSON data from request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['product_id']) || !isset($data['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

$product_id = intval($data['product_id']);
$quantity = floatval($data['quantity']); // Changed to floatval to handle decimals

try {
    // Check if product exists and has enough stock
    $stmt = $conn->prepare("SELECT quantity, category FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }

    // Validate quantity based on category
    $category = strtolower($product['category']);
    if (($category === 'fruit' || $category === 'vegetable')) {
        // For fruits and vegetables, check if quantity is in 0.25 increments
        if (($quantity * 4) % 1 !== 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid quantity increment']);
            exit;
        }
    } else {
        // For other products, ensure quantity is a whole number
        if ($quantity != 0 && floor($quantity) != $quantity) {
            echo json_encode(['success' => false, 'message' => 'Quantity must be a whole number']);
            exit;
        }
    }

    if ($quantity > $product['quantity']) {
        echo json_encode(['success' => false, 'message' => 'Not enough stock']);
        exit;
    }

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Update cart
    if ($quantity <= 0) {
        unset($_SESSION['cart'][$product_id]);
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Cart updated successfully',
        'cart' => $_SESSION['cart']
    ]);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?> 