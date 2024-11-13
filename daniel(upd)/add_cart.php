<?php
session_start();
include('./connect.php');

if(isset($_SESSION['username']))  {
    $id = $_GET['id'];
    $username = $_SESSION['username'];
    $status = 'Cart';

    // Fetch user details from the user table
    $userQuery = mysqli_query($conn, "SELECT name, address, contact FROM user WHERE username = '$username'");

    // Check if the query was successful
    if (!$userQuery) {
        echo '<script>alert("Error fetching user details: ' . mysqli_error($conn) . '");window.history.back();</script>';
        exit;
    }

    $user = mysqli_fetch_assoc($userQuery);

    if ($user) {
        // Capture user details
        $name = $user['name'];
        $address = $user['address'];
        $contact = $user['contact'];
    } else {
        echo '<script>alert("User  details not found.");window.history.back();</script>';
        exit;
    }

    if(isset($_GET['quantity'])) {
        $quantity = $_GET['quantity'];
    } else {
        $quantity = '1';
    }
    
    $date = date('Y-m-d');
    $size = $_GET['size'];
    $r = mysqli_query($conn,"SELECT * FROM product WHERE id = '$id'");

    // Check if the product query was successful
    if (!$r) {
        echo '<script>alert("Error fetching product details: ' . mysqli_error($conn) . '");window.history.back();</script>';
        exit;
    }

    while($row  = mysqli_fetch_array($r)) {
        $quan = $row['quantity'];
    }

    if($quantity <= $quan) { // Changed < to <= to allow max quantity
        // Insert into cart with additional fields
        mysqli_query($conn,"INSERT INTO cart (product, quantity, status, username, name, address, contact) VALUES ('$id', '$quantity', '$status', '$username', '$name', '$address', '$contact')");
        echo '<script>alert("Item has been added to cart");window.history.back();</script>';
    } else {
        echo '<script>alert("You can only purchase '.$quan.' piece/s of this item.");window.history.back();</script>';
    }
} else {
    echo '<script>alert("Please login to continue");window.history.back();</script>';
}
?>