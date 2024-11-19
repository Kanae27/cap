<?php
include('../connect.php');
$id =$_GET['id'];
mysqli_query($conn,"DELETE FROM product WHERE id = '$id'");
?>
<script>
alert("Product has been deleted");
window.location='product_list.php';
</script>