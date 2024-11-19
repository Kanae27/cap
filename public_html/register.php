<?php 
include "connect.php";
include 'header.php';

if(isset($_POST['submit'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    
    $name = validate($_POST['name']);
    $address = validate($_POST['address']);
    $contact = validate($_POST['contact']);
    $email = validate($_POST['email']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $type = 'user';

    if (empty($username) || empty($password) || empty($name) || empty($contact) || empty($address) || empty($email)) {
        echo '<script>alert("All fields are required");window.history.back();</script>';
    } else {
        // Check if username already exists
        $r = mysqli_query($conn,"SELECT * FROM login WHERE username = '$username'");
        $s = mysqli_num_rows($r);
        
        if($s > 0) {
            echo '<script>alert("The username you are trying to register is already exist");window.history.back();</script>';
        } else {
            // First insert into login table
            $sql1 = "INSERT INTO login (username, password, type) VALUES ('$username','$password','$type')";
            $result1 = mysqli_query($conn, $sql1);

            // Then insert into user table
            $sql2 = "INSERT INTO user (name, address, contact, email, username) VALUES ('$name','$address','$contact','$email','$username')";
            $result2 = mysqli_query($conn, $sql2);

            // Check if both queries were successful
            if($result1 && $result2) {
                echo '<script>alert("Account has been registered");window.location.href="login.php";</script>';
            } else {
                // If there was an error, show which query failed
                if(!$result1) {
                    echo '<script>alert("Error inserting into login table: ' . mysqli_error($conn) . '");window.history.back();</script>';
                }
                if(!$result2) {
                    echo '<script>alert("Error inserting into user table: ' . mysqli_error($conn) . '");window.history.back();</script>';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Daniel and Marilyn's General Merchandise</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>
<body style="background:#FFFBE6">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4">Register</h3>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact Number</label>
                                <input type="text" class="form-control" id="contact" name="contact" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php">Already have an account? Login here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>