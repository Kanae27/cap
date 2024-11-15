<?php
include('./header.php');

// Get filter parameters
$date = $_POST['date'] ?? null;
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;
$year = $_POST['year'] ?? null;

// Build the WHERE clause based on filter type with proper SQL injection protection
if (isset($_POST['by_date'])) {
    $where_clause = "DATE(timestamp) = ?";
    $params = [$date];
} elseif (isset($_POST['by_month'])) {
    $where_clause = "timestamp BETWEEN ? AND LAST_DAY(?)";
    $params = ["$start_date-01", "$end_date-01"];
} elseif (isset($_POST['by_year'])) {
    $where_clause = "YEAR(timestamp) = ?";
    $params = [$year];
} else {
    $where_clause = "1=1";
    $params = [];
}

// Modify the purchase query to use prepared statements
$purchase_query = "
    (SELECT DISTINCT 
        ci.invoice,
        ci.username as name,
        NULL as contact,
        NULL as address,
        ci.timestamp,
        ci.status,
        'cart_items' as source
    FROM cart_items ci
    WHERE ci.invoice IS NOT NULL
    AND $where_clause)
    
    UNION ALL
    
    (SELECT DISTINCT 
        c.invoice,
        c.name,
        c.contact,
        c.address,
        c.timestamp,
        c.status,
        'cart' as source
    FROM cart c
    WHERE c.status = 'Approved'
    AND $where_clause)
    
    ORDER BY timestamp DESC
";

// Use prepared statement for main query
$stmt = $conn->prepare($purchase_query);
if ($params) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$purchases_result = $stmt->get_result();

if (!$purchases_result) {
    echo "Query error: " . $conn->error;
} else {
    while ($row = $purchases_result->fetch_assoc()) {
        $invoice = $row['invoice'];
        $source = $row['source'];
        
        echo '<tr>';
        echo '<td>' . htmlspecialchars($invoice) . '</td>';
        echo '<td>' . htmlspecialchars($row['name'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['contact'] ?? 'N/A') . '</td>';
        echo '<td>' . htmlspecialchars($row['address'] ?? 'N/A') . '</td>';
        
        // Get items based on source
        echo '<td><ul class="list-unstyled">';
        if ($source == 'cart_items') {
            $items_query = "
                SELECT 
                    ci.quantity,
                    p.item,
                    p.price,
                    p.type_quantity,
                    (ci.quantity * p.price) as subtotal
                FROM cart_items ci
                JOIN product p ON ci.product_id = p.id
                WHERE ci.invoice = ?
            ";
        } else {
            $items_query = "
                SELECT 
                    c.quantity,
                    p.item,
                    p.price,
                    p.type_quantity,
                    (c.quantity * p.price) as subtotal
                FROM cart c
                JOIN product p ON c.product = p.id
                WHERE c.invoice = ?
            ";
        }
        
        $stmt = $conn->prepare($items_query);
        $stmt->bind_param('s', $invoice);
        $stmt->execute();
        $items_result = $stmt->get_result();
        
        $total = 0;
        
        if ($items_result) {
            while ($item = $items_result->fetch_assoc()) {
                $quantity = intval($item['quantity']);
                $price = floatval($item['price']);
                $subtotal = floatval($item['subtotal']); // Get the calculated subtotal
                $total += $subtotal;
                
                echo '<li>' . 
                     htmlspecialchars($item['item']) . ' × ' . 
                     $quantity . ' ' . 
                     htmlspecialchars($item['type_quantity'] ?? 'pcs') . 
                     ' (₱' . number_format($price, 2) . ' each = ₱' . 
                     number_format($subtotal, 2) . ')' .
                     '</li>';
            }
        }
        echo '</ul></td>';
        
        echo '<td>₱' . number_format($total, 2) . '</td>';
        echo '<td>' . date('F d, Y', strtotime($row['timestamp'])) . '</td>';
        echo '</tr>';
    }
}

// Update debug queries to use prepared statements
$filtered_cart_query = "SELECT COUNT(*) as count FROM cart WHERE status = 'Approved' AND $where_clause";
$stmt = $conn->prepare($filtered_cart_query);
if ($params) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$count_cart = $stmt->get_result()->fetch_assoc()['count'];

$filtered_cart_items_query = "SELECT COUNT(*) as count FROM cart_items WHERE invoice IS NOT NULL AND $where_clause";
$stmt = $conn->prepare($filtered_cart_items_query);
if ($params) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$count_cart_items = $stmt->get_result()->fetch_assoc()['count'];

// Debug: Show table structures
echo "<!-- cart_items Table Structure: -->";
$table_info = $conn->query("DESCRIBE cart_items");
while($row = $table_info->fetch_assoc()) {
    echo "<!-- Field: {$row['Field']}, Type: {$row['Type']} -->";
}

echo "<!-- cart Table Structure: -->";
$table_info = $conn->query("DESCRIBE cart");
while($row = $table_info->fetch_assoc()) {
    echo "<!-- Field: {$row['Field']}, Type: {$row['Type']} -->";
}
?>
