<?php include('./header.php'); ?>

<style>
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
    margin-bottom: 0;
    min-height: 600px;
}

.product-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 15px;
    text-align: center;
    transition: transform 0.2s;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 15px;
}

.product-info {
    padding: 10px;
}

.product-name {
    font-weight: bold;
    margin: 10px 0;
    font-size: 1.1em;
}

.product-price {
    color: #347928;
    font-size: 1.2em;
    font-weight: bold;
    margin: 8px 0;
}

.quantity-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin: 15px 0;
}

.qty-btn {
    background: #347928;
    color: white;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
}

.qty-input {
    width: 60px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
}

.add-to-cart-btn {
    background: #347928;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    width: 100%;
    cursor: pointer;
    transition: background 0.2s;
}

.add-to-cart-btn:hover {
    background: #2a6320;
}

.cart-panel {
    position: fixed;
    right: 0;
    top: 0;
    width: 350px;
    height: 100vh;
    background: white;
    box-shadow: -2px 0 5px rgba(0,0,0,0.1);
    padding: 20px;
    overflow-y: auto;
}

.cart-title {
    font-size: 1.5em;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #347928;
}

.cart-items {
    margin-bottom: 20px;
}

.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.cart-total {
    font-size: 1.2em;
    font-weight: bold;
    margin: 20px 0;
    text-align: right;
}

.checkout-btn {
    background: #347928;
    color: white;
    border: none;
    padding: 12px;
    width: 100%;
    border-radius: 4px;
    font-size: 1.1em;
    cursor: pointer;
}

.main-content {
    margin-right: 350px;
}

.category-filter {
    padding: 20px;
    background: white;
    border-radius: 8px;
    margin-bottom: 20px;
}

.pagination-numbers {
    display: inline-block;
}

.paginate_button {
    display: inline-block;
    padding: 4px 8px;
    margin: 0 2px;
    border: 1px solid #ddd;
    color: #333;
    text-decoration: none;
    border-radius: 3px;
    font-size: 13px;
}

.paginate_button.current {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.paginate_button:hover:not(.current) {
    background-color: #f5f5f5;
    border-color: #ccc;
    cursor: pointer;
    text-decoration: none;
}

/* Info text styling */
div {
    font-size: 13px;
    color: #666;
}
</style>

<div class="right_col" role="main">
    <div class="main-content">
        <!-- Search Filter -->
        <div class="category-filter">
            <input type="text" class="form-control" id="productSearch" placeholder="Search products...">
        </div>

        <!-- Products Grid -->
        <div class="product-grid">
            <?php
            include('../connect.php');
            // Pagination setup
            $items_per_page = 10;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $items_per_page;

            // Get total count
            $count_query = "SELECT COUNT(*) as total FROM product WHERE quantity > 0";
            $count_result = mysqli_query($conn, $count_query);
            $count_row = mysqli_fetch_assoc($count_result);
            $total_records = $count_row['total'];
            $total_pages = ceil($total_records / $items_per_page);

            // Main query with LIMIT
            $result = $conn->query("SELECT * FROM product WHERE quantity > 0 ORDER BY item LIMIT $items_per_page OFFSET $offset");
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="product-card" data-name="<?php echo htmlspecialchars(strtolower($row['item'])); ?>" 
                                       data-category="<?php echo htmlspecialchars(strtolower($row['category'])); ?>">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" class="product-image" alt="<?php echo htmlspecialchars($row['item']); ?>" onerror="this.src='default-product-image.jpg'">
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
        </div>

        <!-- Entries info -->
        <div style="background: white; padding: 15px; border-radius: 5px; margin-top: 20px;">
            <div style="float: left;">
                <?php
                $start = ($total_records == 0) ? 0 : $offset + 1;
                $end = min($offset + $items_per_page, $total_records);
                ?>
                Showing <?php echo $start; ?> to <?php echo $end; ?> of <?php echo $total_records; ?> entries
            </div>

            <!-- Pagination -->
            <div style="float: right;">
                <div class="pagination-numbers">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo ($page-1); ?>" class="paginate_button">Previous</a>
                    <?php endif; ?>

                    <?php
                    $start_page = max(1, $page - 2);
                    $end_page = min($total_pages, $page + 2);

                    for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" 
                           class="paginate_button <?php echo ($i == $page) ? 'current' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo ($page+1); ?>" class="paginate_button">Next</a>
                    <?php endif; ?>
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>

    <!-- Cart Panel -->
    <div class="cart-panel">
        <div class="cart-title">Shopping Cart</div>
        <div class="cart-items" id="cart-items">
            <!-- Cart items will be loaded here dynamically -->
        </div>
        <div class="cart-total" id="cart-total">
            Total: ₱0.00
        </div>
        <button onclick="processCheckout()" class="checkout-btn">Checkout</button>
    </div>
</div>

<script>
let cart = {};

// Function to update cart
async function updateCart(productId, change, maxStock) {
    try {
        const currentQty = cart[productId] || 0;
        const newQty = currentQty + change;
        
        console.log('Updating cart:', {
            productId,
            currentQty,
            change,
            newQty,
            maxStock
        });
        
        if (newQty < 0) {
            console.log('Quantity would be negative, aborting');
            return;
        }
        if (newQty > maxStock) {
            alert('Cannot exceed available stock');
            return;
        }
        
        const response = await fetch('update_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: newQty
            })
        });
        
        const data = await response.json();
        console.log('Server response:', data);
        
        if (data.success) {
            if (newQty === 0) {
                delete cart[productId];
            } else {
                cart[productId] = newQty;
            }
            document.getElementById(`qty-${productId}`).textContent = newQty;
            await updateCartDisplay();
        } else {
            alert(data.message || 'Error updating cart');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error updating cart. Please try again.');
    }
}

