<?php
include('./connect.php');
$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM cart WHERE id = '$id'");
?>
<script>
alert("Item has been deleted");
window.history.back();
</script>