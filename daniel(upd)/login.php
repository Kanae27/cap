<?php 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Origin: *');
include "connect.php";
include 'header.php';

// Replace the existing require statements with:
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Add the sendMfaCode function
function sendMfaCode($email, $mfaCode) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'danielandmarilyn64@gmail.com';
        $mail->Password = 'sfke dkqp ensv fzod';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('danielandmarilyn64@gmail.com', 'Daniel and Marilyn General Merchandise');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your MFA Code';
        $mail->Body = "Your multi-factor authentication code is: <strong>$mfaCode</strong>";
        $mail->AltBody = "Your multi-factor authentication code is: $mfaCode";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    
    $username = validate($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username)) {
        echo '<script>alert("Username is required");window.location="login.php";</script>';
    } else if(empty($password)) {
        echo '<script>alert("Password is required");window.location="login.php";</script>';
    } else {
        // Add debug statement to see current database
        error_log("Current database: " . mysqli_select_db($conn, "your_database_name"));

        // Modified query to join by ID and check email/password
        $sql = "SELECT l.*, u.email 
                FROM login l 
                INNER JOIN user u ON l.id = u.id 
                WHERE u.email='$username'";
        
        // Debug the exact SQL query
        error_log("SQL Query: " . $sql);
        
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            error_log("MySQL Error: " . mysqli_error($conn));
            die("Query failed: " . mysqli_error($conn));
        }
        
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            // Debug the retrieved data
            error_log("Retrieved data: " . print_r($row, true));
            error_log("Stored password: " . $row['password']);
            error_log("Submitted password: " . $password);
            
            $password1 = $row['password'];
            $user = $row['username'];
            $type = $row['type'];
            $email = $row['email']; // Now fetching email from users table
            
            if($password1 != $password) {
                echo '<script>alert("Password is incorrect");window.location="login.php";</script>';
            } else {
                // Generate MFA code
                $mfaCode = sprintf("%06d", mt_rand(0, 999999));
                $_SESSION['mfa_code'] = $mfaCode;
                $_SESSION['temp_user'] = $user;
                $_SESSION['temp_type'] = $type;
                
                // Send MFA code via email
                if (sendMfaCode($email, $mfaCode)) {
                    // Redirect to MFA verification page
                    echo '<script>window.location="verify_mfa.php";</script>';
                } else {
                    echo '<script>alert("Failed to send MFA code. Please try again.");window.location="login.php";</script>';
                }
            }
        } else {
            echo '<script>alert("Login Failed. Invalid User ID or password");window.location="login.php";</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Daniel and Marilyn's General Merchandise</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>
<body style="background:#FFFBE6">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4">Login</h3>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="register.php">Don't have an account? Register here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .card {
        border: none;
        border-radius: 10px;
        background: white;
    }
    
    .btn-primary {
        background-color: #347928;
        border: none;
        padding: 10px;
        border-radius: 5px;
    }
    
    .btn-primary:hover {
        background-color: #2a6320;
    }
    
    .form-control {
        border-radius: 5px;
        padding: 10px;
    }
    
    .form-control:focus {
        border-color: #347928;
        box-shadow: 0 0 0 0.2rem rgba(52, 121, 40, 0.25);
    }
    
    a {
        color: #347928;
    }
    
    a:hover {
        color: #2a6320;
        text-decoration: none;
    }
    </style>
</body>
</html>