// Clean cart display function without debugging
async function updateCartDisplay() {
    try {
        const response = await fetch('get_cart.php');
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();
        
        const cartItems = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        
        if (!data.items || !Array.isArray(data.items)) {
            cartItems.innerHTML = '<div class="alert alert-warning">No items in cart</div>';
            cartTotal.textContent = 'Total: ₱0.00';
            return;
        }
        
        cartItems.innerHTML = '';
        let total = 0;
        
        data.items.forEach(item => {
            const itemTotal = item.quantity * item.price;
            total += itemTotal;
            
            cartItems.innerHTML += `
                <div class="cart-item">
                    <div>
                        <div>${item.item}</div>
                        <div>Qty: ${item.quantity} × ₱${parseFloat(item.price).toFixed(2)}</div>
                    </div>
                    <div>
                        ₱${itemTotal.toFixed(2)}
                        <button onclick="updateCart(${item.product_id}, -${item.quantity}, ${item.max_quantity})" 
                                class="btn btn-sm btn-danger">×</button>
                    </div>
                </div>
            `;
            
            const qtyDisplay = document.getElementById(`qty-${item.product_id}`);
            if (qtyDisplay) {
                qtyDisplay.textContent = item.quantity;
            }
            
            cart[item.product_id] = item.quantity;
        });
        
        cartTotal.textContent = `Total: ₱${total.toFixed(2)}`;
    } catch (error) {
        console.error('Error:', error);
        cartItems.innerHTML = '<div class="alert alert-danger">Error loading cart</div>';
    }
}

// Add this function to manually refresh cart
function refreshCart() {
    updateCartDisplay().catch(error => {
        console.error('Manual refresh failed:', error);
        alert('Failed to refresh cart');
    });
}

// Initialize cart on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartDisplay();
    // Refresh cart every 30 seconds
    setInterval(updateCartDisplay, 30000);
});

document.getElementById('productSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    if (searchTerm.length > 0) {
        // Hide pagination when searching
        document.querySelector('.pagination-numbers').style.display = 'none';
    } else {
        // Show pagination when search is cleared
        document.querySelector('.pagination-numbers').style.display = 'inline-block';
        // Reset to first page
        window.location.href = '?page=1';
    }
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const name = product.getAttribute('data-name');
        const category = product.getAttribute('data-category');
        
        if (name.includes(searchTerm) || category.includes(searchTerm)) {
            product.style.display = '';
        } else {
            product.style.display = 'none';
        }
    });
});

// Add this new function
async function processCheckout() {
    try {
        // Check if cart is empty
        const cartItems = document.getElementById('cart-items');
        if (!cartItems.children.length) {
            alert('Cart is empty');
            return;
        }

        // Show loading state
        const checkoutBtn = document.querySelector('.checkout-btn');
        const originalText = checkoutBtn.textContent;
        checkoutBtn.textContent = 'Processing...';
        checkoutBtn.disabled = true;

        // First, save to cart database
        const response = await fetch('save_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Clear the local cart object
            cart = {};
            // Update the display
            await updateCartDisplay();
            // Redirect to purchase1.php
            window.location = 'purchase1.php';
        } else {
            alert('Error processing checkout: ' + result.message);
        }
    } catch (error) {
        console.error('Checkout error:', error);
        alert('Error processing checkout. Please try again. Details: ' + error.message);
    } finally {
        // Reset button state
        const checkoutBtn = document.querySelector('.checkout-btn');
        checkoutBtn.textContent = 'Checkout';
        checkoutBtn.disabled = false;
    }
}
</script>


