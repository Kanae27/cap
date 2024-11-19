<?php
include('../connect.php');
$user = $_GET['user'];
$conn->query("UPDATE cart SET status = 'Declined' WHERE username = '$user' AND status = 'Pending'");
?>
<script>
alert("Orders has been declined");
window.location='sale.php';
</script>