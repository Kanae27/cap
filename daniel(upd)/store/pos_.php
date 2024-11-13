<?php include('./header.php'); ?>

<style>
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
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
            $result = $conn->query("SELECT * FROM product WHERE quantity > 0");
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="product-card" data-name="<?php echo strtolower($row['item']); ?>" 
                                       data-category="<?php echo strtolower($row['category']); ?>">
                    <img src="<?php echo $row['image']; ?>" class="product-image" alt="<?php echo $row['item']; ?>">
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
        <button onclick="window.location='purchase1.php'" class="checkout-btn">Checkout</button>
    </div>
</div>

<script>
let cart = {};

// Function to update cart
async function updateCart(productId, change, maxStock) {
    const currentQty = cart[productId] || 0;
    const newQty = currentQty + change;
    
    // Check boundaries
    if (newQty < 0 || newQty > maxStock) return;
    
    try {
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
        
        if (data.success) {
            // Update local cart
            if (newQty === 0) {
                delete cart[productId];
            } else {
                cart[productId] = newQty;
            }
            
            // Update display
            document.getElementById(`qty-${productId}`).textContent = newQty;
            updateCartDisplay();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error updating cart');
    }
}

// Function to update cart display
function updateCartDisplay() {
    fetch('get_cart.php')
        .then(response => response.json())
        .then(data => {
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');
            
            cartItems.innerHTML = '';
            let total = 0;
            
            data.items.forEach(item => {
                const itemTotal = item.quantity * item.price;
                total += itemTotal;
                
                cartItems.innerHTML += `
                    <div class="cart-item">
                        <div>
                            <div>${item.item}</div>
                            <div>Qty: ${item.quantity}</div>
                        </div>
                        <div>
                            ₱${itemTotal.toFixed(2)}
                            <button onclick="updateCart(${item.product_id}, -${item.quantity}, ${item.max_quantity})" 
                                    class="btn btn-sm btn-danger">×</button>
                        </div>
                    </div>
                `;
                
                // Update quantity display
                const qtyDisplay = document.getElementById(`qty-${item.product_id}`);
                if (qtyDisplay) {
                    qtyDisplay.textContent = item.quantity;
                }
                
                // Update cart object
                cart[item.product_id] = item.quantity;
            });
            
            cartTotal.textContent = `Total: ₱${total.toFixed(2)}`;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading cart');
        });
}

// Load cart on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartDisplay();
});

document.getElementById('productSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
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
</script>


