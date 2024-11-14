<?php
include('header.php');
if(!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!-- Add this CSS at the top of your file -->
<style>
.x_panel {
    min-height: 700px; /* Adjust this value based on your needs */
}

.table-container {
    min-height: 450px; /* Adjust this value to maintain table area */
}

.dataTables_wrapper {
    min-height: 400px; /* Adjust for DataTable wrapper */
}

/* Style for empty table message */
.dataTables_empty {
    padding: 50px !important;
    font-size: 16px;
    color: #666;
}

/* Keep footer at bottom of panel */
.x_panel {
    display: flex;
    flex-direction: column;
}

.x_content {
    flex: 1;
}
</style>

<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Delivery Tracking</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-container">
                        <table class="table table-striped jambo_table bulk_action" id="deliveryTable">
                            <thead>
                                <tr class="headings">
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total Amount</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $delivery_query = "
                                    SELECT 
                                        c.invoice,
                                        c.username,
                                        c.status,
                                        GROUP_CONCAT(p.item SEPARATOR ', ') as items,
                                        SUM(p.price * c.quantity) as total_amount,
                                        MIN(c.order_date) as order_date
                                    FROM cart c
                                    JOIN product p ON c.product = p.id
                                    WHERE c.status = 'Approved' 
                                    AND c.username != 'pos'
                                    GROUP BY c.invoice, c.username, c.status
                                    ORDER BY c.order_date DESC
                                ";
                                
                                $result = mysqli_query($conn, $delivery_query);
                                
                                if(mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['invoice']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td>
                                                <span class="d-inline-block text-truncate" style="max-width: 200px;" 
                                                      title="<?php echo htmlspecialchars($row['items']); ?>">
                                                    <?php echo htmlspecialchars($row['items']); ?>
                                                </span>
                                            </td>
                                            <td>₱<?php echo number_format($row['total_amount'], 2); ?></td>
                                            <td><?php echo date('M d, Y h:i A', strtotime($row['order_date'])); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $row['status'] === 'Approved' ? 'primary' : 'success'; ?>">
                                                    <?php echo $row['status']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button onclick="updateStatus('<?php echo $row['invoice']; ?>', 'Delivered')" 
                                                        class="btn btn-success btn-sm">
                                                    <i class="fa fa-check"></i> Mark as Delivered
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="7" class="text-center">No deliveries pending</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<!-- Add this before closing body tag -->
<script>
function updateStatus(invoice, status) {
    if (confirm('Are you sure you want to mark this order as ' + status + '?')) {
        $.ajax({
            url: 'update_order_status.php',
            type: 'POST',
            data: {
                invoice: invoice,
                status: status
            },
            success: function(response) {
                console.log('Response:', response);
                try {
                    if (response.success) {
                        alert('Order status updated successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + (response.message || 'Unknown error'));
                    }
                } catch (e) {
                    console.error('Error:', e);
                    alert('Error processing response');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error updating order status');
            }
        });
    }
}

// Initialize DataTable with custom options
$(document).ready(function() {
    $('#deliveryTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [[10], [10]],
        "order": [[4, "desc"]],
        "language": {
            "emptyTable": "<div class='no-data-message'>No deliveries pending</div>",
            "info": "Showing _START_ to _END_ of _TOTAL_ deliveries",
            "infoEmpty": "No deliveries available",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "responsive": true,
        "drawCallback": function(settings) {
            // Maintain minimum height even when fewer items
            if (settings._iDisplayLength > settings.fnRecordsDisplay()) {
                $('.dataTables_scrollBody').css('min-height', (settings._iDisplayLength * 50) + 'px');
            }
        }
    });
});
</script>

<!-- Additional styles for empty state -->
<style>
.no-data-message {
    padding: 40px;
    text-align: center;
    font-size: 16px;
    color: #666;
    background: #f9f9f9;
    border-radius: 4px;
    margin: 20px 0;
}

/* Style for table rows to maintain consistent height */
.table > tbody > tr > td {
    padding: 15px 8px;
    vertical-align: middle;
}

/* Ensure consistent spacing in pagination area */
.dataTables_wrapper .dataTables_paginate {
    padding: 15px 0;
    position: absolute;
    bottom: 0;
    right: 0;
}

.dataTables_wrapper .dataTables_info {
    padding: 15px 0;
    position: absolute;
    bottom: 0;
    left: 0;
}
</style>

<!-- Add this CSS -->
<style>
.badge {
    padding: 8px 12px;
    font-size: 0.9em;
}
.badge-primary { background-color: #007bff; }
.badge-success { background-color: #28a745; }
.table td { vertical-align: middle; }
.text-truncate { max-width: 200px; }
</style>

