<?php
session_start();
include('../connect.php');

header('Content-Type: application/json');

try {
    $username = $_SESSION['username'];
    
    $result = $conn->query("
        SELECT c.*, p.item, p.price, p.quantity as max_quantity, p.id as product_id
        FROM cart c 
        JOIN product p ON c.product = p.id 
        WHERE c.username = '$username' 
        AND c.status = 'Pending'
    ");
    
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'items' => $items
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?> 