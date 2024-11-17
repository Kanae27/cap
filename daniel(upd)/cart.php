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
                    <span class="breadcrumb-item active">Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="15%">Product Image</th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
					<?php
					$total = 0;
					$r = mysqli_query($conn,"SELECT * FROM cart WHERE username = '$username' AND status = 'Cart'");
					while($row = mysqli_fetch_array($r)) {
						$id = $row['product'];
						$quantity = $row['quantity'];
						$r1 = mysqli_query($conn,"SELECT * FROM product WHERE id = '$id'");
						$row1 = mysqli_fetch_array($r1);
						
						$price = $row1['price'];
						$t = $quantity * $price;
						$total += $t;
						?>
                        <tr>
                            <td class="align-middle"><img src="<?php echo $row1['image'] ?>" alt="" style="width: 50px;"></td>
                            <td class="align-middle"><?php echo $row1['item'] ?></td>
                            <td class="align-middle">&#8369; <?php echo number_format($price,2) ?></td>
                            <td class="align-middle"><?php echo $quantity ?></td>
                            <td class="align-middle">&#8369; <?php echo number_format($t,2) ?></td>
                            <td class="align-middle">
							<a href="delete_cart.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?')"><i class="fa fa-times"></i></a>
							</td>
                        </tr>
						<?php
					}
						?>
                      
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
			<form action="checkout.php" method="POST" onsubmit="return a();"  enctype="multipart/form-data">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>&#8369; <?php echo number_format($total,2) ?></h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>&#8369; <?php echo number_format($total,2) ?></h5>
                        </div>
						<br>
						<h5>Transaction Type</h4>
						<h6>Type of Transaction</h5>
						<select id="transaction" class="form-control" name="transaction" onchange="cc1()">
							<option></option>
							<option>Pickup</option>
							<option>Delivery</option>
						</select>
						<h6>Type of Payment</h5>
						<select id="payment" class="form-control" onchange="b()" name="payment">
							<option></option>
						</select>
						<div id="res" style="display:none">
						
						</div>
						<input type="submit" class="btn btn-block btn-primary font-weight-bold my-3 py-3" value="Proceed to Checkout">
                        <script>
						function cc1() {
							var value = document.getElementById('transaction').value;
							if(value == 'Pickup') {
							document.getElementById('payment').innerHTML = '<option></option>'+
							'<option>On Store Payment</option>';
							} else {
							document.getElementById('payment').innerHTML = '<option></option>'+
							'<option>Online Payment</option>'+
							'<option>Cash On Delivery</option>';
							}
						} 
						function b() {
							var payment = document.getElementById('payment').value;
							if(payment == 'Online Payment') {
								document.getElementById('pay').style.display = 'block';
								document.getElementById('res').style.display = 'block';
								document.getElementById('pay').innerHTML = `
									<div class="card">
										<div class="card-body">
											<h5 class="card-title">PayMongo Payment</h5>
											<div class="form-group">
												<label>Card Number</label>
												<input type="text" class="form-control" id="card_number" placeholder="4343434343434345">
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Expiry Date (MM/YY)</label>
														<input type="text" class="form-control" id="card_expiry" placeholder="12/25">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>CVC</label>
														<input type="text" class="form-control" id="card_cvc" placeholder="123">
													</div>
												</div>
											</div>
										</div>
									</div>`;
							} else {
								document.getElementById('res').style.display = 'none';
								document.getElementById('pay').style.display = 'none'
							}
						}
							function a() {
								var payment = document.getElementById('payment').value;
								var transaction = document.getElementById('transaction').value;
								
								var total = <?php echo $total; ?>;
								
								if(total < 200) {
									alert("Minimum order amount should be ₱200");
									return false;
								}
								
								if(payment == '' || transaction == '') {
									alert("Please select type of Transaction");
									return false;
								} else if(transaction == '') {
									alert("Please select type of payment");
									return false;
								} else if(payment == 'Online Payment') {
									var card_number = document.getElementById('card_number').value;
									var card_expiry = document.getElementById('card_expiry').value;
									var card_cvc = document.getElementById('card_cvc').value;
									
									if(!card_number || !card_expiry || !card_cvc) {
										alert("Please fill in all card details");
										return false;
									}
									
									$.ajax({
										url: 'process_payment.php',
										method: 'POST',
										data: {
											amount: total,
											card_number: card_number,
											card_expiry: card_expiry,
											card_cvc: card_cvc
										},
										success: function(response) {
											var result = JSON.parse(response);
											if(result.success) {
												$.ajax({
													url: 'create_notification.php',
													method: 'POST',
													data: {
														message: 'New order received!',
														order_details: 'Transaction: ' + transaction + ', Payment: ' + payment
													},
													success: function(response) {
														window.location='checkout.php?payment='+payment+'&transaction='+transaction;
													}
												});
											} else {
												alert("Payment failed: " + result.message);
											}
										},
										error: function() {
											alert("Payment processing failed. Please try again.");
										}
									});
									return false;
								} else {
									$.ajax({
										url: 'create_notification.php',
										method: 'POST',
										data: {
											message: 'New order received!',
											order_details: 'Transaction: ' + transaction + ', Payment: ' + payment
										},
										success: function(response) {
											window.location='checkout.php?payment='+payment+'&transaction='+transaction;
										}
									});
									return false;
								}
							}
						</script>
						</form>
						<div id="pay" style="display:none">
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
<?php
include('./footer.php');
?>