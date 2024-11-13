<?php
include('./header.php');

$search = $_POST['search'];
$result = $conn->query("SELECT * FROM product WHERE item LIKE '%$search%' OR description LIKE '%$search%' ORDER BY ID DESC LIMIT 10");
$s = mysqli_num_rows($result);

if ($s == 0) {
    echo '<h2>No Results Found for '.$search.'</h2>';
} else {
    echo '<div class="col-lg-12 pb-3">';
    echo '<h2>Results Found for '.$search.'</h2>';
    echo '</div>';
}
?>

<div class="row">
    <?php while ($row = $result->fetch_assoc()): ?>
        <?php
        $item_id = $row['id'];
        $rating_result = mysqli_query($conn, "SELECT AVG(rating) as av, COUNT(rating) as count FROM rating WHERE item = '$item_id'");
        $rating_data = mysqli_fetch_assoc($rating_result);

        $rating = $rating_data['av'] ? round($rating_data['av']) : 0;
        $rating_count = $rating_data['count'] ? $rating_data['count'] : 0;
        ?>
        <div class="col-lg-2 col-md-4 col-sm-6 pb-4">
            <div class="product-item bg-light mb-4">
                <div class="product-img position-relative overflow-hidden">
                    <img class="img-fluid product-medium" src="<?php echo $row['image'] ?>" alt="">
                    <div class="product-action">
                        <a class="btn btn-outline-dark btn-square" href="add_cart.php?id=<?php echo $row['id'] ?>"><i class="fa fa-shopping-cart"></i></a>
                        <a class="btn btn-outline-dark btn-square" href="add_heart.php?id=<?php echo $row['id'] ?>"><i class="far fa-heart"></i></a>
                        <a class="btn btn-outline-dark btn-square" href="details.php?id=<?php echo $row['id'] ?>"><i class="fa fa-search"></i></a>
                    </div>
                </div>
                <div class="text-center py-4">
                    <a class="h6 text-decoration-none text-truncate" href=""><?php echo $row['item'] ?></a>
                    <div class="d-flex align-items-center justify-content-center mt-2">
                        <h5>&#8369; <?php echo number_format($row['price'], 2) ?></h5>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $rating ? '<small class="fa fa-star text-primary mr-1"></small>' : '<small class="far fa-star text-primary mr-1"></small>';
                        }
                        ?>
                        <small>(<?php echo $rating_count ?>)</small>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include('./footer.php'); ?>
