<?php
include('./header.php');
$id = $_GET['id'];
include('./connect.php');
$result = $conn->query("SELECT * FROM product WHERE id = '$id'");
while($row = $result->fetch_assoc()) {
	$item = $row['item'];
	$description = $row['description'];
	$price = $row['price'];
	$image = $row['image'];
	$category = $row['category'];
	
}

$r = mysqli_query($conn,"SELECT *, AVG(rating) as av FROM rating WHERE item = '$id'");
$r2 = mysqli_query($conn,"SELECT * FROM rating WHERE item = '$id'");
$s = mysqli_num_rows($r2);
while($r1 = mysqli_fetch_array($r)) {
	$rating = $r1['av'];
}
?>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

.wrapper {
	background: var(--white);
	padding: 2rem;
	max-width: 576px;
	width: 100%;
	border-radius: .75rem;
	box-shadow: var(--shadow);
	text-align: center;
}
.wrapper h3 {
	font-size: 1.5rem;
	font-weight: 600;
	margin-bottom: 1rem;
}
.rating {
	display: flex;
	justify-content: center;
	align-items: center;
	grid-gap: .5rem;
	font-size: 2rem;
	color: var(--yellow);
}
.rating .star {
	cursor: pointer;
}
.rating .star.active {
	opacity: 0;
	animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
}

@keyframes animate {
	0% {
		opacity: 0;
		transform: scale(1);
	}
	50% {
		opacity: 1;
		transform: scale(1.2);
	}
	100% {
		opacity: 1;
		transform: scale(1);
	}
}


.rating .star:hover {
	transform: scale(1.1);
}
textarea {
	width: 100%;
	background: var(--light);
	padding: 1rem;
	border-radius: .5rem;
	border: none;
	outline: none;
	resize: none;
	margin-bottom: .5rem;
}
.btn-group {
	display: flex;
	grid-gap: .5rem;
	align-items: center;
}
.btn-group .btn {
	padding: .75rem 1rem;
	border-radius: .5rem;
	border: none;
	outline: none;
	cursor: pointer;
	font-size: .875rem;
	font-weight: 500;
}
.btn-group .btn.submit {
	background: var(--blue);
	color: var(--white);
}
.btn-group .btn.submit:hover {
	background: var(--blue-d-1);
}
.btn-group .btn.cancel {
	background: var(--white);
	color: var(--blue);
}
.btn-group .btn.cancel:hover {
	background: var(--light);
}

/* Quantity Input Group */
.quantity {
    display: flex;
    align-items: stretch;
    height: 40px;
    border-radius: 5px;
    overflow: hidden;
    border: 2px solid #fff;
}

/* Input Field */
.quantity input {
    width: 50px;
    text-align: center;
    border: none;
    background: #fff !important;
    color: #347928 !important;
    font-weight: 600;
    padding: 0;
    margin: 0;
    -moz-appearance: textfield; /* Remove number spinners in Firefox */
}

/* Remove number spinners in Chrome/Safari/Edge */
.quantity input::-webkit-outer-spin-button,
.quantity input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Plus/Minus Buttons */
.btn-minus,
.btn-plus {
    width: 40px;
    height: 40px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #347928 !important;
    border: none !important;
    color: #fff !important;
    cursor: pointer;
}

.btn-minus:hover,
.btn-plus:hover {
    background: #2a6320 !important;
}

/* Icons inside buttons */
.btn-minus i,
.btn-plus i {
    font-size: 14px;
    color: #fff;
}

