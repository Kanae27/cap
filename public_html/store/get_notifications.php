<?php
include('../connect.php');

// Get pending orders
$query = "SELECT c.*, p.item 
          FROM cart c 
          JOIN product p ON c.product = p.id 
          WHERE c.status = 'Pending' 
          ORDER BY c.date DESC";
$result = mysqli_query($conn, $query);

$notifications = [];
$count = mysqli_num_rows($result);

while($row = mysqli_fetch_assoc($result)) {
    $notifications[] = [
        'username' => $row['username'],
        'item' => $row['item'],
        'quantity' => $row['quantity'],
        'date' => date('M d, Y h:i A', strtotime($row['date']))
    ];
}

echo json_encode([
    'count' => $count,
    'notifications' => $notifications
]);
?> 