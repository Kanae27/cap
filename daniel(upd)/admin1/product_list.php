<?php
include('./header.php');

?>

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-sm-flex align-items-baseline report-summary-header">
                          <h5 class="font-weight-semibold">Product List</h5> 
                        </div>
                      </div>
                    </div>
					<div style="width:100%;overflow-x:scroll">
					<input type="button" value="Add Product" class="btn btn-primary" id="myBtn">    
  <table id="customers" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Image</th>
                          <th>Product Name</th>
                          <th>Category</th>
                          <th>Quantity</th>
                          <th><center>Price</th>
                          <th><center>Description</th>
                          <th><center>Action</th>
                        </tr>
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

						echo '<tr>';
                        echo '  <td><img src="'.$row['image'].'" style="width:100px;height:100px"></td>';
                        echo '  <td>'.$row['item'].'</td>';
                        echo '  <td>'.$row['category'].'</td>';
                        echo '  <td>'.$row['quantity'].'</td>';
                        echo '  <td>&#x20B1; '.number_format($row['price'],2).'</td>';
                        echo '  <td  valign="top" width="10%">'.substr_replace($row['description'], "...", 100).'</td>';
						
                        echo '  <td  valign="top" width="10%"><center><input type="button" value="View Product Transaction" class="btn btn-primary" onclick="window.location=\'view_product_transaction.php?id='.$row['id'].'\'"><br><a style="margin:0px;margin-top:10px !important;width:100%" href="delete.php?id='.$row['id'].'" onclick="return confirm(\'Are you sure you want to delete this record?\')" class="btn btn-danger">Delete</a></td>';
                        echo '</tr>';
					
					  }
					  
					?>
                    
						</table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
             	<script>
 $('#customers').dataTable({
               
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Excel',
                        text:'Export to excel'
                        //Columns to export
                        //exportOptions: {
                       //     columns: [0, 1, 2, 3,4,5,6]
                       // }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'PDF',
                        text: 'Export to PDF'
                        //Columns to export
                        //exportOptions: {
                       //     columns: [0, 1, 2, 3, 4, 5, 6]
                      //  }
                    }
                ]
            });
  //]]></script>
          </div>
        
          
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
						<div style="width:100%;border:0px solid #000">
						<textarea name="description"   id="description" style="width:100%;height:200px"></textarea>
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
							<option>Shirts</option>
							<option>Jackets</option>
							<option>Caps</option>
							<option>Shorts</option>
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
                          <button type="button" onclick="window.location='product_list.php'" class="btn btn-danger">Cancel</button>
                        </div>
                      </div>
<br>
<br>
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

</script>
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