/* Container alignment */
.d-flex.align-items-center.mb-4.pt-2 {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* Add to Cart Button */
.btn.btn-primary.px-3 {
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff !important;
    color: #347928 !important;
    border: 2px solid #fff !important;
    font-weight: 600;
}

.btn.btn-primary.px-3:hover {
    background: rgba(255,255,255,0.9) !important;
}

/* Product Image Container */
.product-img {
    width: 100%;
    height: 250px;
    position: relative;
    overflow: hidden;
    background: #fff !important;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none !important;
}

/* Product Image */
.product-img img {
    width: 80% !important;
    height: 80% !important;
    object-fit: contain;
    padding: 10px;
    display: block;
    margin: auto;
}

/* Product Details */
.text-center.py-4 {
    padding: 15px !important;
    background: #fff !important;
    color: #333 !important;
    border: none !important;
}

/* Product Title */
.h6.text-decoration-none.text-truncate {
    color: #333 !important;
    border: none !important;
}

/* Price */
.d-flex.align-items-center.justify-content-center.mt-2 h5 {
    color: #347928 !important;
    border: none !important;
}

/* Stars */
.fa-star {
    color: #347928 !important;
}

/* Product Action Buttons */
.product-action {
    background: rgba(255, 255, 255, 0.9) !important;
}

.btn-outline-dark {
    background: #347928 !important;
    color: #fff !important;
}

.btn-outline-dark:hover {
    background: #2a6320 !important;
}

/* Remove any remaining borders */
.bg-light {
    border: none !important;
    background: #fff !important;
}

.overflow-hidden {
    border: none !important;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .product-img {
        height: 200px;
    }
    
    .product-img img {
        width: 70% !important;
        height: 70% !important;
    }
}

/* Add these styles to your existing <style> section */
.carousel-inner .carousel-item {
    height: 400px; /* Adjust this value as needed */
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
}

.carousel-inner .carousel-item img {
    max-width: 100%;
    max-height: 100%;
    width: auto !important;
    height: auto !important;
    object-fit: contain;
}

/* Optional: Adjust carousel control buttons */
.carousel-control-prev,
.carousel-control-next {
    width: 10%;
}

.carousel-control-prev i,
.carousel-control-next i {
    color: #347928 !important;
}
</style>
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="<?php echo $image ?>" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="<?php echo $image ?>" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="<?php echo $image ?>" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="<?php echo $image ?>" alt="Image">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
			<form action="add_cart.php" method="GET" onsubmit="return sendNotification(event)">
                <div class="h-100 bg-light p-30">
                    <h3><?php echo $item ?></h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
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
							if($rating == '') {
									echo '<small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small>';
							}
										
										?>
                        </div>
                        <small class="pt-1">(<?php echo $s ?> Reviews)</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">₱ <?php echo number_format($price,2) ?></h3>
                    <p class="mb-4"><?php  echo $description?></p>
                 
                    <div class="d-flex mb-4" style="display:none !important">
                        <strong class="text-dark mr-3"  style="display:none">Colors:</strong>
                        
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-1" name="color">
                                <label class="custom-control-label" for="color-1">Black</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-2" name="color">
                                <label class="custom-control-label" for="color-2">White</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-3" name="color">
                                <label class="custom-control-label" for="color-3">Red</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-4" name="color">
                                <label class="custom-control-label" for="color-4">Blue</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-5" name="color">
                                <label class="custom-control-label" for="color-5">Green</label>
                            </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="quantity mr-3">
                            <button type="button" class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                            <input type="number" class="form-control bg-secondary border-0 text-center" value="1" name="quantity" min="1">
                            <button type="button" class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
						
					<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                        <button class="btn btn-primary px-3" type="submit"><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                </div>
            </div>
			</form>
        </div>

        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (<?php echo $s ?>)</a>
                    </div>
					<?php
					if(isset($_POST['submit'])) {
						$rating = $_POST['rating'];
						$message = $_POST['message'];
						$name = $_POST['name'];
						$email = $_POST['email'];
						$item = $_GET['id'];
						$date = date('F d, Y');
						
						// Insert the review
						mysqli_query($conn,"INSERT INTO rating (rating, message, name, email, item, date) 
										   VALUES ('$rating', '$message', '$name', '$email', '$item', '$date')");
						
						// Create notification for the review
						mysqli_query($conn, "INSERT INTO notifications (username, message, order_details, created_at) 
											 VALUES ('$name', 'New review posted!', 'Rating: $rating stars for $item', NOW())");
						
						echo '<script>alert("Review has been posted");window.location="details.php?id='.$item.'"</script>';
					}
					?>
                                    <form method="POST" action="#">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small>Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">
							
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        		
			<div class="rating">
				<input type="number" name="rating" hidden>
				<i class='bx bx-star star' style="--i: 0;"></i>
				<i class='bx bx-star star' style="--i: 1;"></i>
				<i class='bx bx-star star' style="--i: 2;"></i>
				<i class='bx bx-star star' style="--i: 3;"></i>
				<i class='bx bx-star star' style="--i: 4;"></i>
			</div>
                                    </div>
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control" name="message" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Your Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email *</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3" name="submit">
                                        </div>
                                    </form>
									
                        <br>
                            <div class="row">
							<?php
							$id = $_GET['id'];
							$r = mysqli_query($conn,"SELECT * FROM rating WHERE item = '$id'");
							while($row = mysqli_fetch_array($r)) {
								$rating = $row['rating'];
							?>
							<div class="col-md-12">
								<div class="media mb-4">
									<div class="media-body">
										<h6><?php echo $row['name'] ?><small> - <i><?php echo $row['date'] ?></i></small></h6>
										<div class="text-primary mb-2">
										<?php
											if($rating == '5') {
													echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
											}
											if($rating == '4') {
													echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>';
											}
											if($rating == '3') {
													echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
											}
											if($rating == '2') {
													echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
											}
											if($rating == '1') {
													echo '<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
											}
											if($rating == '') {
													echo '<i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
											}
										
										?>
											
										</div>
										<p><?php echo $row['message'] ?></p>
									</div>
								</div>
							</div>
							<?php
							}
							?>
                            </div>
                        
									<script>
									const allStar = document.querySelectorAll('.rating .star')
const ratingValue = document.querySelector('.rating input')

allStar.forEach((item, idx)=> {
	item.addEventListener('click', function () {
		let click = 0
		ratingValue.value = idx + 1

		allStar.forEach(i=> {
			i.classList.replace('bxs-star', 'bx-star')
			i.classList.remove('active')
		})
		for(let i=0; i<allStar.length; i++) {
			if(i <= idx) {
				allStar[i].classList.replace('bx-star', 'bxs-star')
				allStar[i].classList.add('active')
			} else {
				allStar[i].style.setProperty('--i', click)
				click++
			}
		}
	})
})
									</script>
                    <div class="tab-content">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

<?php
include('./footer.php');
?>

<!-- Add this JavaScript before the closing body tag -->
<script>
function sendNotification(event) {
    event.preventDefault();
    
    const quantity = document.querySelector('input[name="quantity"]').value;
    const productId = document.querySelector('input[name="id"]').value;
    
    // First send notification
    $.ajax({
        url: 'create_notification.php',
        method: 'POST',
        data: {
            message: 'New item added to cart!',
            order_details: '<?php echo $item ?> - Quantity: ' + quantity,
            username: '<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : "Guest" ?>'
        },
        success: function(response) {
            // Then submit the form to add_cart.php
            window.location.href = 'add_cart.php?id=' + productId + '&quantity=' + quantity;
        }
    });
    
    return false;
}

// Quantity buttons functionality
$(document).ready(function() {
    // Remove any existing click handlers
    $('.btn-plus, .btn-minus').off('click');
    
    // Plus button
    $('.btn-plus').on('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var $input = $(this).parent().find('input[name="quantity"]');
        var currentVal = parseInt($input.val());
        $input.val(currentVal + 1);
        return false;
    });
    
    // Minus button
    $('.btn-minus').on('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var $input = $(this).parent().find('input[name="quantity"]');
        var currentVal = parseInt($input.val());
        if (currentVal > 1) {
            $input.val(currentVal - 1);
        }
        return false;
    });

    // Prevent manual input of invalid values
    $('input[name="quantity"]').on('input', function() {
        var value = parseInt($(this).val());
        if (value < 1 || isNaN(value)) {
            $(this).val(1);
        }
    });
});
</script>