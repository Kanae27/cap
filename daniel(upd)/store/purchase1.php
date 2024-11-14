<?php
include('../connect.php');
session_start();
$name = $_SESSION['name1'];
$address = $_SESSION['address1'];
$contact = $_SESSION['contact1'];
$invoice = $_SESSION['invoice1'];

// Update only the cart items for this specific invoice, excluding POS entries
$result = $conn->query("UPDATE cart SET 
    name = '$name',
    address = '$address',
    contact = '$contact',
    invoice = '$invoice',
    status = 'Approved'
    WHERE invoice = '$invoice' 
    AND status = 'Pending'
    AND type != 'POS'");  // Exclude POS entries from being updated

?>
<script>
alert("Items has been purchased");
window.location='pos.php';
</script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="modal" tabindex="-1" role="dialog" id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">MGS PC Trading</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location='pos.php'">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Item has been purchased.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="window.location='pos.php'">Ok</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(window).on('load', function() {
        $('#myModal').modal('show');
    });
</script>