<?php
$conn = mysqli_connect('localhost','root','','studentmsdb');
if(!$conn){
	echo "Connection Failed: ". mysqli_connect_error();
	exit;
}
?>