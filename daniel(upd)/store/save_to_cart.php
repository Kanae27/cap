<?php
session_start();
include('../connect.php');

try {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        throw new Exception('Cart is empty');
    }

    // Get username from session
    if (!isset($_SESSION['username'])) {
        throw new Exception('Please log in first');
    }
    $username = $_SESSION['username'];

    // Generate invoice
    $invoice = date('YmdHis') . rand(100, 999);
    $_SESSION['invoice1'] = $invoice;

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Get product details
        $stmt = $conn->prepare("SELECT item, price FROM product WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Error preparing product query: " . $conn->error);
        }
        
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            continue;
        }

        // Insert into cart_items table
        $sql = "INSERT INTO cart_items (product_id, username, status, quantity) 
                VALUES (?, ?, 'cart', ?)";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error in prepare statement: " . $conn->error);
        }

        $stmt->bind_param("isi", 
            $product_id,
            $username,
            $quantity
        );

        if (!$stmt->execute()) {
            throw new Exception("Error executing insert: " . $stmt->error);
        }

        // Update original product quantity
        $update_stmt = $conn->prepare("UPDATE product SET quantity = quantity - ? WHERE id = ?");
        if (!$update_stmt) {
            throw new Exception("Error preparing update: " . $conn->error);
        }
        
        $update_stmt->bind_param("ii", $quantity, $product_id);
        if (!$update_stmt->execute()) {
            throw new Exception("Error updating product quantity: " . $update_stmt->error);
        }
    }

    // Clear cart
    unset($_SESSION['cart']);

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Cart saved successfully',
        'invoice' => $invoice
    ]);

} catch (Exception $e) {
    error_log("Cart Error: " . $e->getMessage());
    error_log("Last SQL Error: " . $conn->error);
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 