<?php
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
  </div>
</div>

<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h3>Menu</h3>
  </div>
  <ul class="sidebar-menu">
    <li class="active">
      <span class="icon">🏠</span>
      <span>Home</span>
    </li>
    <li>
      <span class="icon">📦</span>
      <span>My Orders</span>
    </li>
    <li>
      <span class="icon">❤️</span>
      <span>Wishlist</span>
    </li>
    <li>
      <span class="icon">👤</span>
      <span>My Account</span>
    </li>
    <li>
      <span class="icon">🔔</span>
      <span>Notifications</span>
    </li>
    <li>
      <span class="icon">💳</span>
      <span>Payment Methods</span>
    </li>
    <li>
      <span class="icon">ℹ️</span>
      <span>About Us</span>
    </li>
    <li>
      <span class="icon">📞</span>
      <span>Contact</span>
    </li>
    <li>
      <span class="icon">❓</span>
      <span>Help & FAQ</span>
    </li>
  </ul>
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
              <button class="carousel-shop-btn">Shop Now</button>
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

  <div class="featured-product">
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
              <button class="buy-now">Add to Cart</button>
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
// Sidebar Toggle
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('active');
}

// Close sidebar when clicking outside
document.addEventListener('click', function(event) {
  const sidebar = document.getElementById('sidebar');
  const hamburger = document.querySelector('.hamburger-menu');
  
  if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
    sidebar.classList.remove('active');
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
</script>

</body>
</html>