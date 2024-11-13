<?php
include('./header.php');
?>

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
		$result = $conn->query("SELECT * FROM product ORDER BY ID DESC LIMIT 10");
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
                            <!-- <a class="btn btn-outline-dark btn-square" href="add_cart.php?id=<?php echo $row['id'] ?>"><i class="fa fa-shopping-cart"></i></a> -->
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
							if($rating >= '4' && $rating <= '5') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '3' && $rating <= '4') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '2' && $rating <= '3') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '1' && $rating <= '2') {
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