<?php
include('./header.php');
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row" style="display: inline-block;" >
          <div class="tile_count">
           &nbsp;
          </div>
        </div>
          <!-- /top tiles -->

          <br />


<style>
	.nicEdit-main {
		width:100% !important;
	}
	
.ck-editor__editable_inline {
    min-height: 200px;
}
</style>
              <div class="row">

                <div class="col-md-12 col-sm-12 " style="color:#000">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Purchase List</h2>
                      
                      <div class="clearfix"></div>
                    </div>
					
                    <div class="x_content">
                      <div class="dashboard-widget-content">
					  
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
					  
					  
					  <br>
					  
                         <table id="datatable" class="table table-striped table-bordered" style="width:100%;border:1px solid #00">
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
					
					include('../connect.php');
					$total = 0;
					$username =$_SESSION['username'];
					//start
					if(isset($_POST['by_date'])) {
						$date = $_POST['date'];
						$d = date('F d, Y',strtotime($date));
						echo '<h3>Sales Report for - '.$d.'</h3>';
						$result1 = $conn->query("SELECT * FROM cart WHERE status = 'Approved' AND DATE(timestamp) = '$date'");
					}
					if(isset($_POST['by_month'])) {
						$start_date = $_POST['start_date'];
						$end_date = $_POST['end_date'];
						$s_m = date('m',strtotime($start_date));
						$e_m = date('m',strtotime($end_date));
						$s_y = date('Y',strtotime($start_date));
						$e_y = date('Y',strtotime($end_date));
						//echo $s_m;
						$d1 = date('F, Y',strtotime($start_date));
						$d2 = date('F, Y',strtotime($end_date));
						echo '<h3>Sales Report for - '.$d1.' - '.$d2.'</h3>';
						$result1 = $conn->query("SELECT * FROM cart WHERE status = 'Approved' AND MONTH(timestamp) <= '$e_m' AND MONTH(timestamp) >= '$s_m' AND YEAR(timestamp) >= '$s_y' AND YEAR(timestamp) >= '$e_y'");
					}
					if(isset($_POST['by_year'])) {
						$year = $_POST['year'];
						echo '<h3>Sales Report for - '.$year.'</h3>';
						$result1 = $conn->query("SELECT * FROM cart WHERE status = 'Approved' AND YEAR(timestamp) = '$year'");
					}
					
					//end
 while($row1 = $result1->fetch_assoc()) {
						  $product = $row1['product'];
						  $date = $row1['timestamp'];
						  $name = $row1['name'];
						  $invoice = $row1['invoice'];
						  $contact = $row1['contact'];
						  $address = $row1['address'];
						  echo '<tr>';
                        echo '  <td>'.$invoice.'<span style="color:#FFF">a</span></td>';
                        echo '  <td>'.$name.'</td>';
                        echo '  <td>'.$contact.'</td>';
                        echo '  <td>'.$address.'</td>';
						echo '<td>';
						//check item from invoice
						$invoice = $row1['invoice'];
						$t = 0;
						$result1a = $conn->query("SELECT * FROM cart WHERE invoice = '$invoice'");
						while($row1a = $result1a->fetch_assoc()) {
						$prd = $row1a['product'];
							$result = $conn->query("SELECT * FROM product WHERE id = '$prd' ");
								while($row = $result->fetch_assoc()) {
									$item =$row['item'];
									$description =$row['description'];
									$price = $row['price'];
									$type_quantity =$row['type_quantity'];
									$quantity = $row1['quantity'];
									$p = $quantity * $price;
									$date = date('F d, Y',strtotime($date));
									echo '<li>'.$item.' - '.$quantity.' '.$type_quantity.'</li>';
							}
						 $t += $p;
					  }
					  echo '</td>';
                       
                       
                        echo '  <td>'.number_format($t,2).'</td>';
						//end check
                        echo '  <td>'.$date.'</td>';
                        echo '</tr>';
						//echo $t;
						if(isset($p)) {
								$total += $p;
						} else {
						$total = 0;
						}
					  }
					  
					?>
					</table>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
	<h3>Fill up all fields to add an item</h2>
      <span class="close">&times;</span>
      
    </div>
    <div class="modal-body">
      
					  
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
				
                    <form class="form-horizontal form-label-left" action="addproductexec.php" method="POST">

                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Item Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" name="item" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
						<div style="width:100%;border:1px solid #000">
						<textarea name="description"  style="width:100%;height:200px !important" id="description"></textarea>
						</div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Price</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="number" class="form-control" name="price" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Product Image</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="file" class="form-control" name="image" id="image" required accept="image/png, image/gif, image/jpeg">
						  <textarea id="img" name="img" style="display:none !important"></textarea>
                        </div>
                      </div>
					  <script>
const fileInput = document.getElementById('image');
fileInput.addEventListener('change', (e) => {
// get a reference to the file
const file = e.target.files[0];

// encode the file using the FileReader API
const reader = new FileReader();
reader.onloadend = () => {

    // use a regex to remove data url part
    const base64String = reader.result;
        document.getElementById('img').value =reader.result; 
    console.log(base64String);
};
reader.readAsDataURL(file);});
				</script>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Catergory</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
						<select class="form-control" name="category">
							<option></option>
							<option>Processors</option>
<option>Motherboards</option>
<option>CPU Fans</option>
<option>RAM</option>
<option>Hard drives</option>
<option>Solid States</option>
<option>Power Supply</option>
<option>Case</option>
<option>Case Fans</option>
<option>Monitors</option>
<option>Keyboards</option>
<option>Mouse</option>
<option>AVR</option>
<option>Webcam</option>
<option>Speakers</option>
<option>Cables</option>
<option>Routers</option>
						</select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Compatibility</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <select name="compatibility" required class="form-control">
							<option></option>
							<option>Intel</option>
							<option>AMD</option>
							<option>None</option>
						  </select>
                        </div>
                      </div>
					  
                      <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Quantity</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="number" class="form-control" name="quantity" required>
                        </div>
                      </div>
                      <div class="ln_solid"></div>

                      <div class="form-group row">
                        <div class="col-md-9 offset-md-3">
                          <button type="submit" class="btn btn-success" name="submit">Submit</button>
                          <button type="button" onclick="window.location='product.php'" class="btn btn-danger">Cancel</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
    </div>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

	$('#description').width('100%');
	$('.nicEdit-main').width('100%');
</script>


              </div>
            </div>
          </div>
        </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Daniel and Marilyn's General Merchandise - 2024
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div> <script>
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
   <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

  <script>
$('#datatable').DataTable({
	    responsive: true,
		dom: 'Bfrtip',
		buttons: [
    { extend: 'copy', className: 'btn btn-success', exportOptions: { columns: ':not(:last)' } },
    { extend: 'excel', className: 'btn btn-primary', exportOptions: { columns: ':not(:last)' } },
    { extend: 'pdf', className: 'btn btn-primary', exportOptions: { columns: ':not(:last)' } },
    { extend: 'print', className: 'btn btn-primary', exportOptions: { columns: ':not(:last)' } }
	], initComplete: function () {
				var btns = $('.dt-button');
				btns.addClass('btn btn-success sp');
				btns.removeClass('dt-button');
        }
        });
		</script>	
  </body>
</html>
