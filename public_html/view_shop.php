<?php
include('./header.php');
?>

<!-- Add this style section at the top of your file -->
<style>
.product-item {
    height: 100%;
    display: flex;
    flex-direction: column;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.product-img {
    position: relative;
    width: 100%;
    height: 200px; /* Fixed height for all product images */
    overflow: hidden;
}

.product-img img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Maintains aspect ratio */
    object-position: center;
    transition: transform 0.3s ease;
}

.product-img:hover img {
    transform: scale(1.05);
}

.product-action {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.7);
    opacity: 0;
    transition: all 0.3s;
}

.product-action:hover {
    opacity: 1;
}

.product-action .btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    margin: 0 5px;
    border-radius: 50%;
    background: white;
    transition: all 0.3s;
}

.product-action .btn:hover {
    background: #347928;
    color: white;
}

.text-center {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
}

.text-truncate {
    max-width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #333;
    font-weight: 500;
}

.col-lg-2 {
    margin-bottom: 20px;
}

/* Price styling */
h5 {
    color: #347928;
    margin: 0;
    font-weight: 600;
}

/* Rating stars */
.fa-star {
    color: #FFD700 !important;
}

.far.fa-star {
    color: #ddd !important;
}

/* No results found styling */
h2 {
    width: 100%;
    text-align: center;
    padding: 2rem;
    color: #666;
}

.pagination {
    margin: 20px 0;
}

.pagination .page-link {
    color: #347928;
    border-color: #347928;
    padding: 8px 16px;
}

.pagination .page-item.active .page-link {
    background-color: #347928;
    border-color: #347928;
    color: white;
}

.pagination .page-link:hover {
    background-color: #e9ecef;
    color: #347928;
}
</style>

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Add category name display -->
            <div class="col-12">
         <?php
// Ensure the database connection is valid
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);

    // Query to fetch products based on category ID
    $result = $conn->query("SELECT * FROM product WHERE category = '$id'");

    // Check if the query executed successfully
    if (!$result) {
        die('Query failed: ' . mysqli_error($conn));
    }

    // Check if any products are returned
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        echo '<h2 class="text-center mb-4"> ' . htmlspecialchars($id) . '</h2>';
        
        // Loop through the products and display them
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product">';
           
        }
    } else {
        // No products found for the given category
        echo '<h2 class="text-center mb-4">No products found for this category</h2>';
    }
} else {
    // If 'id' is not set in the URL
    echo '<h2 class="text-center mb-4">No category ID provided</h2>';
}
?>


            </div>

            <!-- Shop Product Start -->
            <div class="col-lg-12 col-md-8">
                <div class="row pb-3">
                    <?php
                    include('./connect.php');
                    
                    // Pagination setup
                    $items_per_page = 12;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $start_from = ($page - 1) * $items_per_page;
                    
                    // Get category ID and sanitize it
                    $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';
                    
                    // First, get total count of products
                    $count_sql = "SELECT COUNT(*) as total FROM product WHERE category = '$id'";
                    $count_result = mysqli_query($conn, $count_sql);
                    $count_data = mysqli_fetch_assoc($count_result);
                    $total_products = $count_data['total'];
                    $total_pages = ceil($total_products / $items_per_page);
                    
                    // Get products for current page
                    $sql = "SELECT * FROM product WHERE category = '$id' LIMIT $start_from, $items_per_page";
                    $result = mysqli_query($conn, $sql);
                    
                    if(mysqli_num_rows($result) == 0) {
                        echo '<h2>No Results Found</h2>';
                    }
                    
                    // Display products
                    while($row = mysqli_fetch_assoc($result)) {
                        // Get rating
                        $item = $row['id'];
                        $r = mysqli_query($conn, "SELECT AVG(rating) as av FROM rating WHERE item = '$item'");
                        $r2 = mysqli_query($conn, "SELECT COUNT(*) as count FROM rating WHERE item = '$item'");
                        $rating_data = mysqli_fetch_assoc($r);
                        $rating_count = mysqli_fetch_assoc($r2);
                        $rating = $rating_data['av'];
                        $s = $rating_count['count'];
                        ?>
                        
                        <div class="col-lg-2 col-md-4 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="<?php echo $row['image'] ?>" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href="details.php?id=<?php echo $row['id'] ?>"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href=""><?php echo $row['item'] ?></a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>&#8369;  <?php echo number_format($row['price'],2) ?></h5></h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                    <?php
                                                    if($rating == '5') {
                                                            echo '<small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>';
                                                    }
                                                    if($rating == '4') {
                                                            echo '<small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="far fa-star text-primary mr-1"></small>';
                                                    }
                                                    if($rating == '3') {
                                                            echo '<small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="far fa-star text-primary mr-1"></small>
                                                            <small class="far fa-star text-primary mr-1"></small>';
                                                    }
                                                    if($rating == '2') {
                                                            echo '<small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="fa fa-star text-primary mr-1"></small>
                                                            <small class="far fa-star text-primary mr-1"></small>
                                                            <small class="far fa-star text-primary mr-1"></small>
                                                            <small class="far fa-star text-primary mr-1"></small>';
                                                    }
                                                    if($rating == '1') {
                                                            echo '<small class="fa fa-star text-primary mr-1"></small>
                                                                 <small class="far far-star text-primary mr-1"></small>
                                                                 <small class="far fa-star text-primary mr-1"></small>
                                                                 <small class="far fa-star text-primary mr-1"></small>
                                                                 <small class="far fa-star text-primary mr-1"></small>
                                                                 <small class="far fa-star text-primary mr-1"></small>';
                                                    }
                                                    if($rating == '') {
                                                            echo '<small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small>';
                                                    }
                                                   
                                                ?>
                                <small>(<?php echo $s ?>)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <!-- Pagination -->
                    <?php if($total_pages > 1): ?>
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <!-- Previous button -->
                                <?php if($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?id=<?php echo $id; ?>&page=<?php echo ($page-1); ?>">Previous</a>
                                </li>
                                <?php endif; ?>

                                <!-- Page numbers -->
                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?id=<?php echo $id; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>

                                <!-- Next button -->
                                <?php if($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?id=<?php echo $id; ?>&page=<?php echo ($page+1); ?>">Next</a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

<?php

?>