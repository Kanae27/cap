<?php
session_start();
include('../connect.php');

try {
    $cart_items = [];
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $product_ids = array_keys($_SESSION['cart']);
        $ids_string = implode(',', array_map('intval', $product_ids));
        
        $query = "SELECT id, item, price, quantity, category FROM product WHERE id IN ($ids_string)";
        $result = mysqli_query($conn, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['id'];
            $cart_quantity = $_SESSION['cart'][$product_id];
            
            $cart_items[] = [
                'product_id' => $product_id,
                'item' => $row['item'],
                'price' => floatval($row['price']),
                'quantity' => floatval($cart_quantity),
                'max_quantity' => floatval($row['quantity']),
                'category' => $row['category']
            ];
        }
    }
    
    echo json_encode([
        'success' => true,
        'items' => $cart_items
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'items' => []
    ]);
}
?> 