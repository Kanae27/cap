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
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/banner1.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 80%;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">General Merchandise</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="view_shop.php?id=Shirts">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/banner1.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">General Merchandise</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="view_shop.php?id=Shorts">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/banner1.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">General Merchandise</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="view_shop.php?id=Caps">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

<!-- Categories Layout -->
<div class="container-fluid pt-5">
    <?php
    include('./connect.php');
    $categories = $conn->query("SELECT * FROM category");
    ?>
    
    <div class="categories-grid mb-5">
        <?php
        while($category = $categories->fetch_assoc()) {
            $categoryName = $category['category'];
            ?>
            <a href="view_shop.php?id=<?php echo urlencode($categoryName); ?>" class="category-box" style="color: #FFFFFF !important; text-decoration: none;">
                <h3 class="category-title" style="color: #FFFFFF !important;"><?php echo htmlspecialchars($categoryName); ?></h3>
            </a>
            <?php
        }
        ?>
    </div>
</div>

<style>
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 15px;
    padding: 0 15px;
}

.category-box {
    background: #347928;
    border-radius: 8px;
    padding: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    min-height: 60px;
    border: 2px solid #347928;
    transition: all 0.3s ease;
    color: #FFFFFF !important;
}

.category-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(52, 121, 40, 0.2);
    background: #2a6320;
    border-color: #2a6320;
    color: #FFFFFF !important;
}

.category-title {
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0;
    color: #FFFFFF !important;
}

a.category-box:link,
a.category-box:visited,
a.category-box:hover,
a.category-box:active {
    color: #FFFFFF !important;
    text-decoration: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .categories-grid {
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 10px;
        padding: 0 10px;
    }

    .category-box {
        padding: 8px;
        min-height: 50px;
    }

    .category-title {
        font-size: 0.9rem;
        color: #FFFFFF !important;
    }
}
</style>

    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3" style="background:#FFFBE6 !important">Featured Products</span></h2>
        <div class="row px-xl-5">
		<?php
		include('./connect.php');
		$result = $conn->query("SELECT * FROM product ORDER BY RAND()  LIMIT 10 ");
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
		   <div class="col-lg-2 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden" style="width: 100%; padding-top: 100%; /* 1:1 aspect ratio */">
                        <img class="img-fluid position-absolute top-0 left-0" src="<?php echo $row['image'] ?>" alt="Product Image" style="width: 100%; height: 100%; object-fit: cover; top: 0; left: 0;">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href="add_heart.php?id=<?php echo $row['id'] ?>"><i class="far fa-heart"></i></a>
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
						  if($c1>0) {
							if($rating == '5') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>';
							}
							if($rating >= '4' && $rating < '5') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '3' && $rating < '4') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '2' && $rating < '3') {
								
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '1' && $rating < '2') {
											echo '
											<small class="fa fa-star text-primary"></small>
											<small class="far far-star text-primary mr-1"></small>
											<small class="far fa-star text-primary mr-1"></small>
											<small class="far fa-star text-primary mr-1"></small>
											<small class="far fa-star text-primary mr-1"></small>
											<small class="far fa-star text-primary mr-1"></small>';
							}
							}
							else {
									echo '<small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small>';
							}
							
						  ?>
                        </div>
                    </div>
                </div>
            </div>
		  <?php
		}
		
		?>

</div>
</div>

    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3"  style="background:#FFFBE6 !important">Recent Products</span></h2>
        <div class="row px-xl-5">
          <?php
		include('./connect.php');
		$result = $conn->query("SELECT * FROM product ORDER BY ID DESC LIMIT 10");
		while($row = $result->fetch_assoc()) {
			
			$item = $row['id'];
			$r = mysqli_query($conn,"SELECT *, AVG(rating) as av FROM rating WHERE item = '$item'");
			$r2 = mysqli_query($conn,"SELECT * FROM rating WHERE item = '$item'");
			$s = mysqli_num_rows($r2);
			while($r1 = mysqli_fetch_array($r)) {
				$rating = $r1['av'];
			}
		  ?>
		   <div class="col-lg-2 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden" style="width: 100%; padding-top: 100%; /* 1:1 aspect ratio */">
                        <img class="img-fluid position-absolute top-0 left-0" src="<?php echo $row['image'] ?>" alt="" style="width: 100%; height: 100%; object-fit: cover; top: 0; left: 0;">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href="add_heart.php?id=<?php echo $row['id'] ?>"><i class="far fa-heart"></i></a>
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
							if($rating >= '4' && $rating < '5') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '3' && $rating < '4') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '2' && $rating <'3') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '1' && $rating <'2') {
											echo '
											<small class="fa fa-star text-primary"></small>
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
    <!-- Products End -->

<?php
include('./footer.php');
?>