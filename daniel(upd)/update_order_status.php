<?php
include('./header.php');
if(!isset($_SESSION['admin'])) {
    echo '<script>alert("Access denied!");window.location.href="index.php";</script>';
    exit;
}

if(isset($_POST['update_status'])) {
    $cart_id = $_POST['cart_id'];
    $status = $_POST['status'];
    $tracking = $_POST['tracking_number'];
    $notes = $_POST['notes'];
    $admin = $_SESSION['admin'];
    
    $query = "INSERT INTO order_status (cart_id, order_status, tracking_number, notes, updated_by) 
              VALUES ('$cart_id', '$status', '$tracking', '$notes', '$admin')
              ON DUPLICATE KEY UPDATE 
              order_status = VALUES(order_status),
              tracking_number = VALUES(tracking_number),
              notes = VALUES(notes),
              updated_by = VALUES(updated_by)";
              
    if(mysqli_query($conn, $query)) {
        echo '<script>alert("Order status updated successfully!");window.history.back();</script>';
    } else {
        echo '<script>alert("Error updating status: '.mysqli_error($conn).'");window.history.back();</script>';
    }
}
?>

<div class="container mt-4">
    <h2>Update Order Status</h2>
    <form method="POST">
        <input type="hidden" name="cart_id" value="<?php echo $_GET['id']; ?>">
        
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Shipped">Shipped</option>
                <option value="Out for Delivery">Out for Delivery</option>
                <option value="Delivered">Delivered</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Tracking Number</label>
            <input type="text" name="tracking_number" class="form-control">
        </div>
        
        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>
        
        <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
    </form>
</div> 