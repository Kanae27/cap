<?php

include "connect.php";

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

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $username = validate($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username)) {
        echo '<script>alert("Username is required");window.location="login.php";</script>';
        exit();
    } else if(empty($password)) {
        echo '<script>alert("Password is required");window.location="login.php";</script>';
        exit();
    }

    // Prepare statement with JOIN
    $stmt = $conn->prepare("SELECT l.*, u.email 
                           FROM login l 
                           INNER JOIN user u ON l.id = u.id 
                           WHERE u.email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if ($row['password'] === $password) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['type'] = $row['type'];
            
            if($row['type'] == 'admin') {
                echo '<script>window.location="admin/index.php";</script>';
            }
            else if($row['type'] == 'store') {
                echo '<script>window.location="store/index.php";</script>';
            }
            else if($row['type'] == 'user') {
                echo '<script>window.location="./index.php";</script>';
            }
            exit();
        } else {
            echo '<script>alert("Password is incorrect");window.location="login.php";</script>';
            exit();
        }
    } else {
        echo '<script>alert("User not found");window.location="login.php";</script>';
        exit();
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