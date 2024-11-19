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
</style>

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">


            <!-- Shop Product Start -->
            <div class="col-lg-12 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            
                        </div>
                    </div>
					 <?php
		include('./connect.php');
		$id = $_GET['id'];
		$result = $conn->query("SELECT * FROM product WHERE category = '$id'");
		$num = mysqli_num_rows($result);
		if($num == 0) {
			echo '<h2>No Results Found</h2>';
			
		}
		while($row = $result->fetch_assoc()) {
			//get rating
			$item = $row['id'];
			$r = mysqli_query($conn,"SELECT *, AVG(rating) as av FROM rating WHERE item = '$item'");
			$r2 = mysqli_query($conn,"SELECT * FROM rating WHERE item = '$item'");
			$s = mysqli_num_rows($r2);
			while($r1 = mysqli_fetch_array($r)) {
				$rating = $r1['av'];
			}
			//end get
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
            
					
					
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

<?php
include('./footer.php');
?>