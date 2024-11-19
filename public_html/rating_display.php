<div class="d-flex align-items-center justify-content-center mb-1">
    <?php
    $item = $row['id'];
    $r = mysqli_query($conn, "SELECT AVG(rating) as av FROM rating WHERE item = '$item'");
    $r2 = mysqli_query($conn, "SELECT COUNT(*) as count FROM rating WHERE item = '$item'");
    $rating_data = mysqli_fetch_assoc($r);
    $rating_count = mysqli_fetch_assoc($r2);
    $rating = round($rating_data['av']); // Round to nearest integer
    $s = $rating_count['count'];

    // Display stars based on rating
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            echo '<small class="fa fa-star text-primary mr-1"></small>';
        } else {
            echo '<small class="far fa-star text-primary mr-1"></small>';
        }
    }
    ?>
    <small>(<?php echo $s ?>)</small>
</div> 