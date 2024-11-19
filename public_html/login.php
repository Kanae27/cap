<?php


// If user is already logged in, redirect to appropriate dashboard
if (isset($_SESSION['username'])) {
    switch($_SESSION['type']) {
        case 'admin':
            header("Location: admin/index.php");
            exit();
        case 'store':
            header("Location: store/index.php");
            exit();
        case 'user':
            header("Location: index.php");
            exit();
    }
}

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
$hideSearchAndLogin = true;
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
    <style>
    body {
        background: url('./images/d.jpg') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }
    
    /* For debugging - add a fallback color in case image fails to load */
    body {
        background-color: #FFFBE6;
    }
    
    /* Add overlay to make text more readable */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 251, 230, 0.85); /* Semi-transparent version of #FFFBE6 */
        z-index: -1;
    }

    /* Update card styles for better contrast */
    .card {
        backdrop-filter: blur(5px);
        background: rgba(255, 255, 255, 0.95) !important;
    }
    
    .card {
        border: none;
        border-radius: 15px;
        background: white;
        box-shadow: 0 0 20px rgba(0,0,0,0.1) !important;
    }
    
   .card-header {
    border-radius: 15px 15px 0 0 !important;
    background-color: #347928 !important;
    border-bottom: none;
    }

   .card-header.text-center.bg-primary h3 {
    color: white !important;
    }
    
    .btn-primary {
        background-color: #347928;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .login-text {
    color: white !important;
    }

    .btn-primary i {
    color: white !important;
    }
    .btn-primary:hover {
        background-color: #2a6320;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 121, 40, 0.3);
    }
    
    .btn-outline-primary {
        color: #347928;
        border-color: #347928;
        border-radius: 8px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }
    
    .btn-outline-primary:hover {
        background-color: #347928;
        border-color: #347928;
        transform: translateY(-2px);
    }
    
    .form-control {
        border-radius: 0 8px 8px 0;
        padding: 12px;
        border: 1px solid #ddd;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 8px 0 0 8px;
        min-width: 40px;
        display: flex;
        justify-content: center;
    }
    
    .form-control:focus {
        border-color: #347928;
        box-shadow: 0 0 0 0.2rem rgba(52, 121, 40, 0.25);
    }
    
    .text-primary {
        color: #347928 !important;
    }
    
    .fa-user-circle {
        color: #347928;
        margin-bottom: 1rem;
    }
    
    a {
        color: #347928;
        transition: all 0.3s ease;
    }
    
    a:hover {
        color: #2a6320;
        text-decoration: none;
    }

    /* Animation for the card */
    .card {
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
        
        .container {
            padding-top: 2rem !important;
        }
    }
    </style>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white py-3">
                        <h3 class="mb-0">Welcome Back!</h3>
                    </div>
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-circle fa-3x text-primary mb-3"></i>
                        </div>
                        <form action="" method="POST">
                            <div class="form-group mb-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-lg mb-4">
                                <i class="fas fa-sign-in-alt mr-2"></i> <span class="login-text">Login</span>
                            </button>
                        </form>
                        <div class="text-center">
                            <p class="mb-2">Don't have an account?</p>
                            <a href="register.php" class="btn btn-outline-primary">
                                <i class="fas fa-user-plus mr-2"></i> Register here
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>