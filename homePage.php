<?php
session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$conn = new mysqli("localhost", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);

// Fetch products for carousel
$carousel_sql = "SELECT * FROM products ORDER BY id DESC LIMIT 5";
$carousel_result = $conn->query($carousel_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Market Hub - Your Shopping Destination</title>
  <link rel="stylesheet" href="styles/homePage.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<div class="header">
  <div class="left-section">
    <button class="hamburger-menu" onclick="toggleSidebar()">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <img src="images/sample-logo-white.png" alt="Logo" class="logo">
  </div>

  <div class="middle-section">
    <input type="text" class="search-bar" placeholder="Search products...">
    <button class="search-button">
      <img src="images/icons/search-icon.png" class="search-icon">
    </button>
  </div>

  <div class="right-section">
    <p>Products</p>
    <p>Best Deals</p>
    <p>New Releases</p>
    <button class="cart-button" onclick="toggleCart()">
      🛒 Cart <span class="cart-count" id="cart-count">0</span>
    </button>
  </div>
</div>

<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h3>Menu</h3>
  </div>
  <ul class="sidebar-menu">
    <li class="active" onclick="window.location.href='homePage.php'">
      <span class="icon">🏠</span>
      <span>Home</span>
    </li>
    <li onclick="showMyOrders()">
      <span class="icon">📦</span>
      <span>My Orders</span>
    </li>
    <li onclick="checkLoginAndRedirect('my_account.php')">
      <span class="icon">👤</span>
      <span>My Account</span>
    </li>
    <li onclick="window.location.href='about.html'">
      <span class="icon">ℹ️</span>
      <span>About Us</span>
    </li>
    <li onclick="window.location.href='contact.html'">
      <span class="icon">📞</span>
      <span>Contact</span>
    </li>
    <li onclick="window.location.href='faq.html'">
      <span class="icon">❓</span>
      <span>Help & FAQ</span>
    </li>
    <?php if(isset($_SESSION['user_id'])): ?>
    <li onclick="window.location.href='logout.php'">
      <span class="icon">🚪</span>
      <span>Logout</span>
    </li>
    <?php else: ?>
    <li onclick="window.location.href='login.html'">
      <span class="icon">🔑</span>
      <span>Login</span>
    </li>
    <?php endif; ?>
  </ul>
</div>

<!-- Cart Sidebar -->
<div class="cart-sidebar" id="cart-sidebar">
  <div class="cart-header">
    <h3>🛒 Shopping Cart</h3>
    <button class="close-cart" onclick="toggleCart()">✕</button>
  </div>
  <div class="cart-items" id="cart-items">
    <!-- Cart items will be added here dynamically -->
  </div>
  <div class="cart-footer">
    <div class="cart-total">
      <span>Total:</span>
      <span id="cart-total">₹0.00</span>
    </div>
    <button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
  </div>
</div>

<!-- My Orders Modal -->
<div class="orders-modal" id="orders-modal">
  <div class="orders-content">
    <div class="orders-header">
      <h2>My Orders</h2>
      <button class="close-modal" onclick="closeOrdersModal()">✕</button>
    </div>
    <div class="orders-list" id="orders-list">
      <!-- Orders will be displayed here -->
    </div>
  </div>
</div>

<div class="content">

  <!-- Carousel Section -->
  <div class="carousel-container">
    <div class="carousel">
      <?php if ($carousel_result->num_rows > 0): ?>
        <?php $index = 0; ?>
        <?php while ($carousel_row = $carousel_result->fetch_assoc()): ?>
          <div class="carousel-slide <?php echo $index === 0 ? 'active' : ''; ?>">
            <img src="<?php echo $carousel_row['image']; ?>" alt="<?php echo htmlspecialchars($carousel_row['name']); ?>">
            <div class="carousel-caption">
              <h2><?php echo htmlspecialchars($carousel_row['name']); ?></h2>
              <p>₹<?php echo htmlspecialchars($carousel_row['price']); ?></p>
              <button class="carousel-shop-btn" onclick="scrollToProducts()">Shop Now</button>
            </div>
          </div>
          <?php $index++; ?>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
    
    <button class="carousel-btn prev" onclick="moveSlide(-1)">❮</button>
    <button class="carousel-btn next" onclick="moveSlide(1)">❯</button>
    
    <div class="carousel-dots">
      <?php 
      $carousel_result->data_seek(0);
      $dot_index = 0;
      while ($carousel_result->fetch_assoc()): 
      ?>
        <span class="dot <?php echo $dot_index === 0 ? 'active' : ''; ?>" onclick="currentSlide(<?php echo $dot_index; ?>)"></span>
        <?php $dot_index++; ?>
      <?php endwhile; ?>
    </div>
  </div>

  <div class="featured-product" id="products-section">
    <p class="featured-product-section">Featured Products</p>

    <div class="product-grid">
      <?php 
      $result->data_seek(0);
      if ($result->num_rows > 0): 
      ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="product-column">
            <div class="product-image">
              <img src="<?php echo $row['image']; ?>" alt="Product Image" class="product-img">
            </div>
            <div class="product-info">
              <h2><?php echo htmlspecialchars($row['name']); ?></h2>
              <p><?php echo htmlspecialchars($row['description']); ?></p>
              <p class="price">₹<?php echo htmlspecialchars($row['price']); ?></p>
              <button class="buy-now" onclick='addToCart(<?php echo json_encode($row); ?>)'>Add to Cart</button>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No products found.</p>
      <?php endif; ?>
    </div>

  </div>
</div>

<script>
// Check if user is logged in before redirecting
function checkLoginAndRedirect(page) {
  <?php if(isset($_SESSION['user_id'])): ?>
    window.location.href = page;
  <?php else: ?>
    alert('Please login to access your account');
    window.location.href = 'login.html';
  <?php endif; ?>
}

// Cart functionality
let cart = [];

// Load cart from localStorage
function loadCart() {
  const savedCart = localStorage.getItem('cart');
  if (savedCart) {
    cart = JSON.parse(savedCart);
    updateCartUI();
  }
}

// Save cart to localStorage
function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

// Add to cart
function addToCart(product) {
  const existingItem = cart.find(item => item.id === product.id);
  
  if (existingItem) {
    existingItem.quantity++;
  } else {
    cart.push({
      id: product.id,
      name: product.name,
      price: product.price,
      image: product.image,
      quantity: 1
    });
  }
  
  saveCart();
  updateCartUI();
  showNotification('Product added to cart!');
}

// Remove from cart
function removeFromCart(productId) {
  cart = cart.filter(item => item.id !== productId);
  saveCart();
  updateCartUI();
}

// Update quantity
function updateQuantity(productId, change) {
  const item = cart.find(item => item.id === productId);
  if (item) {
    item.quantity += change;
    if (item.quantity <= 0) {
      removeFromCart(productId);
    } else {
      saveCart();
      updateCartUI();
    }
  }
}

// Update cart UI
function updateCartUI() {
  const cartCount = document.getElementById('cart-count');
  const cartItems = document.getElementById('cart-items');
  const cartTotal = document.getElementById('cart-total');
  
  // Update count
  const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
  cartCount.textContent = totalItems;
  
  // Update items
  if (cart.length === 0) {
    cartItems.innerHTML = '<div class="empty-cart">Your cart is empty</div>';
  } else {
    cartItems.innerHTML = cart.map(item => `
      <div class="cart-item">
        <img src="${item.image}" alt="${item.name}" class="cart-item-img">
        <div class="cart-item-info">
          <h4>${item.name}</h4>
          <p class="cart-item-price">₹${item.price}</p>
          <div class="quantity-controls">
            <button onclick="updateQuantity(${item.id}, -1)">-</button>
            <span>${item.quantity}</span>
            <button onclick="updateQuantity(${item.id}, 1)">+</button>
          </div>
        </div>
        <button class="remove-item" onclick="removeFromCart(${item.id})">✕</button>
      </div>
    `).join('');
  }
  
  // Update total
  const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
  cartTotal.textContent = `₹${total.toFixed(2)}`;
}

// Toggle cart
function toggleCart() {
  const cartSidebar = document.getElementById('cart-sidebar');
  cartSidebar.classList.toggle('active');
}

// Checkout
function checkout() {
  if (cart.length === 0) {
    alert('Your cart is empty!');
    return;
  }
  
  <?php if(isset($_SESSION['user_id'])): ?>
    // Save order to localStorage (simulating order placement)
    const orders = JSON.parse(localStorage.getItem('orders') || '[]');
    const order = {
      id: Date.now(),
      items: cart,
      total: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0),
      date: new Date().toISOString(),
      status: 'Processing'
    };
    orders.push(order);
    localStorage.setItem('orders', JSON.stringify(orders));
    
    // Clear cart
    cart = [];
    saveCart();
    updateCartUI();
    toggleCart();
    
    showNotification('Order placed successfully!');
  <?php else: ?>
    alert('Please login to place an order');
    window.location.href = 'login.html';
  <?php endif; ?>
}

