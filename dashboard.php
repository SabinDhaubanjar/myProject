<?php
// dashboard.php - Include file for admin dashboard

// Connect to database
$conn = new mysqli("localhost", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get statistics
$total_users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$total_sellers = $conn->query("SELECT COUNT(*) as count FROM sellers")->fetch_assoc()['count'];
$total_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];

$conn->close();
?>

<div class="stats-grid">
    <div class="stat-card">
        <span class="icon">👥</span>
        <h3>Total Users</h3>
        <div class="number"><?php echo $total_users; ?></div>
    </div>

    <div class="stat-card">
        <span class="icon">🏪</span>
        <h3>Total Sellers</h3>
        <div class="number"><?php echo $total_sellers; ?></div>
    </div>

    <div class="stat-card">
        <span class="icon">📦</span>
        <h3>Total Products</h3>
        <div class="number"><?php echo $total_products; ?></div>
    </div>

    <div class="stat-card">
        <span class="icon">💰</span>
        <h3>Total Revenue</h3>
        <div class="number">₹0</div>
    </div>
</div>

<div class="content-card">
    <h3>Quick Overview</h3>
    <p style="color: #718096; line-height: 1.8;">
        Welcome to the Market Hub Admin Dashboard. Here you can manage users, sellers, products, and monitor your marketplace performance. 
        Use the navigation menu on the left to access different sections.
    </p>
</div>