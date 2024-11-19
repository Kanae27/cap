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
                        // Initialize monthly variables
                        $months = [
                            'January' => 0, 'February' => 0, 'March' => 0,
                            'April' => 0, 'May' => 0, 'June' => 0,
                            'July' => 0, 'August' => 0, 'September' => 0,
                            'October' => 0, 'November' => 0, 'December' => 0
                        ];

                        $result = $conn->query("SELECT cart.*, product.price 
                                              FROM cart 
                                              JOIN product ON cart.product = product.id 
                                              WHERE cart.status = 'Approved'");

                        while($row = $result->fetch_assoc()) {
                            $month = date('F', strtotime($row['timestamp']));
                            $total = $row['quantity'] * $row['price'];
                            $months[$month] += $total;
                        }

                        foreach($months as $month => $total) {
                            echo "<tr>";
                            echo "<td>" . $month . "</td>";
                            echo "<td>" . $total . "</td>";
                            echo "</tr>";
                        }
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
                $product_query = "SELECT p.item, SUM(c.quantity) as total_quantity 
                                FROM cart c 
                                JOIN product p ON c.product = p.id 
                                WHERE c.status = 'Approved' 
                                GROUP BY p.id 
                                ORDER BY total_quantity DESC 
                                LIMIT 5";
                $product_result = $conn->query($product_query);
                
                $pie_data = array();
                while($row = $product_result->fetch_assoc()) {
                    $pie_data[] = array(
                        'name' => $row['item'],
                        'y' => (int)$row['total_quantity']
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
                $result = $conn->query("SELECT * FROM cart WHERE status = 'Approved' GROUP BY invoice ORDER BY timestamp DESC");
                
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['invoice']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['name'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($row['contact'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($row['address'] ?? '') . '</td>';
                    
                    // Items column
                    echo '<td><ul class="list-unstyled">';
                    $invoice = $row['invoice'];
                    $items_query = $conn->query("SELECT c.*, p.item, p.price, p.type_quantity 
                                               FROM cart c 
                                               JOIN product p ON c.product = p.id 
                                               WHERE c.invoice = '$invoice'");
                    $total = 0;
                    while ($item = $items_query->fetch_assoc()) {
                        $subtotal = $item['quantity'] * $item['price'];
                        $total += $subtotal;
                        echo '<li>' . htmlspecialchars($item['item']) . ' - ' . $item['quantity'] . ' ' . 
                             htmlspecialchars($item['type_quantity'] ?? 'pcs') . '</li>';
                    }
                    echo '</ul></td>';
                    
                    echo '<td>₱' . number_format($total, 2) . '</td>';
                    echo '<td>' . date('F d, Y', strtotime($row['timestamp'])) . '</td>';
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
    data: {
        table: 'graphData'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Sales Report'
    },
    yAxis: {
        title: {
            text: 'Total Sales (₱)'
        },
        labels: {
            formatter: function() {
                return '₱' + this.value.toLocaleString();
            }
        }
    },
    tooltip: {
        formatter: function() {
            return '<b>' + this.series.name + '</b><br/>' +
                   this.point.name + ': ₱' + this.point.y.toLocaleString();
        }
    }
});

// Product Pie Chart
Highcharts.chart('productPieChart', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Most Purchased Products'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>Quantity: {point.y}'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
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