// Show My Orders
function showMyOrders() {
  <?php if(isset($_SESSION['user_id'])): ?>
    const orders = JSON.parse(localStorage.getItem('orders') || '[]');
    const ordersList = document.getElementById('orders-list');
    const modal = document.getElementById('orders-modal');
    
    if (orders.length === 0) {
      ordersList.innerHTML = '<div class="no-orders">No orders yet. Start shopping!</div>';
    } else {
      ordersList.innerHTML = orders.reverse().map(order => `
        <div class="order-card">
          <div class="order-header">
            <h3>Order #${order.id}</h3>
            <span class="order-status ${order.status.toLowerCase()}">${order.status}</span>
          </div>
          <div class="order-date">${new Date(order.date).toLocaleDateString()}</div>
          <div class="order-items">
            ${order.items.map(item => `
              <div class="order-item">
                <img src="${item.image}" alt="${item.name}">
                <div>
                  <p><strong>${item.name}</strong></p>
                  <p>Qty: ${item.quantity} × ₹${item.price}</p>
                </div>
              </div>
            `).join('')}
          </div>
          <div class="order-total">Total: ₹${order.total.toFixed(2)}</div>
        </div>
      `).join('');
    }
    
    modal.classList.add('active');
  <?php else: ?>
    alert('Please login to view your orders');
    window.location.href = 'login.html';
  <?php endif; ?>
}

