<?php
include('./connect.php');

$items_per_page = 16;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Get products for requested page
$result = $conn->query("SELECT * FROM product ORDER BY RAND() LIMIT $offset, $items_per_page");

while($row = $result->fetch_assoc()) {
    $item = $row['id'];
    $r = mysqli_query($conn,"SELECT *, AVG(rating) as av FROM rating WHERE item = '$item' GROUP BY item");
    $c1 = mysqli_num_rows($r);
    
    $r2 = mysqli_query($conn,"SELECT * FROM rating WHERE item = '$item'");
    $s = mysqli_num_rows($r2);
    while($r1 = mysqli_fetch_array($r)) {
        $rating = $r1['av'];
    }
    ?>
    <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <!-- Existing product item HTML -->
        <?php /* Copy the product item HTML from index.php */ ?>
    </div>
    <?php
}
?> 