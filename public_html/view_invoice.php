<?php
session_start();
include('./connect.php');

$invoice_number = $_GET['invoice'] ?? '';
if (!$invoice_number) {
    die("No invoice specified");
}

$result = $conn->query("SELECT * FROM invoices WHERE invoice_number = '$invoice_number'");
$invoice = $result->fetch_assoc();

if (!$invoice) {
    die("Invoice not found");
}

echo $invoice['invoice_content'];
echo "<br><button onclick='window.print()'>Print Invoice</button>";
echo "<br><a href='cart.php'>Back to Cart</a>";
?> 