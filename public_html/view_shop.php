<?php
include('./header.php');
include('./connect.php');

// Initialize category_name variable
$category_name = '';

// After database connection check, modify this section:
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);

    // Query to fetch the category name
    $category_query = "SELECT name FROM category WHERE id = '$id'";
    $category_result = mysqli_query($conn, $category_query);
    
    if ($category_result && mysqli_num_rows($category_result) > 0) {
        $category_row = mysqli_fetch_assoc($category_result);
        $category_name = htmlspecialchars($category_row['name']);
    } else {
        // For debugging
        error_log("Category query failed or no results: " . mysqli_error($conn));
        
    }
} else {
    $category_name = "All Categories";
}
?>

<!-- Breadcrumb Navigation -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="index.php">Home</a>
                <span class="breadcrumb-item active">Shop</span>
            </nav>
        </div>
    </div>
</div>

<!-- Rest of your content -->
<?php
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
        echo '<h2 class="text-left mb-4"> Search Result for: ' .htmlspecialchars($id) . '</h2>';
        
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

// Can you also show me the structure of your category table? 
// Run this query temporarily:

?>

<!-- Category Name Display -->
<?php if ($category_name): ?>
    <div class="container-fluid mb-4">
        <div class="row px-xl-5">
            <div class="col-12">
                <div class="bg-secondary p-4">
                    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4" style="display: flex; justify-content: flex-end;">
                        <span class="bg-secondary pr-3"><?php echo $category_name; ?></span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Filter Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
            <div class="bg-light p-4 mb-30">
                <form method="GET" action="">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" name="price_range" class="custom-control-input" id="price-all" value="all" <?php echo (!isset($_GET['price_range']) || $_GET['price_range'] == 'all') ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-all">All Price</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" name="price_range" class="custom-control-input" id="price-1" value="0-1000" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '0-1000') ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-1">₱0 - ₱1000</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" name="price_range" class="custom-control-input" id="price-2" value="1000-2000" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '1000-2000') ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-2">₱1000 - ₱2000</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" name="price_range" class="custom-control-input" id="price-3" value="2000-3000" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '2000-3000') ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-3">₱2000 - ₱3000</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="radio" name="price_range" class="custom-control-input" id="price-4" value="3000+" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] == '3000+') ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="price-4">₱3000+</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm mt-2">Apply Filter</button>
                </form>
            </div>
            <!-- Price Filter End -->
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <!-- Sorting Controls -->
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <!-- Sorting Button -->
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="?id=<?php echo $id; ?>&sort=latest<?php echo isset($_GET['price_range']) ? '&price_range='.$_GET['price_range'] : ''; ?>">Latest</a>
                                        <a class="dropdown-item" href="?id=<?php echo $id; ?>&sort=price_low<?php echo isset($_GET['price_range']) ? '&price_range='.$_GET['price_range'] : ''; ?>">Price Low</a>
                                        <a class="dropdown-item" href="?id=<?php echo $id; ?>&sort=price_high<?php echo isset($_GET['price_range']) ? '&price_range='.$_GET['price_range'] : ''; ?>">Price High</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="bg-secondary p-4">
                        <div class="row px-xl-5">
                            <?php
                            include('./connect.php');
                            
                            // Pagination setup
                            $items_per_page = 16;
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
                            
                            // Add this near your existing SQL query
                            $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
                            
                            $sql = "SELECT * FROM product WHERE category = '$id'";
                            
                            // Add price range filter
                            if(isset($_GET['price_range']) && $_GET['price_range'] != 'all') {
                                switch($_GET['price_range']) {
                                    case '0-1000':
                                        $sql .= " AND price BETWEEN 0 AND 1000";
                                        break;
                                    case '1000-2000':
                                        $sql .= " AND price BETWEEN 1000 AND 2000";
                                        break;
                                    case '2000-3000':
                                        $sql .= " AND price BETWEEN 2000 AND 3000";
                                        break;
                                    case '3000+':
                                        $sql .= " AND price > 3000";
                                        break;
                                }
                            }
                            
                            // Add sorting
                            if(isset($_GET['sort'])) {
                                switch($_GET['sort']) {
                                    case 'latest':
                                        $sql .= " ORDER BY id DESC";
                                        break;
                                    case 'price_low':
                                        $sql .= " ORDER BY price ASC";
                                        break;
                                    case 'price_high':
                                        $sql .= " ORDER BY price DESC";
                                        break;
                                    default:
                                        $sql .= " ORDER BY id DESC";
                                }
                            } else {
                                $sql .= " ORDER BY id DESC";
                            }
                            
                            // Add pagination limit at the end
                            $sql .= " LIMIT $start_from, $items_per_page";
                            
                            $result = mysqli_query($conn, $sql);
                            
                            if(mysqli_num_rows($result) == 0) {
                                echo '<h2>No Results Found</h2>';
                            }
                            
                            // Display products
                            while($row = mysqli_fetch_assoc($result)) {
                                $item = $row['id'];
                                $r = mysqli_query($conn, "SELECT AVG(rating) as av FROM rating WHERE item = '$item'");
                                $r2 = mysqli_query($conn, "SELECT COUNT(*) as count FROM rating WHERE item = '$item'");
                                $rating_data = mysqli_fetch_assoc($r);
                                $rating_count = mysqli_fetch_assoc($r2);
                                $rating = $rating_data['av'];
                                $s = $rating_count['count'];
                                ?>
                                
                                <div class="col-lg-2.4 col-md-4 col-sm-6 pb-1" style="flex: 0 0 20%; max-width: 20%;">
                                    <div class="product-item bg-green mb-4" style="border-radius: 15px; overflow: hidden; border: 2px solid #28a745;">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height: 250px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;" src="<?php echo $row['image'] ?>" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href="details.php?id=<?php echo $row['id'] ?>"><i class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="" style="color: #28a745;"><?php echo $row['item'] ?></a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>₱<?php echo number_format($row['price'],2) ?></h5>
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
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <?php if($total_pages > 1): ?>
                <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center mt-4">
                            <?php
                            $query_params = [];
                            if(isset($_GET['price_range'])) $query_params[] = "price_range=" . $_GET['price_range'];
                            if(isset($_GET['sort'])) $query_params[] = "sort=" . $_GET['sort'];
                            $query_string = !empty($query_params) ? '&' . implode('&', $query_params) : '';
                            ?>

                            <?php if($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?id=<?php echo $id; ?>&page=<?php echo ($page-1) . $query_string; ?>">Previous</a>
                            </li>
                            <?php endif; ?>

                            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="?id=<?php echo $id; ?>&page=<?php echo $i . $query_string; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php endfor; ?>

                            <?php if($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?id=<?php echo $id; ?>&page=<?php echo ($page+1) . $query_string; ?>">Next</a>
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
include('./footer.php');
?>