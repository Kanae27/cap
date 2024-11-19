<?php
include('./header.php');
$r = mysqli_query($conn,"SELECT * FROM product");
$s = mysqli_num_rows($r); 
$r1 = mysqli_query($conn,"SELECT * FROM user");
$s1 = mysqli_num_rows($r1); 
$r2 = mysqli_query($conn,"SELECT * FROM cart WHERE status = 'Checkout'");
$s2 = mysqli_num_rows($r2); 
?>

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-sm-flex align-items-baseline report-summary-header">
                          <h5 class="font-weight-semibold">Report Summary</h5> 
                        </div>
                      </div>
                    </div>
  <div class="column" >
    <div class="card"><br>
	<h1 style="color:#000"><i class="fa-solid fa-sitemap"></i> &nbsp;&nbsp;<?php echo $s ?></h1>
	Total Number of Items</div>
  </div>
  <div class="column">
    <div class="card"><br>
	<h1 style="color:#000"><i class="fa-sharp fa-solid fa-users"></i> &nbsp;&nbsp;<?php echo $s1 ?></h1>
	Total Number of Registered Users</div>
  </div>
  <div class="column">
    <div class="card"><br>
	<h1 style="color:#000"><i class="fa-regular fa-list-radio"></i> &nbsp;&nbsp;<?php echo $s2 ?></h1>
	Total Number of Pending Orders</div>
  </div>
  
</div>
<br clear="all">
<br clear="all">
<div id="con" style="border:0px solid #000;width:100%;height:700px" ></div>
<table id="datatable1" style="display:none">
	<thead>
		<th>Item</th>
		<th>Quantity</th>
	</thead>
	<?php
	$result = mysqli_query($conn, "SELECT status,username,item,SUM(quantity) as quan FROM cart WHERE status = 'Approved' GROUP BY item ORDER BY quan DESC");
	while($row = mysqli_fetch_array($result)) {
		$product =$row['item'];
	$result1 = mysqli_query($conn, "SELECT * FROM product WHERE id = '$product'");
	while($row1 = mysqli_fetch_array($result1)) {
			$name = $row1['item'];
	}
		echo '<tr>';
		echo '<td>'.$name.'</td>';
		echo '<td>'.$row['quan'].'</td>';
		echo '</tr>';
	}
	?>
</table>
<div class="row">
  <div class="col-sm-4">

	</div>
</div>
	
 <script>
 
Highcharts.chart('con', {
    data: {
        table: 'datatable1'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Most Sold Items'
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Units'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' + this.point.y + ' ' + this.point.name.toLowerCase();
        }
    }, navigation: {
        buttonOptions: {
            enabled: true
        }
    }
});
 </script>      
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
            
          </div>
        
          
        </div>
      
      </div>
      
    </div>
  
    <script src="./vendors/js/vendor.bundle.base.js"></script>
  
    <script src="./vendors/chart.js/Chart.min.js"></script>
    <script src="./vendors/moment/moment.min.js"></script>
    <script src="./vendors/daterangepicker/daterangepicker.js"></script>
    <script src="./vendors/chartist/chartist.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="./js/off-canvas.js"></script>
    <script src="./js/misc.js"></script>

    <script src="./js/dashboard.js"></script>
  </body>
</html>