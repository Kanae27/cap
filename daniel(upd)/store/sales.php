<?php include('./header.php'); ?>

<!-- CSS Dependencies -->
<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

<style>
.card {
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-body {
    padding: 20px;
}

.table-container {
    margin-top: 30px;
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

.chart-container {
    margin-top: 30px;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
}

.charts-row {
    margin: 0 -10px 20px -10px;
}

.chart-container {
    background: #fff;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 10px;
}

@media (max-width: 768px) {
    .chart-container {
        margin-bottom: 15px;
    }
}

.list-unstyled {
    margin-bottom: 0;
}
.list-unstyled li {
    margin-bottom: 3px;
}
.list-unstyled li:last-child {
    margin-bottom: 0;
}
</style>

<!-- Main Content -->
<div class="right_col" role="main">
    <!-- Filter Section -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filter by Date</h5>
                    <form action="filter.php" method="POST">
                        <div class="form-group">
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <button type="submit" name="by_date" class="btn btn-primary">Apply Filter</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filter by Month</h5>
                    <form action="filter.php" method="POST">
                        <div class="form-group">
                            <label>Start Month</label>
                            <input type="month" name="start_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>End Month</label>
                            <input type="month" name="end_date" class="form-control" required>
                        </div>
                        <button type="submit" name="by_month" class="btn btn-primary">Apply Filter</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filter by Year</h5>
                    <form action="filter.php" method="POST">
                        <div class="form-group">
                            <input type="number" name="year" class="form-control" placeholder="Enter Year" required>
                        </div>
                        <button type="submit" name="by_year" class="btn btn-primary">Apply Filter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- After filter section and before purchase list -->
    <div class="row charts-row">
        <!-- Monthly Sales Bar Chart -->
        <div class="col-md-8">
            <div class="chart-container">
                <div id="salesChart" style="width:100%; height:400px"></div>
                <table id="graphData" class="display" style="display:none">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Number of Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Initialize monthly variables for current year
                        $current_year = date('Y');
                        $months = array_fill(1, 12, 0); // Initialize with month numbers as keys

                        // Monthly sales calculation
                        $monthly_query = "
                            SELECT 
                                MONTH(c.timestamp) as month,
                                SUM(c.quantity * p.price) as total
                            FROM (
                                SELECT product as product_id, quantity, timestamp FROM cart
                                UNION ALL
                                SELECT product_id, quantity, timestamp FROM cart_items
                            ) c
                            JOIN product p ON c.product_id = p.id
                            WHERE YEAR(c.timestamp) = $current_year
                            GROUP BY MONTH(c.timestamp)
                            ORDER BY month
                        ";

                        $result = $conn->query($monthly_query);
                        if ($result === false) {
                            error_log("Monthly query error: " . $conn->error);
                        } else {
                            while($row = $result->fetch_assoc()) {
                                $months[$row['month']] = floatval($row['total']);
                            }
                        }

                        // Output monthly data for the graph
                        echo "<table id='graphData' style='display:none'>";
                        echo "<thead><tr><th>Month</th><th>Sales</th></tr></thead><tbody>";
                        foreach($months as $month_num => $total) {
                            $month_name = date('F', mktime(0, 0, 0, $month_num, 1));
                            echo "<tr>";
                            echo "<td>" . $month_name . "</td>";
                            echo "<td>" . $total . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table>";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Most Purchased Products Pie Chart -->
        <div class="col-md-4">
            <div class="chart-container">
                <div id="productPieChart" style="width:100%; height:400px"></div>
                <?php
                // Most purchased products for pie chart
                $pie_query = "
                    SELECT 
                        p.item as name,
                        SUM(c.quantity) as total_quantity,
                        SUM(c.quantity * p.price) as total_sales
                    FROM (
                        SELECT product as product_id, quantity FROM cart
                        UNION ALL
                        SELECT product_id, quantity FROM cart_items
                    ) c
                    JOIN product p ON c.product_id = p.id
                    GROUP BY p.id, p.item
                    ORDER BY total_quantity DESC
                    LIMIT 5
                ";

                $pie_result = $conn->query($pie_query);
                $pie_data = array();

                if ($pie_result === false) {
                    error_log("Pie chart query error: " . $conn->error);
                } else {
                    while($row = $pie_result->fetch_assoc()) {
                        $pie_data[] = array(
                            'name' => $row['name'],
                            'y' => intval($row['total_quantity']),
                            'sales' => number_format($row['total_sales'], 2)
                        );
                    }
                }

                // If no data, add dummy data to prevent JavaScript errors
                if (empty($pie_data)) {
                    $pie_data[] = array(
                        'name' => 'No Data',
                        'y' => 0,
                        'sales' => '0.00'
                    );
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="table-container">
        <h2>Purchase List</h2>
        <table id="salesTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Item/Quantity</th>
                    <th>Total Price</th>
                    <th>Date Purchased</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = mysqli_connect("localhost", "root", "", "daniel");
                // Purchase list query - separate queries and combine results
                $cart_purchases = $conn->query("
                    SELECT DISTINCT 
                        invoice,
                        timestamp,
                        name,
                        contact,
                        address,
                        'cart' as source
                    FROM cart 
                    ORDER BY timestamp DESC
                ");

                $cart_items_purchases = $conn->query("
                    SELECT DISTINCT 
                        invoice,
                        timestamp,
                        name,
                        contact,
                        address,
                        'cart_items' as source
                    FROM cart_items 
                    ORDER BY timestamp DESC
                ");

                // Combine and display results
                if ($cart_purchases) {
                    while ($row = $cart_purchases->fetch_assoc()) {
                        displayPurchaseRow($conn, $row);
                    }
                }

                if ($cart_items_purchases) {
                    while ($row = $cart_items_purchases->fetch_assoc()) {
                        displayPurchaseRow($conn, $row);
                    }
                }

                // Helper function to display purchase row
                function displayPurchaseRow($conn, $details) {
                    $invoice = $details['invoice'];
                    $source = $details['source'];
                    
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($invoice) . '</td>';
                    echo '<td>' . htmlspecialchars($details['name'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($details['contact'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($details['address'] ?? '') . '</td>';
                    
                    // Get items
                    echo '<td><ul class="list-unstyled">';
                    if ($source == 'cart') {
                        $items_query = "
                            SELECT c.quantity, p.item, p.price, p.type_quantity
                            FROM cart c
                            JOIN product p ON c.product = p.id
                            WHERE c.invoice = '$invoice'
                        ";
                    } else {
                        $items_query = "
                            SELECT c.quantity, p.item, p.price, p.type_quantity
                            FROM cart_items c
                            JOIN product p ON c.product_id = p.id
                            WHERE c.invoice = '$invoice'
                        ";
                    }
                    
                    $items_result = $conn->query($items_query);
                    $total = 0;
                    
                    if ($items_result) {
                        while ($item = $items_result->fetch_assoc()) {
                            $quantity = $item['quantity'];
                            $subtotal = $quantity * $item['price'];
                            $total += $subtotal;
                            
                            echo '<li>' . 
                                 htmlspecialchars($item['item']) . ' × ' . 
                                 $quantity . ' ' . 
                                 htmlspecialchars($item['type_quantity'] ?? 'pcs') . 
                                 ' (₱' . number_format($item['price'], 2) . ' each)' .
                                 '</li>';
                        }
                    }
                    echo '</ul></td>';
                    
                    echo '<td>₱' . number_format($total, 2) . '</td>';
                    echo '<td>' . date('F d, Y', strtotime($details['timestamp'])) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<!-- Add Highcharts scripts before your existing scripts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<!-- Add this to your existing script section -->
<script>
$(document).ready(function() {
    $('#salesTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: false,
        dom: '<"top"B>rt<"bottom"p>',
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-primary',
                buttons: ['copy', 'excel', 'pdf', 'print']
            }
        ],
        language: {
            paginate: {
                previous: '«',
                next: '»'
            }
        }
    });
});

// Monthly Sales Chart
Highcharts.chart('salesChart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Sales Report <?php echo $current_year; ?>'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        crosshair: true
    },
    yAxis: {
        title: {
            text: 'Total Sales (₱)'
        },
        labels: {
            formatter: function() {
                return '₱' + Highcharts.numberFormat(this.value, 2);
            }
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="padding:0"><b>₱{point.y:.2f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    series: [{
        name: 'Monthly Sales',
        data: <?php echo json_encode(array_values($months)); ?>
    }]
});

// Product Pie Chart
Highcharts.chart('productPieChart', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Most Purchased Products'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>' +
                    'Quantity: {point.y}<br>' +
                    'Total Sales: ₱{point.sales}'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f}%'
            }
        }
    },
    series: [{
        name: 'Products',
        colorByPoint: true,
        data: <?php echo json_encode($pie_data); ?>
    }]
});
</script>

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
  </body>
</html>
