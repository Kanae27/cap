<?php
include('../connect.php');
session_start();
	$username = $_SESSION['username'];
	$item = $_POST['item'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$image = $_POST['img'];
	$category = $_POST['category'];
	$compatibility = $_POST['compatibility'];
	$quantity = $_POST['quantity'];
	$barcode = $_POST['barcode'];
$description = mysqli_real_escape_string($conn,$description);
$save = $conn->query("INSERT INTO product (username, item, description,price,image,category,compatibility,quantity,barcode)VALUES ('$username', '".mysqli_real_escape_string($conn,$item)."','".mysqli_real_escape_string($conn,$description)."', '$price','$image','$category','$compatibility','$quantity','$barcode')");
if($save) {
	echo '<script>alert("Product has been added has been added");window.location="product.php"</script>';
}
$conn->close();
?>