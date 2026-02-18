<?php
// product.php - Display all products

// Connect to database
$conn = new mysqli("localhost", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM products WHERE id = $delete_id");
    echo "<script>alert('Product deleted successfully!'); window.location.href='admin_dashboard.php?page=product';</script>";
}

// Get all products
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<div class="content-card">
    <h3>Manage Products</h3>
    
    <?php if($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Added On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <img src="<?php echo $row['image']; ?>" alt="Product" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                    </td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>₹<?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars(substr($row['description'], 0, 50)) . '...'; ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <button class="action-btn btn-edit" onclick="alert('Edit product')">Edit</button>
                        <button class="del_btn" onclick="if(confirm('Are you sure you want to delete this product?')) window.location.href='admin_dashboard.php?page=product&delete_id=<?php echo $row['id']; ?>'">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; padding: 40px; color: #718096;">No products found.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>