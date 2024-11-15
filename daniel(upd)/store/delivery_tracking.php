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

/* DataTable wrapper styling */
.dataTables_wrapper {
    position: relative;
    padding-bottom: 60px; /* Space for pagination */
}

/* Length (show entries) and filter styling */
.dataTables_length, .dataTables_filter {
    margin-bottom: 15px;
}

.dataTables_length {
    float: left;
}

.dataTables_filter {
    float: right;
}

/* Pagination styling */
.dataTables_paginate {
    position: absolute;
    bottom: 0;
    right: 0;
    padding: 15px 0;
}

.dataTables_info {
    position: absolute;
    bottom: 0;
    left: 0;
    padding: 15px 0;
}

/* Pagination buttons */
.paginate_button {
    padding: 5px 10px;
    margin: 0 2px;
    border: 1px solid #ddd;
    border-radius: 3px;
    cursor: pointer;
}

.paginate_button.current {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.paginate_button:hover:not(.current) {
    background: #f0f0f0;
}

/* Length menu styling */
.dataTables_length select {
    padding: 5px;
    margin: 0 5px;
    border-radius: 3px;
    border: 1px solid #ddd;
}

/* Search box styling */
.dataTables_filter input {
    padding: 5px 10px;
    border-radius: 3px;
    border: 1px solid #ddd;
    margin-left: 5px;
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
                                // Calculate pagination
                                $items_per_page = 10;
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $offset = ($page - 1) * $items_per_page;

                                // Get total count first
                                $count_query = "
                                    SELECT COUNT(DISTINCT c.invoice) as total
                                    FROM cart c
                                    JOIN product p ON c.product = p.id
                                    WHERE c.status = 'Approved' 
                                    AND c.username != 'pos'
                                ";
                                $count_result = mysqli_query($conn, $count_query);
                                $count_row = mysqli_fetch_assoc($count_result);
                                $total_records = $count_row['total'];
                                $total_pages = ceil($total_records / $items_per_page);

                                // Main query with LIMIT and OFFSET
                                $delivery_query = "
                                    SELECT 
                                        c.invoice,
                                        c.username,
                                        c.status,
                                        GROUP_CONCAT(p.item SEPARATOR ', ') as items,
                                        SUM(p.price * c.quantity) as total_amount,
                                        MIN(date) as order_date
                                    FROM cart c
                                    JOIN product p ON c.product = p.id
                                    WHERE c.status = 'Approved' 
                                    AND c.username != 'pos'
                                    GROUP BY c.invoice, c.username, c.status
                                    ORDER BY date DESC
                                    LIMIT $items_per_page OFFSET $offset
                                ";
                                
                                $result = mysqli_query($conn, $delivery_query);
                                
                                if ($result === false) {
                                    echo '<tr><td colspan="7" class="text-center">Error: ' . mysqli_error($conn) . '</td></tr>';
                                } else if(mysqli_num_rows($result) > 0) {
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

                        <!-- Entries info and pagination - now inside table container -->
                        <div style="margin-top: 10px; border-top: 1px solid #ddd; padding-top: 10px;">
                            <!-- Entries info -->
                            <div style="float: left; padding: 6px 0;">
                                <?php
                                $start = ($total_records == 0) ? 0 : $offset + 1;
                                $end = min($offset + $items_per_page, $total_records);
                                ?>
                                Showing <?php echo $start; ?> to <?php echo $end; ?> of <?php echo $total_records; ?> entries
                            </div>

                            <!-- Pagination -->
                            <div style="float: right;">
                                <div class="pagination-numbers">
                                    <?php if ($page > 1): ?>
                                        <a href="?page=<?php echo ($page-1); ?>" class="paginate_button">Previous</a>
                                    <?php endif; ?>

                                    <?php
                                    $start_page = max(1, $page - 2);
                                    $end_page = min($total_pages, $page + 2);

                                    for ($i = $start_page; $i <= $end_page; $i++): ?>
                                        <a href="?page=<?php echo $i; ?>" 
                                           class="paginate_button <?php echo ($i == $page) ? 'current' : ''; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <a href="?page=<?php echo ($page+1); ?>" class="paginate_button">Next</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
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
        pageLength: 10,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: true,
        dom: '<"top"B>rt<"bottom"ip>',
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-primary',
                buttons: ['copy', 'excel', 'pdf', 'print']
            }
        ],
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                previous: "Previous",
                next: "Next"
            }
        }
    });
});
</script>

<!-- Add these script dependencies after jQuery -->
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<!-- Add these CSS dependencies -->
<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

<!-- Replace the existing styles with these -->
<style>
.table-container {
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dataTables_wrapper {
    padding: 20px 0;
}

.dt-buttons .btn {
    margin-right: 5px;
}

/* Pagination styling */
.bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    margin-top: 20px;
}

.dataTables_info {
    font-size: 13px;
    color: #666;
}

.dataTables_paginate {
    text-align: right;
}

.paginate_button {
    padding: 5px 10px;
    margin: 0 2px;
    border: 1px solid #ddd;
    color: #333;
    cursor: pointer;
    background: #fff;
    border-radius: 3px;
}

.paginate_button.current {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.paginate_button:hover:not(.current):not(.disabled) {
    background: #f0f0f0;
    text-decoration: none;
}

.paginate_button.disabled {
    color: #999;
    cursor: not-allowed;
    background: #fff;
}

/* Table styling */
.table > tbody > tr > td {
    vertical-align: middle;
    padding: 12px 8px;
}

/* Badge styling */
.badge {
    padding: 8px 12px;
    font-size: 0.9em;
}

.badge-primary { 
    background-color: #007bff; 
}

.badge-success { 
    background-color: #28a745; 
}

/* Export buttons */
.dt-buttons {
    margin-bottom: 15px;
}

.dt-button {
    padding: 6px 12px;
    margin-right: 5px;
    border: 1px solid #ddd;
    background: #fff;
    border-radius: 3px;
    cursor: pointer;
}

.dt-button:hover {
    background: #f0f0f0;
}
</style>

<style>
.table-container {
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination-numbers {
    display: inline-block;
}

.paginate_button {
    display: inline-block;
    padding: 4px 8px;
    margin: 0 2px;
    border: 1px solid #ddd;
    color: #333;
    text-decoration: none;
    border-radius: 3px;
    font-size: 13px;
}

.paginate_button.current {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.paginate_button:hover:not(.current) {
    background-color: #f5f5f5;
    border-color: #ccc;
    cursor: pointer;
    text-decoration: none;
}

/* Info text styling */
.table-container div {
    font-size: 13px;
    color: #666;
}

/* Table styling */
.table > tbody > tr > td {
    vertical-align: middle;
    padding: 12px 8px;
}
</style>

