<?php
$servername = "localhost";
$username1 = "u154080756_root";
$password1 = "@Danielgstore1";
$dbname = "u154080756_daniel";

// Create connection
$conn = new mysqli($servername, $username1, $password1, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
date_default_timezone_set('Asia/Manila');

?>