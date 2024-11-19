<?php
include('./header.php');
if(!isset($_SESSION['username'])) {
    echo '<script>alert("Please login to continue");window.history.back();</script>';
    exit();
}

$invoice_no = isset($_GET['invoice']) ? $_GET['invoice'] : null;
if(!$invoice_no) {
    echo '<script>window.location="orders.php";</script>';
    exit();
}
?>

<!-- Invoice Start -->
<div class="container-fluid pt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-6">
                                <h2>INVOICE</h2>
                                <p class="mb-1">Invoice Number: #<?php echo $invoice_no; ?></p>
                                <p class="mb-1">Date: <?php echo date('Y-m-d'); ?></p>
                            </div>
                            <div class="col-6 text-right">
                                <?php
                                // Fetch customer details from user table
                                $customer_query = mysqli_query($conn, 
                                    "SELECT address, contact, email 
                                     FROM user 
                                     WHERE username = '$username'
                                     LIMIT 1");
                                
                                if ($customer_query && $customer_info = mysqli_fetch_array($customer_query)) {
                                    $address = isset($customer_info['address']) ? $customer_info['address'] : 'N/A';
                                    $contact = isset($customer_info['contact']) ? $customer_info['contact'] : 'N/A';
                                    $email = isset($customer_info['email']) ? $customer_info['email'] : 'N/A';
                                ?>
                                    <h3>Customer Information</h3>
                                    <p class="mb-1">Address: <?php echo $address; ?></p>
                                    <p class="mb-1">Contact: <?php echo $contact; ?></p>
                                    <p>Email: <?php echo $email; ?></p>
                                <?php 
                                } else {
                                    echo "<p>Customer information not found.</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        $username = $_SESSION['username'];
                                        $query = mysqli_query($conn, "SELECT c.*, p.item, p.price 
                                                                    FROM cart c 
                                                                    JOIN product p ON c.product = p.id 
                                                                    WHERE c.username = '$username' 
                                                                    AND c.invoice = '$invoice_no'");
                                        
                                        while($row = mysqli_fetch_array($query)) {
                                            $subtotal = $row['quantity'] * $row['price'];
                                            $total += $subtotal;
                                        ?>
                                        <tr>
                                            <td><?php echo $row['item']; ?></td>
                                            <td><?php echo $row['quantity']; ?></td>
                                            <td>₱<?php echo number_format($row['price'], 2); ?></td>
                                            <td>₱<?php echo number_format($subtotal, 2); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                                            <td><strong>₱<?php echo number_format($total, 2); ?></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                               
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
                                <a href="cart.php" class="btn btn-secondary">Back to Orders</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Invoice End -->

<?php include('./footer.php'); ?> 