<?php
include('./connect.php');
session_start();

// Initialize variables
$profile = 'default_profile.png'; 
$name = ''; 
$cart = 0;
$heart = 0;

if(isset($_SESSION['username']))  {
    $username = $_SESSION['username'];
    $r = mysqli_query($conn,"SELECT * FROM user WHERE username = '$username'");
    while($row = mysqli_fetch_array($r)) {
        $name = $row['name'];
        $profile = $row['image'];
        if($profile == '') {
            $profile = 'profile.png';
        }
    }
    
    //check cart and favorites count
    $c = mysqli_query($conn,"SELECT * FROM cart WHERE username = '$username' AND status = 'Cart'");
    $cart = mysqli_num_rows($c);
    $h = mysqli_query($conn,"SELECT * FROM cart WHERE username = '$username' AND status = 'Heart'");
    $heart = mysqli_num_rows($h);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Daniel and Marilyn's General Merchandise</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body style="background:#FFFBE6">
    <!-- Top bar -->
    <div class="container-fluid">
        <div class="row align-items-center bg-light py-3 px-xl-5" style="background:#347928 !important">
            <div class="col-lg-4">
                <a href="index.php" class="text-decoration-none">
                    <div class="row">
                        <div class="col-lg-2">
                            <img src="./img/logo.PNG" style="width:100%;border:1px solid #d3d3d3">
                        </div>
                        <div class="col-lg-10">
                            <span class="h3 text-uppercase text-primary px-2" style="color:#FCCD2A">Daniel and Marilyn's</span>
                            <span class="h3 text-uppercase text-dark px-2 ml-n1" style="color:#FCCD2A !important">General Merchandise</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="search.php" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products" name="search">
                        <div class="input-group-append">
                            <button class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <div class="profile-menu">
                    <?php if(isset($_SESSION['username'])) { ?>
                        <div class="profile-header" onclick="toggleDropdown()">
                            <img src="./uploads/<?php echo $profile ?>" alt="Profile" class="profile-pic">
                            <span class="profile-name"><?php echo $name ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="dropdown-content" id="profileDropdown">
                            <a href="index.php"><i class="fas fa-home"></i>Home</a>
                            
                            <div class="dropdown-divider"></div>
                            <a href="favorites.php">
                                <i class="fas fa-heart"></i>Favorites
                                <?php if($heart > 0) { ?>
                                    <span class="badge"><?php echo $heart ?></span>
                                <?php } ?>
                            </a>
                            <a href="cart.php">
                                <i class="fas fa-shopping-cart"></i>Cart
                                <?php if($cart > 0) { ?>
                                    <span class="badge"><?php echo $cart ?></span>
                                <?php } ?>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="profile.php"><i class="fas fa-user"></i>Profile</a>
                            <a href="history.php"><i class="fas fa-history"></i>History</a>
                            <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')">
                                <i class="fas fa-sign-out-alt"></i>Logout
                            </a>
                        </div>
                    <?php } else { ?>
                        <a href="login.php" class="btn btn-primary login-btn">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

<style>
.profile-menu {
    position: relative;
    display: inline-block;
}

.profile-header {
    display: flex;
    align-items: center;
    background: #FCCD2A;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    white-space: nowrap;
}

.profile-pic {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 10px;
    border: 1px solid #d3d3d3;
}

.profile-name {
    color: #000;
    margin-right: 10px;
    font-weight: 500;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background: white;
    width: 100%;
    min-width: fit-content;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    border-radius: 5px;
    z-index: 1000;
}

.dropdown-content a {
    color: #333;
    padding: 8px 15px;
    text-decoration: none;
    display: flex;
    align-items: center;
    white-space: nowrap;
}

.dropdown-content a i {
    width: 16px;
    margin-right: 8px;
    text-align: center;
}

.dropdown-divider {
    border-top: 1px solid #eee;
    margin: 4px 0;
}

.badge {
    background: #dc3545;
    color: white;
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 12px;
    margin-left: 8px;
}

.login-btn {
    background: #347928;
    border: none;
    padding: 8px 20px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
}

.login-btn:hover {
    background: #2a6320;
    color: white;
}

.dropdown-content a:hover {
    background: #f5f5f5;
}

.profile-header, .dropdown-content {
    min-width: max-content;
}
</style>

<script>
function toggleDropdown() {
    const dropdown = document.getElementById("profileDropdown");
    const header = document.querySelector(".profile-header");
    
    dropdown.style.width = header.offsetWidth + "px";
    
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}

// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.profile-header') && !event.target.matches('.profile-header *')) {
        document.getElementById("profileDropdown").style.display = "none";
    }
}
</script>