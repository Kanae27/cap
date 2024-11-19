<?php
include('../connect.php');

// Get unread notifications
$result = mysqli_query($conn, "
    SELECT n.*, 
           DATE_FORMAT(n.created_at, '%M %d, %Y %h:%i %p') as formatted_date 
    FROM notifications n 
    WHERE is_read = 0 
    ORDER BY created_at DESC 
    LIMIT 10
");

$notifications = array();

while($row = mysqli_fetch_assoc($result)) {
    $notifications[] = array(
        'id' => $row['id'],
        'message' => $row['message'],
        'username' => $row['username'],
        'order_details' => $row['order_details'],
        'created_at' => $row['formatted_date']
    );
}

echo json_encode($notifications);
?> 