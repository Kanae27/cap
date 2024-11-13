<?php
include('../connect.php');
session_start();

	$username = '';
	$item = $_POST['item'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$image = $_POST['img'];
	$category = $_POST['category'];
	$compatibility = '';
	$quantity = $_POST['quantity'];
	$type_quantity =$_POST['type_quantity'];
	$barcode = '';
$description = mysqli_real_escape_string($conn,$description);
$save = $conn->query("INSERT INTO product (username, item, description,price,image,category,compatibility,quantity,barcode,type_quantity)VALUES ('$username', '".mysqli_real_escape_string($conn,$item)."','".mysqli_real_escape_string($conn,$description)."', '$price','$image','$category','$compatibility','$quantity','$barcode','$type_quantity')");
if($save) {
	echo '<script>window.location="product.php"</script>';
}
$conn->close();
?>