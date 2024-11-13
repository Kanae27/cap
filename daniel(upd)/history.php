<?php
include('./header.php');
if(isset($_SESSION['username']))  {
	
} else {
	echo '<script>alert("Please login to continue");window.history.back();</script>';
}
?>

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">History</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                  <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="15%">Product Image</th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
					<?php
					$total = 0;
					$r = mysqli_query($conn,"SELECT * FROM cart WHERE username = '$username' AND status <> 'Cart' AND status <> 'heart'");
					while($row = mysqli_fetch_array($r)) {
						$id =$row['product'];
						$quantity = $row['quantity'];
						$r1 = mysqli_query($conn,"SELECT * FROM product WHERE id = '$id'");
						while($row1 = mysqli_fetch_array($r1)) {
							$item = $row1['item'];
							$image = $row1['image'];
							$price = number_format($row1['price'],2);
						}
						$t = $quantity * $price;
						?>
                        <tr>
                            <td class="align-middle"><img src="<?php echo $image ?>" alt="" style="width: 50px;"></td>
                            <td class="align-middle"><?php echo $item ?></td>
                            <td class="align-middle">&#8369; <?php echo $price ?></td>
                            <td class="align-middle">
							<?php echo $quantity ?>
                                
                            </td>
                            <td class="align-middle">&#8369; <?php echo number_format($t,2) ?></td>
                            <td class="align-middle">
							<a href="view_details.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-primary" ><i class="fa-sharp fa-regular fa-camera-viewfinder"></i></a>
							</td>
                        </tr>
						<?php
						$total += $t;
					}
						?>
                      
                    </tbody>
                </table>
            </div>
           
            </div>
        </div>
    </div>
    <!-- Cart End -->
<?php
include('./footer.php');
?>