<?php
include('../connect.php');

mysqli_query($conn, "UPDATE notifications SET is_read = 1 WHERE is_read = 0");
echo "success";
?> 