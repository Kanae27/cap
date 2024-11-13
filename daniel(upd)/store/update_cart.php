<?php
session_start();
include('../connect.php');

header('Content-Type: application/json');

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['product_id']) || !isset($input['quantity'])) {
        throw new Exception('Invalid input');
    }
    
    $product_id = $input['product_id'];
    $quantity = $input['quantity'];
    $username = $_SESSION['username'];
    
    // Start transaction
    $conn->begin_transaction();
    
    // Get product details
    $stmt = $conn->prepare("SELECT quantity, price FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if (!$product) {
        throw new Exception('Product not found');
    }
    
    // Check if quantity is valid
    if ($quantity > $product['quantity']) {
        throw new Exception('Not enough stock');
    }
    
    // Remove existing cart entry if quantity is 0
    if ($quantity == 0) {
        $stmt = $conn->prepare("DELETE FROM cart WHERE product = ? AND username = ? AND status = 'Pending'");
        $stmt->bind_param("is", $product_id, $username);
        $stmt->execute();
    } else {
        // Update or insert cart entry
        $stmt = $conn->prepare("
            INSERT INTO cart (product, username, status, quantity) 
            VALUES (?, ?, 'Pending', ?)
            ON DUPLICATE KEY UPDATE quantity = ?
        ");
        $stmt->bind_param("isis", $product_id, $username, $quantity, $quantity);
        $stmt->execute();
    }
    
    $conn->commit();
    
    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    if ($conn->connect_errno) {
        $conn->rollback();
    }
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?> 