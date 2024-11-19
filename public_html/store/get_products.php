<?php
include('../connect.php');

$items_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

$result = $conn->query("SELECT * FROM product WHERE quantity > 0 ORDER BY item LIMIT $items_per_page OFFSET $offset");
while($row = $result->fetch_assoc()) {
    ?>
    <div class="product-card" data-name="<?php echo htmlspecialchars(strtolower($row['item'])); ?>" 
                           data-category="<?php echo htmlspecialchars(strtolower($row['category'])); ?>">
        <img src="<?php echo htmlspecialchars($row['image']); ?>" class="product-image" 
             alt="<?php echo htmlspecialchars($row['item']); ?>" 
             onerror="this.src='default-product-image.jpg'">
        <div class="product-info">
            <div class="product-name"><?php echo $row['item']; ?></div>
            <div class="product-price">₱<?php echo number_format($row['price'], 2); ?></div>
            <div class="stock-info">In Stock: <?php echo $row['quantity']; ?></div>
            <div class="quantity-controls">
                <button type="button" class="qty-btn" 
                        onclick="updateCart(<?php echo $row['id']; ?>, -1, <?php echo $row['quantity']; ?>)">-</button>
                <span class="qty-display" id="qty-<?php echo $row['id']; ?>">0</span>
                <button type="button" class="qty-btn" 
                        onclick="updateCart(<?php echo $row['id']; ?>, 1, <?php echo $row['quantity']; ?>)">+</button>
            </div>
        </div>
    </div>
    <?php
}
?> 