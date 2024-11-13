<?php
include('../auth.php');
include('../connect.php');
$username =$_SESSION['username'];
$r = mysqli_query($conn,"SELECT * FROM login WHERE username = '$username'");
while($row=  mysqli_fetch_array($r)) {
	$password1 = $row['password'];
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../img/logo.png" type="image/png" />

    <title>Daniel and Marilyn's General Merchandise</title>

    <!-- Bootstrap -->
    <!-- Bootstrap --><script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 50%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #2A3F54;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #2A3F54;
  color: white;
}

/* Product Image Alignment */
.product-image-container {
    width: 100%;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    overflow: hidden;
    padding: 10px;
}

.product-image-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    display: block;
    margin: auto;
}

/* Table Product Images */
.table-product-image {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-radius: 4px;
    overflow: hidden;
    margin: auto;
}

.table-product-image img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}

/* Product Grid Images */
.product-grid-image {
    width: 100%;
    height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    overflow: hidden;
    padding: 15px;
}

.product-grid-image img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .product-image-container {
        height: 150px;
    }
    
    .table-product-image {
        width: 60px;
        height: 60px;
    }
    
    .product-grid-image {
        height: 200px;
    }
}
</style>
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-solid.css">
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-regular.css">
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-light.css" >
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view" style="background:#347928 !important">
            <div class="navbar nav_title"  style="background:#347928 !important;boder:0">
              <a href="index.php" class="site_title">
			  <img src="../img/logo.png" style="width:50px"> <span>Administrator</span></a>
            </div>

            <div class="clearfix"></div>

          
            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="index.php" style="border-bottom:1px solid #FFF"><i class="fa fa-home"></i> Dashboard </a></li>
                  <li style="display:none"><a href="store.php" style="border-bottom:1px solid #FFF"><i class="fa-solid fa-store"  style="font-size:20px"></i> &nbsp;POS List </a>
                  </li>
                  <li><a href="category.php" style="border-bottom:1px solid #FFF"><i class="fa-solid fa-list" style="font-size:20px"></i> &nbsp;Category List </a></li>
                  <li><a href="product.php" style="border-bottom:1px solid #FFF"><i class="fa-solid fa-sitemap" style="font-size:20px"></i> &nbsp;Product List </a></li>
                  <li><a href="sales_report.php" style="border-bottom:1px solid #FFF"><i class="fa-light fa-file-chart-column"  style="font-size:20px"></i> &nbsp;Sales Report </a></li>
                <li style="display:none" style="border-bottom:1px solid #FFF"><a href="audit.php"><i class="fa fa-list"></i> Audit Trail </a></li>
                <li><a href="settings.php" style="border-bottom:1px solid #FFF"><i class="fa fa-gear"></i> Account Settings </a></li>
                <li><a href="../logout.php" style="border-bottom:1px solid #FFF" onclick="return confirm('Are you sure you want to logout?')"><i class="fa-solid fa-right-from-bracket" style="font-size:20px"></i>&nbsp; Logout </a></li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            
          </div>
        </div>
<style>

.sp, .btn {
	margin-right:5px !important;
}

.btn-success {
	background:#347928 !important;
	border:1px solid #181824 !important;
}
.btn-primary, .btn-default, buttons-print {
	background:#347928 !important;
	border:1px solid #000;
}
</style>