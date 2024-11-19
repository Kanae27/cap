<?php
session_start();
include('./connect.php');
if(isset($_SESSION['username']))  {
	$id = $_GET['id'];
	$username = $_SESSION['username'];
	$status = 'Heart';
	if(isset($_GET['quantity'])) {
		$quantity = $_GET['quantity'];
	} else {
		$quantity = '1';
	}
	$date = date('Y-m-d');
	mysqli_query($conn,"INSERT INTO cart (product, quantity, status,username)VALUES ('$id','$quantity','$status','$username')");
	echo '<script>alert("Item has been added to favorites");window.history.back();</script>';
} else {
	echo '<script>alert("Please login to continue");window.history.back();</script>';
}

?>