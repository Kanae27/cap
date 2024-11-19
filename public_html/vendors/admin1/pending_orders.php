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
                          <h5 class="font-weight-semibold">Pending Orders</h5> 
                        </div>
                      </div>
                    </div>
  <table id="customers" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Customer Name</th>
                          <th>Address</th>
                          <th>Contact Number</th>
                          <th>Number of Items Purchased</th>
                          <th>Type of Transaction</th>
                          <th>Type of Payment</th>
                          <th>Receipt</th>
                          <th><center>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					<?php
					include('../connect.php');
						$username =$_SESSION['username'];
						$result = $conn->query("SELECT * FROM transaction WHERE status = 'Pending'");
						$s = mysqli_num_rows($result);
						if($s>0) {
						while($row = $result->fetch_assoc()) {
							$trans_id = $row['trans_id'];
							$transaction = $row['payment'];
							$ss = mysqli_query($conn,"SELECT * FROM cart WHERE trans_id = '$trans_id'"); 
							$quantity = mysqli_num_rows($ss);
							while($rs = mysqli_fetch_array($ss)) {
								$item = $rs['item'];
								$username = $row['username'];
								$r1 = mysqli_query($conn,"SELECT * FROM user WHERE username = '$username'");
								while($row1 = mysqli_fetch_array($r1)) {
									$name =$row1['name'];
									$address =$row1['address'];
									$contact =$row1['contact'];
								}
						echo '<tr>';
                        echo '  <td>'.$name.'</td>';
                        echo '  <td>'.$address.'</td>';
                        echo '  <td>'.$contact.'</td>';
                        echo '  <td>'.$quantity.'</td>';
                        echo '  <td>'.$row['transaction'].'</td>';
						echo '  <td>'.$row['payment'].'</td>';
						if($transaction == 'Online Payment') {
							echo '<td><a href="../uploads/'.$row['receipt'].'" class="btn btn-primary" target="_blank">View Receipt</a></td>';
						} else {
							echo  '<td></td>';
						}
							
                        echo '  <td><center><input type="button" value="View Product Transaction" class="btn btn-primary" onclick="window.location=\'view_transaction.php?id='.$row['username'].'&trans_id='.$trans_id.'\'"></td>';
                        echo '</tr>';
							}
						}
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