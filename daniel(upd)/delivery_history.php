<?php

include('header.php');
include('../connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>

<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Pending Deliveries</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="delivery_history" class="table table-striped table-bordered">
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
                            $query = "
                                SELECT 
                                    c.invoice,
                                    c.customer as customer_name,
                                    c.quantity,
                                    p.item,
                                    p.price,
                                    p.image,
                                    o.order_status,
                                    (c.quantity * p.price) as total_amount
                                FROM cart c
                                LEFT JOIN product p ON p.id = c.product
                                LEFT JOIN order_status o ON c.id = o.cart_id
                                WHERE c.status = 'Approved'
                                ORDER BY c.invoice DESC
                            ";

                            $result = $conn->query($query);
                            
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['invoice']}</td>";
                                echo "<td>{$row['customer_name']}</td>";
                                echo "<td>
                                        <img src='{$row['image']}' alt='' style='width: 50px;'> 
                                        {$row['item']}
                                      </td>";
                                echo "<td>{$row['quantity']}</td>";
                                echo "<td>₱" . number_format($row['total_amount'], 2) . "</td>";
                                echo "<td class='text-warning'>
                                        <i class='fas fa-gear'></i> Processing
                                      </td>";
                                echo "<td>
                                        <button class='btn btn-primary btn-sm' 
                                                onclick='markAsDelivered(\"{$row['invoice']}\")'>
                                            <i class='fas fa-truck'></i> Mark as Delivered
                                        </button>
                                      </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- footer content -->
<footer>
    <div class="pull-right">
        Daniel and Marilyn's General Merchandise - 2024
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->

</div>
</div>

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="../vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="../vendors/nprogress/nprogress.js"></script>
<!-- DataTables -->
<script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<script>
$(document).ready(function() {
    $('#deliveryHistory').DataTable({
        "pageLength": 10,
        "responsive": true
    });
});

function markAsDelivered(invoice) {
    if (confirm('Mark this order as delivered?')) {
        $.ajax({
            url: 'mark_delivered.php',
            type: 'POST',
            data: {
                invoice: invoice
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error updating delivery status');
            }
        });
    }
}
</script>

<style>
.right_col {
    padding-bottom: 0 !important;
    min-height: auto !important;
}
.x_panel {
    margin-bottom: 0 !important;
}
.btn-primary {
    background-color: #2A3F54;
    border-color: #2A3F54;
}
.btn-primary:hover {
    background-color: #1c2a3a;
    border-color: #1c2a3a;
}
.table td {
    vertical-align: middle;
}
</style>

</body>
</html> 