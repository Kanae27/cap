<?php
session_start();
include('../connect.php');

try {
    $cart_items = [];
    
    // Assuming you store cart in session
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt = $conn->prepare("SELECT id, item, price, quantity as max_quantity FROM product WHERE id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $cart_items[] = [
                    'product_id' => $product_id,
                    'item' => $row['item'],
                    'price' => floatval($row['price']),
                    'quantity' => intval($quantity),
                    'max_quantity' => intval($row['max_quantity'])
                ];
            }
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'items' => $cart_items
    ]);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'items' => []
    ]);
}
?> 