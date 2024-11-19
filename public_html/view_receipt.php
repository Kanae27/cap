<?php
session_start();
include('./connect.php');

// Get invoice number from URL parameter
$invoice_no = mysqli_real_escape_string($conn, $_GET['invoice']);
$username = $_SESSION['username'];

// Get receipt details
$receipt_query = $conn->query("SELECT * FROM receipts WHERE invoice_no = '$invoice_no' AND username = '$username'");
if (!$receipt_query) {
    die("Receipt query failed: " . $conn->error);
}
$receipt = $receipt_query->fetch_assoc();

if (!$receipt) {
    die("Receipt not found.");
}

// Get items from cart for this invoice - Fixed query
$items_query = $conn->query("
    SELECT c.*, p.name as product_name, p.price 
    FROM order c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.invoice_no = '$invoice_no' 
    AND c.username = '$username'
");

// Add error handling
if (!$items_query) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receipt #<?php echo $invoice_no; ?></title>
    <style>
        .receipt-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            font-family: Arial, sans-serif;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
        .print-btn {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h2>RECEIPT</h2>
            <p>Invoice #: <?php echo $invoice_no; ?></p>
        </div>
        
        <div class="receipt-details">
            <p><strong>Date:</strong> <?php echo date('F d, Y h:i A', strtotime($receipt['date_created'])); ?></p>
            <p><strong>Customer:</strong> <?php echo $username; ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                if ($items_query->num_rows > 0):
                    while($item = $items_query->fetch_assoc()): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₱<?php echo number_format($item['price'], 2); ?></td>
                    <td>₱<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php 
                    endwhile;
                else:
                ?>
                <tr>
                    <td colspan="4">No items found for this invoice.</td>
                </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total">Total Amount:</td>
                    <td>₱<?php echo number_format($receipt['total_amount'], 2); ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="print-btn">
            <button onclick="window.print()">Print Receipt</button>
            <button onclick="window.location='cart.php'">Back to Cart</button>
        </div>
    </div>
</body>
</html> 