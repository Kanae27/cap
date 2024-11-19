<?php

include('header.php');
include('../connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Delivery History</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="deliveryHistory" class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer Name</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            <?php
                            try {
                                $query = "SELECT c.id, c.invoice, c.username, c.quantity, c.status,
                                               p.item, p.image, p.price,
                                               (c.quantity * p.price) as total_amount
                                        FROM cart c 
                                        JOIN product p ON p.id = c.product 
                                        WHERE c.status IN ('Approved', 'Delivered', 'Pending')
                                        AND c.username != 'pos'
                                        ORDER BY c.invoice DESC";

                                $result = mysqli_query($conn, $query);
                                
                                if (!$result) {
                                    throw new Exception(mysqli_error($conn));
                                }

                                while($row = mysqli_fetch_assoc($result)) {
                                    $status = isset($row['status']) ? $row['status'] : 'Unknown';
                                    $statusClass = '';
                                    $statusIcon = '';
                                    
                                    switch($status) {
                                        case 'Delivered':
                                            $statusClass = 'text-success';
                                            $statusIcon = 'fa-check-circle';
                                            break;
                                        case 'Approved':
                                            $statusClass = 'text-warning';
                                            $statusIcon = 'fa-gear';
                                            $status = 'Processing';
                                            break;
                                        case 'Pending':
                                            $statusClass = 'text-secondary';
                                            $statusIcon = 'fa-clock';
                                            break;
                                        default:
                                            $statusClass = 'text-secondary';
                                            $statusIcon = 'fa-question';
                                            break;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['invoice']); ?></td>
                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                        <td>
                                            <img src="../<?php echo htmlspecialchars($row['image']); ?>" alt="" style="width: 50px;">
                                            <?php echo htmlspecialchars($row['item']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                        <td>₱<?php echo number_format($row['total_amount'], 2); ?></td>
                                        <td class="<?php echo $statusClass; ?>">
                                            <i class="fas <?php echo $statusIcon; ?>"></i>
                                            <?php echo $status; ?>
                                        </td>
                                        <td>
                                            <?php if($status == 'Processing'): ?>
                                                <button class="btn btn-primary btn-sm" 
                                                        onclick="markAsDelivered('<?php echo htmlspecialchars($row['invoice']); ?>')">
                                                    <i class="fas fa-truck"></i> Mark as Delivered
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-sm <?php echo ($status == 'Delivered') ? 'btn-success' : 'btn-secondary'; ?>" disabled>
                                                    <i class="fas <?php echo ($status == 'Delivered') ? 'fa-check' : 'fa-clock'; ?>"></i>
                                                    <?php echo $status; ?>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } catch (Exception $e) {
                                echo "<tr><td colspan='7' class='text-center text-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#deliveryHistory').DataTable({
        "pageLength": 10,
        "order": [[0, "desc"]],
        "responsive": true
    });
});

function markAsDelivered(invoice) {
    if (confirm('Are you sure you want to mark this order as delivered?')) {
        $.ajax({
            url: 'mark_delivered.php',
            type: 'POST',
            data: { invoice: invoice },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (response.message || 'Failed to update status'));
                }
            },
            error: function() {
                alert('Failed to update status. Please try again.');
            }
        });
    }
}
</script>

<?php include('../footer.php'); ?> 