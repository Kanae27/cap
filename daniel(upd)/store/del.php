<?php
include('../connect.php');
session_start();
$username = $_SESSION['username'];
$result = $conn->query("DELETE FROM cart WHERE username = '$username' AND status = 'Pending'");
?>
<script>
alert("POS has been cleared");
window.location='pos.php';
</script>