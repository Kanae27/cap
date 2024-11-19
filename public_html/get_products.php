<?php
include('./connect.php');

// Validate and sanitize the page number
$items_per_page = 16;
$page = isset($_GET['featured_page']) ? max(1, (int)$_GET['featured_page']) : 1;
$offset = ($page - 1) * $items_per_page;

// Get total number of products
$total_query = $conn->query("SELECT COUNT(*) as total FROM product");
$total_products = $total_query->fetch_assoc()['total'];
$total_pages = ceil($total_products / $items_per_page);

// Ensure page number is within valid range
$page = min($page, $total_pages);

// Get products for current page
$result = $conn->query("SELECT * FROM product ORDER BY RAND() LIMIT $offset, $items_per_page");

if ($result === false) {
    // Handle query error
    echo "Error: " . $conn->error;
    exit;
}

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
        <div class="product-item bg-light mb-4">
            <div class="product-img position-relative overflow-hidden" style="width: 100%; padding-top: 100%;">
                <img class="img-fluid position-absolute top-0 left-0" src="<?php echo $row['image'] ?>" alt="Product Image" style="width: 100%; height: 100%; object-fit: cover; top: 0; left: 0;">
                <div class="product-action">
                    <a class="btn btn-outline-dark btn-square" href="add_heart.php?id=<?php echo $row['id'] ?>"><i class="far fa-heart"></i></a>
                    <a class="btn btn-outline-dark btn-square" href="details.php?id=<?php echo $row['id'] ?>"><i class="fa fa-search"></i></a>
                </div>
            </div>
            <div class="text-center py-4">
                <span class="h6 text-truncate"><?php echo $row['item'] ?></span>
                <div class="d-flex align-items-center justify-content-center mt-2">
                    <h5>&#8369; <?php echo number_format($row['price'],2) ?></h5>
                </div>
                <div class="d-flex align-items-center justify-content-center mb-1">
                    <?php
                    if($c1>0) {
                        if($rating == '5') {
                            echo '<small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>';
                        }
                        // ... rest of your rating display logic ...
                    } else {
                        echo '<small class="far fa-star text-primary mr-1"></small>
                        <small class="far fa-star text-primary mr-1"></small>
                        <small class="far fa-star text-primary mr-1"></small>
                        <small class="far fa-star text-primary mr-1"></small>
                        <small class="far fa-star text-primary mr-1"></small>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>