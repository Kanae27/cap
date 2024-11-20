<?php
include('./header.php');
?>


    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
	
        <div class="row px-xl-5">
		
            <div class="col-lg-12">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>

                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/banner1.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 80%;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">General Merchandise</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">"Fresh foods are nature's gift, packed with nutrients to nourish your body and soul. Every bite is a step toward better health, energizing you from the inside out. Choosing fresh ingredients not only supports your well-being but also connects you to the earth's natural rhythms. Embrace freshness, and let your meals become a celebration of life."</p>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <!-- Carousel End -->


    <!-- Products Start -->
    <?php
    // Pagination setup for Featured Products   
    $items_per_page = 14;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $items_per_page;

    // Get total number of products
    $total_query = $conn->query("SELECT COUNT(*) as total FROM product");
    $total_products = $total_query->fetch_assoc()['total'];
    $total_pages = ceil($total_products / $items_per_page);

    // Pagination setup for Recent Products
    $recent_page = isset($_GET['recent_page']) ? max(1, (int)$_GET['recent_page']) : 1;
    $recent_offset = ($recent_page - 1) * $items_per_page;

    // Use same total for recent products since it's the same table
    $total_recent_pages = $total_pages;
    ?>

    <div class="container-fluid px-xl-5">
        <!-- Featured Products Section -->
        <div class="featured-products-container">
            <div class="product-section-box p-4 mb-5">
                <select class="form-control category-select" onchange="window.location.href=this.value">
                    <option value="">Categories</option>
                    <?php
                    $categories = $conn->query("SELECT * FROM category");
                    while($category = $categories->fetch_assoc()) {
                        $categoryName = $category['category'];
                        echo '<option value="view_shop.php?id='.urlencode($categoryName).'">'.htmlspecialchars($categoryName).'</option>';
                    }
                    ?>
                </select>
                <h2 class="section-title position-relative text-uppercase mt-3">
                    <span class="bg-white pr-3">Featured Products</span>
                </h2>
            </div>
            <div class="row px-xl-5" id="featured-products-container">
                <?php 
                // Modify get_products.php to include rating display
                include('get_products.php'); 
                ?>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4 mb-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination" id="featured-pagination">
                        <?php if($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="#" data-page="<?php echo $page-1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="#" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="#" data-page="<?php echo $page+1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="container-fluid px-xl-5">
        <hr class="divider">
    </div>

    <!-- Recent Products Section -->
    <div class="container-fluid px-xl-5">
        <div class="featured-products-container">
            <div class="product-section-box p-4 mb-5">
                <h2 class="section-title position-relative text-uppercase">
                    <span class="bg-white pr-3">Recent Products</span>
                </h2>
            </div>
            <div class="row px-xl-5" id="recent-products-container">
                <?php include('get_recent_products.php'); ?>
            </div>
            
            <!-- Recent Products Pagination -->
            <div class="d-flex justify-content-center mt-4 mb-4">
                <nav aria-label="Recent products navigation">
                    <ul class="pagination" id="recent-pagination">
                        <?php if($recent_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="#" data-page="<?php echo $recent_page-1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for($i = 1; $i <= $total_recent_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $recent_page ? 'active' : ''; ?>">
                                <a class="page-link" href="#" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if($recent_page < $total_recent_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="#" data-page="<?php echo $recent_page+1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    </div>

<style>
/* Enhanced Styling */
.container-fluid {
    padding: 0;
    margin-bottom: 20px;
}

.product-section-box {
    background: #00FF00;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    border: 1px solid rgba(40, 167, 69, 0.2);
    position: relative;
    overflow: hidden;
}

.product-section-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #28a745;
}

.section-title {
    position: relative;
    display: inline-block;
    margin: 0;
    padding-bottom: 15px;
    border-bottom: 2px solid #28a745;
}

.section-title span {
    position: relative;
    color: #28a745;
    font-weight: 600;
}

.carousel-item {
    height: 500px !important;
    position: relative;
}

.carousel-item::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1;
}

.carousel-caption {
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
    bottom: 0;
    left: 0;
    right: 0;
    padding: 50px 20px;
    z-index: 2;
}

.carousel-indicators li {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin: 0 5px;
}

.product-item {
    border: 2px solid #28a745;
    border-radius: 12px;
    background-color: #ffffff;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    height: 400px;
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
    border-color: #1e7e34;
}

.product-img {
    position: relative;
    border-radius: 12px 12px 0 0;
    height: 200px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}

.product-img img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 10px;
}

