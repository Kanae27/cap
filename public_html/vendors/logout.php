<?php
session_start();
include('./connect.php');
$username = $_SESSION['username'];
date_default_timezone_set('Asia/Manila');
					$message = 'Admin account logged out';
					$date = date('F d, Y h:i A');
					$username = $username;
			//	$save = $conn->query("INSERT INTO audit (action, timestamp,username)VALUES ('$message','$date','$username')");
session_destroy();
header("Location: index.php");
?>