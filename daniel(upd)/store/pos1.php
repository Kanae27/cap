<?php
include('./header.php');

// Initialize customer variable
$customer = isset($_GET['user1']) ? $_GET['user1'] : '';

// Add invoice number generation if not set
$invoice = isset($_GET['invoice']) ? $_GET['invoice'] : date('YmdHis');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


      <script type="text/javascript" src="https://rawgit.com/select2/select2/master/dist/js/select2.js"></script>
      <link rel="stylesheet" type="text/css" href="https://rawgit.com/select2/select2/master/dist/css/select2.min.css">        <!-- page content -->
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

<?php
if(isset($_POST['submit'])) {
	include('../connect.php');
	$product = $_POST['product'];
	$quantity = $_POST['quantity'];
	$username = $_SESSION['username'];
	$result = $conn->query("SELECT * FROM product WHERE id = '$product'");
	  while($row = $result->fetch_assoc()) {
		  $price =$row['price'];
	  }
	  $status = 'Pending';
	  $total = $quantity * $price;
	  $stmt = $conn->prepare("INSERT INTO cart (product, username, status, quantity, invoice) VALUES (?, ?, ?, ?, ?)");
	  $stmt->bind_param("issss", $product, $username, $status, $quantity, $invoice);
	  $stmt->execute();
	  echo '<script>window.location="pos1.php?invoice=' . $invoice . '";</script>';
}
if(isset($_GET['delete'])) {
	
include('../connect.php');
$id =$_GET['id'];
$result = $conn->query("DELETE FROM cart WHERE id = '$id'");
}
?>
                <div class="col-md-12 col-sm-12 " style="color:#000">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Point of Sale</h2>
                      
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      
                      <div class="dashboard-widget-content" style="width:100%;overflow-x:scroll">
					  <?php
					  
					  ?>
					 <input type="button" value="Clear Items" onclick="window.location='del.php';" class="btn btn-danger" style="float:right">
					  <form action="#" method="POST">
					  <table width="75%">
						<tr>
							<td width="33%" valign="top">
							 <select name="product" class="form-control" id="product" autofocus()>
						<option></option>
						<?php
						include('../connect.php');
					  $username =$_SESSION['username'];
					$result = $conn->query("SELECT * FROM product WHERE username = '$username'");
					  while($row = $result->fetch_assoc()) {
						  echo '<option value="'.$row['id'].'">'.$row['barcode'].' - '.$row['item'].'</option>';
					  }
						?>
					  </select>
							<td width="33%" valign="top"><input type="text" name="quantity" required placeholder="Quantity" class="form-control"></td>
							</td>
							<td width="33%" valign="top"><input type="submit" name="submit" value="Add product" class="btn btn-primary"></td>
						</tr>
					  </table>
					 </form>
                         <table  class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Image</th>
                          <th>Product Name</th>
                          <th>Category</th>
                          <th><center>Price</th>
                          <th><center>Quantity to Purchase</th>
                          <th><center>Total Price</th>
                          <th><center>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					<?php
					include('../connect.php');
					$total_price = 0;
					  $username =$_SESSION['username'];
					$result = $conn->query("SELECT * FROM cart WHERE username = '$username' AND status = 'Pending' AND invoice = '$invoice'");
					  while($row = $result->fetch_assoc()) {
						  $id =$row['id'];
						  $product =$row['product'];
						  $quantity = $row['quantity'];
						  $customer = $row['customer'];
					$result1 = $conn->query("SELECT * FROM product WHERE id = '$product'");
					  while($row1 = $result1->fetch_assoc()) {
						  $id_prod = $row1['id'];
						  $item = $row1['item'];
						  $category = $row1['category'];
						  $price = $row1['price'];
						  $compatibility = $row1['compatibility'];
						  $description = $row1['description'];
						  $image = $row1['image'];
					  }
						  $total = $quantity  * $price;
						echo '<tr>';
                        echo '  <td><img src="'.$image.'" style="width:100px;height:100px"></td>';
                        echo '  <td>'.$item.'</td>';
                        echo '  <td>'.$category.'</td>';
                        echo '  <td>&#x20B1; '.number_format($price,2).'</td>';
                        echo '  <td>'.$quantity.'</td>';
                        echo '  <td>'.number_format($total,2).'</td>';
                        echo '  <td><center><input type="button" value="Delete" class="btn btn-danger" onclick="window.location=\'#p?id='.$row['id'].'\'"></td>';
                        echo '</tr>';
						echo '<input type="hidden" value="'.$id.'" id="pp'.$id.'">';
$id_1 = sprintf("%08d", $id_prod);
$total_price += $total;
echo '						<script>';

  

  // binds an event that will trigger a new barcode as you type

echo '    JsBarcode("#bar'.$id_prod.'", "'.$id_1.'");';



echo '  </script>';
						
					  }
					  //check for email
					  if($customer == '') {
						  $email = 'rhenoah15@gmail.com';
					  } else {
						  
						$result1a = $conn->query("SELECT * FROM user WHERE username = '$customer'");
						while($row1a = $result1a->fetch_assoc()) {
							$email = $row1a['email'];
						  }
					  }
					  //end check
					?>
                    <tr>
						<td colspan="5" align="right">Total Price</td>
						<td><?php echo number_format($total_price,2) ?></td>
						<td></td>
					</tr>
						</table>
						<input type="button" value="Purchase Items" class="btn btn-primary" onclick="window.location='purchase.php?email=<?php echo $email ?>&invoice=<?php echo $invoice ?>'" >
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
$('#product').select2({
    placeholder: 'Select an item'
});
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
	
  </body>
</html>