.product-action {
    position: absolute;
    bottom: -50px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    gap: 10px;
    padding: 15px;
    background: rgba(255,255,255,0.95);
    transition: all 0.3s ease;
    opacity: 0;
    z-index: 2;
}

.product-item:hover .product-action {
    bottom: 0;
    opacity: 1;
}

.btn-outline-dark {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-color: #28a745;
    color: #28a745;
    transition: all 0.3s ease;
}

.btn-outline-dark:hover {
    background: #28a745;
    color: white;
    transform: rotate(360deg);
}

.text-center.py-4 {
    padding: 20px !important;
    background: white;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 150px;
}

.product-rating {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 2px;
    margin: 10px 0;
    position: relative;
    z-index: 1;
}

.h6.text-truncate {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    white-space: normal;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    min-height: 45px;
}

.product-item h5 {
    color: #28a745;
    font-weight: 600;
    font-size: 1.1rem;
}

.fa-star {
    color: #FFD700 !important;
    margin: 0 2px;
    -webkit-text-stroke: 1px #b38f00;
    text-stroke: 1px #b38f00;
    font-size: 1rem;
}

.far.fa-star {
    color: #d4d4d4 !important;
    margin: 0 2px;
    -webkit-text-stroke: 1px #808080;
    text-stroke: 1px #808080;
    font-size: 1rem;
}

.text-primary {
    color: #FFD700 !important;
}

.pagination {
    margin: 0;
}

.page-link {
    color: #28a745;
    border-color: #28a745;
    margin: 0 2px;
    border-radius: 4px;
}

.page-link:hover {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

.page-item.active .page-link {
    background-color: #28a745;
    border-color: #28a745;
}

.col-lg-3 {
    flex: 0 0 12.5%;
    max-width: 12.5%;
}

@media (max-width: 1200px) {
    .col-lg-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }
}

@media (max-width: 768px) {
    .col-lg-3 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (max-width: 576px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 15px;
    }
    
    .category-select {
        width: 100%;
    }
}

.divider {
    border: 0;
    height: 1px;
    background: linear-gradient(to right, #28a745, #28a745, #28a745);
    margin: 10px 0;
    opacity: 0.5;
}

.featured-products-container {
    border: 1px solid rgba(40, 167, 69, 0.2);
    border-radius: 15px;
    padding: 20px;
    background-color: #F2F0EF;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    margin-bottom: 5px;
}

.product-section-box {
    background: #f8f9fa;
    margin-bottom: 20px;
    border: none;
    box-shadow: none;
}

body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

main {
    flex: 1 0 auto;
}

.category-select {
    width: 25% !important;
    min-width: 25% !important;
    padding: 15x;
    font-size: 1.1rem;
    margin-bottom: 15px;
}

</style>

<?php
include('./footer.php');
?>

<!-- Add this JavaScript at the bottom of your file -->
<script>
// Add smooth image loading
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img[loading="lazy"]');
    images.forEach(img => {
        img.addEventListener('load', function() {
            img.classList.add('loaded');
        });
    });
});
</script>

<!-- Add this JavaScript code before the closing </body> tag -->
<script>
// Function to load products via AJAX
function loadProducts(page, section) {
    fetch(`get_products.php?${section}_page=${page}`)
        .then(response => response.text())
        .then(data => {
            // Update the products container
            const container = document.querySelector(`#${section}-products-container`);
            container.innerHTML = data;
            
            // Update URL without page refresh
            const url = new URL(window.location);
            url.searchParams.set(`${section}_page`, page);
            window.history.pushState({}, '', url);
            
            // Update active state of pagination buttons
            updatePaginationActive(section, page);
        });
}

// Update active state of pagination buttons
function updatePaginationActive(section, currentPage) {
    const pagination = document.querySelector(`#${section}-pagination`);
    const buttons = pagination.querySelectorAll('.page-item');
    
    buttons.forEach(button => {
        button.classList.remove('active');
        const pageNum = button.querySelector('.page-link').getAttribute('data-page');
        if (pageNum === currentPage.toString()) {
            button.classList.add('active');
        }
    });
}

// Add click event listeners to pagination buttons  
document.addEventListener('DOMContentLoaded', function() {
    const paginationSections = ['featured', 'recent'];
    
    paginationSections.forEach(section => {
        const pagination = document.querySelector(`#${section}-pagination`);
        if (pagination) {
            pagination.addEventListener('click', function(e) {
                e.preventDefault();
                const target = e.target.closest('.page-link');
                if (target) {
                    const page = target.getAttribute('data-page');
                    loadProducts(page, section);
                }
            });
        }
    });
});
</script>