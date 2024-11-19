<?php
include('../connect.php');
session_start();

					$message = 'Administrator added a product';
					$date = date('F d, Y h:i A');
					$username = $username;
			//	$save = $conn->query("INSERT INTO audit (action, timestamp,username)VALUES ('$message','$date','$username')");

	$username = '';
	$item = $_POST['item'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$image = $_POST['img'];
	$category = mysqli_real_escape_string($conn,$_POST['category']);
	$compatibility = '';
	$quantity = $_POST['quantity'];
	$barcode = '';
$description = mysqli_real_escape_string($conn,$description);
$save = $conn->query("INSERT INTO product (username, item, description,price,image,category,compatibility,quantity,barcode)VALUES ('$username', '".mysqli_real_escape_string($conn,$item)."','".mysqli_real_escape_string($conn,$description)."', '$price','$image','$category','$compatibility','$quantity','$barcode')");
if($save) {
	echo '<script>window.location="product_list.php"</script>';
}
$conn->close();
?>