// Close orders modal
function closeOrdersModal() {
  document.getElementById('orders-modal').classList.remove('active');
}

// Show notification
function showNotification(message) {
  const notification = document.createElement('div');
  notification.className = 'notification';
  notification.textContent = message;
  document.body.appendChild(notification);
  
  setTimeout(() => {
    notification.classList.add('show');
  }, 10);
  
  setTimeout(() => {
    notification.classList.remove('show');
    setTimeout(() => notification.remove(), 300);
  }, 3000);
}

// Scroll to products
function scrollToProducts() {
  document.getElementById('products-section').scrollIntoView({ behavior: 'smooth' });
}

// Sidebar Toggle
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('active');
}

// Close sidebar when clicking outside
document.addEventListener('click', function(event) {
  const sidebar = document.getElementById('sidebar');
  const hamburger = document.querySelector('.hamburger-menu');
  const cartSidebar = document.getElementById('cart-sidebar');
  const cartButton = document.querySelector('.cart-button');
  
  if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
    sidebar.classList.remove('active');
  }
  
  if (!cartSidebar.contains(event.target) && !cartButton.contains(event.target)) {
    cartSidebar.classList.remove('active');
  }
});

// Carousel
let currentSlideIndex = 0;

function showSlide(index) {
  const slides = document.querySelectorAll('.carousel-slide');
  const dots = document.querySelectorAll('.dot');
  
  if (index >= slides.length) currentSlideIndex = 0;
  if (index < 0) currentSlideIndex = slides.length - 1;
  
  slides.forEach(slide => slide.classList.remove('active'));
  dots.forEach(dot => dot.classList.remove('active'));
  
  slides[currentSlideIndex].classList.add('active');
  dots[currentSlideIndex].classList.add('active');
}

function moveSlide(direction) {
  currentSlideIndex += direction;
  showSlide(currentSlideIndex);
}

function currentSlide(index) {
  currentSlideIndex = index;
  showSlide(currentSlideIndex);
}

// Auto-play carousel
setInterval(() => {
  currentSlideIndex++;
  showSlide(currentSlideIndex);
}, 5000);

// Load cart on page load
loadCart();
</script>

</body>
</html>