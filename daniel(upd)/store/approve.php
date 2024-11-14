<?php
include('../connect.php');
session_start();

$user = $_GET['user'] ?? '';
$invoice = $_GET['invoice'] ?? '';
$username = $user;

// Simple update query to approve the order
$sql = "UPDATE cart SET 
        username = '$username', 
        status = 'Approved' 
        WHERE invoice = '$invoice'";

if($conn->query($sql)) {
    ?>
    <script>
        alert("Order has been approved successfully!");
        window.location = 'sale.php?invoice=<?php echo $invoice; ?>';
    </script>
    <?php
} else {
    ?>
    <script>
        alert("Error approving order. Please try again.");
        window.location = 'sale.php';
    </script>
    <?php
}

$conn->close();
?>