<?php
session_start();
include('../connect.php');

// Get customer details
$user = $_GET['customer'] ?? '';
$username = $_SESSION['username'] ?? '';
$invoice = $_GET['invoice'] ?? '';

// Get customer info
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$customerResult = $stmt->get_result();
$customerData = $customerResult->fetch_assoc();

// Get cart items
$cartItems = [];
$total_price = 0;
$stmt = $conn->prepare("
    SELECT c.*, p.item, p.price 
    FROM cart c 
    JOIN product p ON c.product = p.id 
    WHERE c.username = ? AND c.status = 'Pending' AND c.invoice = ?
");
$stmt->bind_param("ss", $username, $invoice);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    $total = $row['quantity'] * $row['price'];
    $cartItems[] = [
        'item' => $row['item'],
        'quantity' => $row['quantity'],
        'price' => $row['price'],
        'total' => $total
    ];
    $total_price += $total;
}

$tax = $total_price * 0.12;

// At the start of the transaction, generate a unique transaction ID
$transaction_id = uniqid();

// When inserting into cart table, include the transaction_id
$sql = "INSERT INTO cart (transaction_id, ...) VALUES ('$transaction_id', ...)";

// When displaying the invoice, only show items from current transaction
$result = $conn->query("SELECT * FROM cart WHERE transaction_id = '$transaction_id' AND status = 'Pending'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice - <?php echo htmlspecialchars($invoice); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        
        .invoice-header {
            position: relative;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #347928;
        }
        
        .company-logo {
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: auto;
        }
        
        .company-name {
            color: #347928;
            font-size: 28px;
            margin: 0;
            padding-right: 170px;
        }
        
        .invoice-details {
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .invoice-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        th {
            background: #347928;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .text-right {
            text-align: right;
        }
        
        .totals-table {
            width: 300px;
            margin-left: auto;
            margin-top: 20px;
        }
        
        .total-row {
            font-weight: bold;
            color: #347928;
            font-size: 1.1em;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .btn {
            background: #347928;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .invoice-container {
                box-shadow: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container" id="print">
        <div class="invoice-header">
            <h1 class="company-name">Daniel and Marilyn's General Merchandise</h1>
            <img src="../img/logo.png" alt="Company Logo" class="company-logo">
        </div>

        <div class="invoice-details">
            <div class="invoice-details-grid">
                <div>
                    <h3>Bill To:</h3>
                    <p><strong><?php echo htmlspecialchars($customerData['name'] ?? ''); ?></strong></p>
                    <p><?php echo htmlspecialchars($customerData['address'] ?? ''); ?></p>
                    <p>Email: <?php echo htmlspecialchars($customerData['email'] ?? ''); ?></p>
                    <p>Contact: <?php echo htmlspecialchars($customerData['contact'] ?? ''); ?></p>
                </div>
                <div class="text-right">
                    <h3>Invoice Details:</h3>
                    <p><strong>Invoice #:</strong> <?php echo htmlspecialchars($invoice); ?></p>
                    <p><strong>Date:</strong> <?php echo date('F d, Y'); ?></p>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['item']); ?></td>
                    <td class="text-right"><?php echo $item['quantity']; ?></td>
                    <td class="text-right">₱<?php echo number_format($item['price'], 2); ?></td>
                    <td class="text-right">₱<?php echo number_format($item['total'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <table class="totals-table">
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">₱<?php echo number_format($total_price, 2); ?></td>
            </tr>
            <tr>
                <td>Tax (12%):</td>
                <td class="text-right">₱<?php echo number_format($tax, 2); ?></td>
            </tr>
            <tr class="total-row">
                <td>Total:</td>
                <td class="text-right">₱<?php echo number_format($total_price + $tax, 2); ?></td>
            </tr>
        </table>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>For any inquiries, please contact us at DanielandMarilyn@gmail.com</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button class="btn" onclick="printInvoice()">Print Invoice</button>
        <button class="btn btn-secondary" onclick="window.location='pos.php'">Close Invoice</button>
    </div>

    <script>
    function printInvoice() {
        window.print();
    }
    </script>
</body>
</html>

<?php
try {
    // Start transaction
    $conn->begin_transaction();

    // 1. Update cart status
    $cartSql = "UPDATE cart SET status = 'Approved' WHERE username = ? AND status = 'Pending' AND invoice = ?";
    $cartStmt = $conn->prepare($cartSql);
    
    if ($cartStmt === false) {
        throw new Exception("Error preparing cart update statement: " . $conn->error);
    }
    
    $cartStmt->bind_param("ss", $username, $invoice);
    if (!$cartStmt->execute()) {
        throw new Exception("Error updating cart status: " . $cartStmt->error);
    }

    // 2. Update product quantities
    $updateSql = "UPDATE product p 
                  INNER JOIN cart c ON p.id = c.product 
                  SET p.quantity = p.quantity - c.quantity 
                  WHERE c.username = ? 
                  AND c.status = 'Approved' 
                  AND c.invoice = ?";
                     
    $updateStmt = $conn->prepare($updateSql);
    
    if ($updateStmt === false) {
        throw new Exception("Error preparing product update statement: " . $conn->error);
    }
    
    $updateStmt->bind_param("ss", $username, $invoice);
    if (!$updateStmt->execute()) {
        throw new Exception("Error updating product quantities: " . $updateStmt->error);
    }

    // If everything is successful, commit the transaction
    $conn->commit();
    
    // Show success message
    echo "<script>
        alert('Transaction completed successfully!');
        setTimeout(function() {
            window.location.href = 'pos.php';
        }, 5000);
    </script>";
    
} catch (Exception $e) {
    // Rollback the transaction on error
    if ($conn->connect_errno) {
        $conn->rollback();
    }
    
    // Display error message
    echo "<script>
        alert('Error: " . addslashes($e->getMessage()) . "');
        // Stay on current page - no redirect
    </script>";
} finally {
    // Close all statements
    if (isset($cartStmt)) $cartStmt->close();
    if (isset($updateStmt)) $updateStmt->close();
    
    // Close the connection
    if (isset($conn)) $conn->close();
}
?>

<script>
// Improved message handling
document.addEventListener('DOMContentLoaded', function() {
    // Function to show messages
    function showMessage(message, type = 'success') {
        var alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger') + ' alert-dismissible fade show';
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.innerHTML = message + 
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span></button>';
        document.body.appendChild(alertDiv);

        // Only auto-hide success messages, error messages stay until dismissed
        if (type === 'success') {
            setTimeout(function() {
                alertDiv.style.opacity = '0';
                alertDiv.style.transition = 'opacity 0.5s';
                setTimeout(function() {
                    alertDiv.remove();
                }, 500);
            }, 8000);
        }
    }

    // Handle existing alerts
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        if (alert.classList.contains('alert-success')) {
            setTimeout(function() {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 8000);
        }
    });
});
</script>