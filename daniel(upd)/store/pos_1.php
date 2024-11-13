<?php
session_start();
$_SESSION['name1'] = $_GET['name'];
$_SESSION['address1'] = $_GET['address'];
$_SESSION['contact1'] = $_GET['contact'];
$_SESSION['invoice1'] = $_GET['invoice'];
$_SESSION['email'] = $_GET['email'];
?>
<script>
window.location='pos_.php';
</script>