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


      <script type="text/javascript" src="https://cdn.jsdelivr.net/jsbarcode/3.5.1/JsBarcode.all.min.js"></script>
                <div class="col-md-12 col-sm-12 " style="color:#000">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Store List</h2>
                      
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      
                      <div class="dashboard-widget-content" style="width:100%;overflow-x:scroll">
                       <!-- <input type="button" value="Add Product" class="btn btn-primary" id="myBtn">    -->
                         <table id="datatable1" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                      <tr>
                          <th width="15%">Image</th>
                          <th>Product Name</th>
                          <th>Category</th>
                          <th>Quantity</th>
                          <th width="10%"><center>Price</th>
                          <th width="30%"><center>Description</th>
                          <th width="10%"><center>Action</th>
                      </thead>
                      <tbody>
					<?php
					include('../connect.php');
					  $username =$_SESSION['username'];
					$result = $conn->query("SELECT * FROM product ");
					  while($row = $result->fetch_assoc()) {
						  $id =$row['id'];
						  $barcode =$row['barcode'];
						  $quantity = $row['quantity'];
						  if($quantity <= 5) {
						echo '<tr style="background:#C9102A;color:#FFF">';
                        echo '  <td><img src="'.$row['image'].'" style="width:100px;height:100px"></td>';
                        echo '  <td>'.$row['item'].'</td>';
                        echo '  <td>'.$row['category'].'</td>';
                        echo '  <td>'.$row['quantity'].'</td>';
                        echo '  <td>&#x20B1; '.number_format($row['price'],2).'</td>';
                    
                        echo '  <td>'.substr_replace($row['description'], "...", 100).'</td>';
					    echo '  <td><center><input type="button" value="View Product Transaction" class="btn btn-primary" onclick="window.location=\'view_transaction.php?id='.$row['id'].'&item='.$row['item'].'\'"> </td>';
                        echo '</tr>';
							  
						  } else {
						echo '<tr>';
                        echo '  <td><img src="'.$row['image'].'" style="width:100px;height:100px"></td>';
                        echo '  <td>'.$row['item'].'</td>';
                        echo '  <td>'.$row['category'].'</td>';
                        echo '  <td>'.$row['quantity'].'</td>';
                        echo '  <td>&#x20B1; '.number_format($row['price'],2).'</td>';
                    
                        echo '  <td>'.substr_replace($row['description'], "...", 100).'</td>';
					
                        echo '  <td><center><input type="button" value="View Product Transaction" class="btn btn-primary" onclick="window.location=\'view_transaction.php?id='.$row['id'].'&item='.$row['item'].'\'"> </td>';
                        echo '</tr>';
					
						  }
						
					  }
					  
					?>
                    
						</table>
						
                      </div>
                    </div>
                  </div>
                </div>

              </div>
			  <div id="printme" style="display:none">
			  <h2>Product List</h2>
			  <table  class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Image</th>
                          <th>Product Name</th>
                          <th>Category</th>
                          <th>Quantity</th>
                          <th><center>Price</th>
                          <th><center>Compatibility</th>
                          <th><center>Description</th>
                          <th><center>BarCode</th>
                        </tr>
                      </thead>
                      <tbody>
					<?php
					include('../connect.php');
					  $username =$_SESSION['username'];
					$result = $conn->query("SELECT * FROM product WHERE username = '$username'");
					  while($row = $result->fetch_assoc()) {
						  $id =$row['id'];
						  $barcode =$row['barcode'];
						  $quantity = $row['quantity'];
						  if($quantity <= 5) {
						echo '<tr style="background:#C9102A;color:#FFF">';
                        echo '  <td><img src="'.$row['image'].'" style="width:100px;height:100px"></td>';
                        echo '  <td>'.$row['item'].'</td>';
                        echo '  <td>'.$row['category'].'</td>';
                        echo '  <td>'.$row['quantity'].'</td>';
                        echo '  <td>&#x20B1; '.number_format($row['price'],2).'</td>';
                        echo '  <td>'.$row['compatibility'].'</td>';
                        echo '  <td>'.substr_replace($row['description'], "...", 100).'</td>';
						echo '<td><svg id="bar'.$id.'" style="width:100%"></svg></td>';
                        echo '</tr>';
						echo '<input type="hidden" value="'.$id.'" id="pp'.$id.'">';
$id_1 = sprintf($barcode);
echo '						<script>';

  

  // binds an event that will trigger a new barcode as you type

echo '    JsBarcode("#bar'.$id.'", "'.$id_1.'");';



echo '  </script>';
							  
						  } else {
						echo '<tr>';
                        echo '  <td><img src="'.$row['image'].'" style="width:100px;height:100px"></td>';
                        echo '  <td>'.$row['item'].'</td>';
                        echo '  <td>'.$row['category'].'</td>';
                        echo '  <td>'.$row['quantity'].'</td>';
                        echo '  <td>&#x20B1; '.number_format($row['price'],2).'</td>';
                        echo '  <td>'.$row['compatibility'].'</td>';
                        echo '  <td>'.substr_replace($row['description'], "...", 100).'</td>';
						echo '<td><svg id="bar'.$id.'" style="width:100%"></svg></td>';
                      
                        echo '</tr>';
						echo '<input type="hidden" value="'.$id.'" id="pp'.$id.'">';
$id_1 = sprintf($barcode);
echo '						<script>';

  

  // binds an event that will trigger a new barcode as you type

echo '    JsBarcode("#bar'.$id.'", "'.$id_1.'");';



echo '  </script>';
						  }
						
					  }
					  
					?>
                    
						</table>
			  </div>
              <div class="row">
<script>
function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>

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
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Barcode Value</label>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                          <input type="text" class="form-control" name="barcode" required>
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
<option>CPU Cooler</option>
<option>RAM</option>
<option>Hard drive</option>
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
<option>PC Bundles - for gaming</option>
<option>PC Bundles - for office</option>
<option>Others</option>
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
	<style>
	.btn-default {
		background:#007BFF !important;
		color:#FFF;
		float:right !important;
	}
	</style>
	<script>
	
$('#datatable1').DataTable({
	    responsive: true,
		dom: 'Bfrtip',
		buttons: [
    { extend: 'copy', className: 'btn btn-primary', exportOptions: { columns: ':not(:last)' } },
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