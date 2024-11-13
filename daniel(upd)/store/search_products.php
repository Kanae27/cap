<?php
include('../connect.php');

$search = $_GET['search'];
$search = "%$search%";

$stmt = $conn->prepare("SELECT id, item, category FROM product WHERE item LIKE ? OR category LIKE ? LIMIT 10");
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();

$products = array();
while($row = $result->fetch_assoc()) {
    $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);
?> 