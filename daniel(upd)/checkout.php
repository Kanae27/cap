<?php
include('./header.php');

if (!isset($_SESSION['username'])) {
    echo '<script>alert("Please login to continue");window.history.back();</script>';
    exit();
}

// Get transaction details from URL parameters
$payment_type = $_GET['payment'] ?? '';
$transaction_type = $_GET['transaction'] ?? '';
$username = $_SESSION['username'];

// Debug connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process the cart items
$cart_query = "SELECT c.*, p.price, p.item 
               FROM cart c 
               JOIN product p ON c.product = p.id 
               WHERE c.username = ? AND c.status = 'Cart'";

$stmt = mysqli_prepare($conn, $cart_query);
if ($stmt === false) {
    die("Error preparing statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$cart_result = mysqli_stmt_get_result($stmt);

// Generate invoice number
$invoice = date('YmdHis');

// Process each cart item
while ($cart_item = mysqli_fetch_assoc($cart_result)) {
    $product_id = $cart_item['product'];
    $quantity = $cart_item['quantity'];
    $price = $cart_item['price'];
    
    // Set initial status based on transaction type
    $status = 'Processing';
    
    // First, check if the cart table has all required columns
    $check_columns_query = "SHOW COLUMNS FROM cart LIKE 'transaction'";
    $check_result = mysqli_query($conn, $check_columns_query);
    if (mysqli_num_rows($check_result) == 0) {
        // Add missing columns if they don't exist
        mysqli_query($conn, "ALTER TABLE cart 
            ADD COLUMN transaction VARCHAR(50) DEFAULT NULL,
            ADD COLUMN payment_type VARCHAR(50) DEFAULT NULL,
            ADD COLUMN invoice VARCHAR(50) DEFAULT NULL,
            ADD COLUMN order_date DATETIME DEFAULT NULL");
    }
    
    // Insert into orders with transaction type
    $insert_query = "INSERT INTO cart 
        (username, product, quantity, status, transaction, payment_type, invoice, order_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $insert_stmt = mysqli_prepare($conn, $insert_query);
    if ($insert_stmt === false) {
        die("Error preparing insert statement: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param(
        $insert_stmt, 
        "siissss",
        $username,
        $product_id,
        $quantity,
        $status,
        $transaction_type,
        $payment_type,
        $invoice
    );
    
    if (!mysqli_stmt_execute($insert_stmt)) {
        echo '<script>alert("Error processing order: ' . mysqli_error($conn) . '");window.history.back();</script>';
        exit();
    }
    
    mysqli_stmt_close($insert_stmt);
}

// Clear the cart after successful order creation
$clear_cart = "DELETE FROM cart WHERE username = ? AND status = 'Cart'";
$clear_stmt = mysqli_prepare($conn, $clear_cart);
if ($clear_stmt === false) {
    die("Error preparing clear statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($clear_stmt, "s", $username);
mysqli_stmt_execute($clear_stmt);
mysqli_stmt_close($clear_stmt);

// Create notifications table if it doesn't exist
$create_notifications_table = "CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255) NOT NULL,
    order_details TEXT,
    created_at DATETIME NOT NULL,
    status ENUM('read', 'unread') DEFAULT 'unread'
)";

// First, drop the existing notifications table if it exists
mysqli_query($conn, "DROP TABLE IF EXISTS notifications");

// Then create the new table with all required columns
if (!mysqli_query($conn, $create_notifications_table)) {
    die("Error creating notifications table: " . mysqli_error($conn));
}

// Create notification for admin
$notification_message = "New " . strtolower($transaction_type) . " order received!";
$order_details = "Transaction: $transaction_type, Payment: $payment_type, Invoice: $invoice";

// Insert notification with error checking
$notification_query = "INSERT INTO notifications (message, order_details, created_at, status) 
                      VALUES (?, ?, NOW(), 'unread')";

$notification_stmt = mysqli_prepare($conn, $notification_query);
if ($notification_stmt === false) {
    die("Error preparing notification statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($notification_stmt, "ss", $notification_message, $order_details);

if (!mysqli_stmt_execute($notification_stmt)) {
    die("Error creating notification: " . mysqli_error($conn));
}

mysqli_stmt_close($notification_stmt);

// Close the database connection
mysqli_close($conn);

// Redirect to success page with invoice number
echo "<script>
    alert('Order placed successfully! Your invoice number is: $invoice');
    window.location='history.php';
</script>";
?>