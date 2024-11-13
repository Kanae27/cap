<?php
include('../connect.php');
$id =$_GET['id'];
$result = $conn->query("DELETE FROM cart WHERE id = '$id'");
?>
<script>
window.history.back();
</script>