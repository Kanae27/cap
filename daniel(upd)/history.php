<?php
include('./header.php');
if(isset($_SESSION['username']))  {
	$username = $_SESSION['username'];
} else {
	echo '<script>alert("Please login to continue");window.history.back();</script>';
	exit();
}

// Add this to handle status updates
if(isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $update_query = "UPDATE cart SET status = '$new_status' WHERE id = '$order_id'";
    mysqli_query($conn, $update_query);
    
    // Redirect to refresh the page
    echo "<script>window.location.href='history.php';</script>";
    exit();
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
                    <thead class="thead-dark">
                        <tr>
                            <th width="15%">Product Image</th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tracking</th>
                            <th>Action</th>
                            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                            <th>Update Status</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                    <?php
                    $query = "SELECT c.*, p.item, p.image, p.price 
                             FROM cart c 
                             INNER JOIN product p ON c.product = p.id 
                             WHERE c.username = '$username' 
                             AND c.status NOT IN ('Cart', 'heart')";
                    
                    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                        // For admin, show all orders
                        $query = "SELECT c.*, p.item, p.image, p.price 
                                 FROM cart c 
                                 INNER JOIN product p ON c.product = p.id 
                                 WHERE c.status NOT IN ('Cart', 'heart')";
                    }
                    
                    $result = mysqli_query($conn, $query);
                    
                    if ($result && mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $quantity = $row['quantity'];
                            $price = $row['price'];
                            $subtotal = $quantity * $price;
                    ?>
                        <tr>
                            <td class="align-middle">
                                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="" style="width: 50px;">
                            </td>
                            <td class="align-middle"><?php echo htmlspecialchars($row['item']); ?></td>
                            <td class="align-middle">&#8369; <?php echo number_format($price, 2); ?></td>
                            <td class="align-middle"><?php echo $quantity; ?></td>
                            <td class="align-middle">&#8369; <?php echo number_format($subtotal, 2); ?></td>
                            <td class="align-middle">
                                <?php 
                                $status = $row['status'];
                                $badge_class = 'badge badge-';
                                switch($status) {
                                    case 'Processing':
                                        $badge_class .= 'warning';
                                        break;
                                    case 'In Transit':
                                        $badge_class .= 'info';
                                        break;
                                    case 'Out for Delivery':
                                        $badge_class .= 'primary';
                                        break;
                                    case 'Delivered':
                                        $badge_class .= 'success';
                                        break;
                                    default:
                                        $badge_class .= 'secondary';
                                }
                                echo "<span class='$badge_class'>$status</span>";
                                ?>
                            </td>
                            <td class="align-middle">
                                <div class="progress" style="height: 5px;">
                                    <?php
                                    $progress = 0;
                                    switch($status) {
                                        case 'Processing': $progress = 25; break;
                                        case 'In Transit': $progress = 50; break;
                                        case 'Out for Delivery': $progress = 75; break;
                                        case 'Delivered': $progress = 100; break;
                                    }
                                    ?>
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: <?php echo $progress; ?>%" 
                                         aria-valuenow="<?php echo $progress; ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <a href="history.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i> Details
                                </a>
                            </td>
                            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                            <td class="align-middle">
                                <form method="POST" class="status-update-form">
                                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                    <select name="new_status" class="form-control form-control-sm status-select" 
                                            onchange="this.form.submit()">
                                        <option value="Processing" <?php echo ($row['status'] == 'Processing') ? 'selected' : ''; ?>>
                                            Processing
                                        </option>
                                        <option value="In Transit" <?php echo ($row['status'] == 'In Transit') ? 'selected' : ''; ?>>
                                            In Transit
                                        </option>
                                        <option value="Out for Delivery" <?php echo ($row['status'] == 'Out for Delivery') ? 'selected' : ''; ?>>
                                            Out for Delivery
                                        </option>
                                        <option value="Delivered" <?php echo ($row['status'] == 'Delivered') ? 'selected' : ''; ?>>
                                            Delivered
                                        </option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='9'>No orders found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Cart End -->

<!-- Add this CSS to your stylesheet or in a style tag -->
<style>
.status-select {
    width: auto;
    display: inline-block;
}

.status-update-form {
    margin: 0;
}

.badge {
    padding: 8px 12px;
    font-size: 0.9em;
}

.progress {
    margin-top: 5px;
    margin-bottom: 5px;
}
</style>

<!-- Add this JavaScript before the closing body tag -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit the form when status is changed
    const statusSelects = document.querySelectorAll('.status-select');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) {
                // Show confirmation dialog
                if (confirm('Are you sure you want to update this order status?')) {
                    form.submit();
                } else {
                    // Reset to previous value if cancelled
                    this.value = this.getAttribute('data-previous');
                }
            }
        });
        
        // Store the initial value
        select.setAttribute('data-previous', select.value);
    });
});
</script>
<?php
include('./footer.php');
?>