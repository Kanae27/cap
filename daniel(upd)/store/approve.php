<?php
include('../connect.php');
session_start();
$user = $_GET['user'];
$invoice = $_GET['invoice'];
$user1 = $_GET['user1'];
$username = $_SESSION['username'];
$conn->query("UPDATE cart SET username = '$username' WHERE username = '$user' AND invoice = '$invoice' AND status = 'Pending'");
?>



<script>
alert("Orders has been approved");
window.location='pos1.php?invoice=<?php echo $invoice ?>';
</script>