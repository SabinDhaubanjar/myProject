<?php
// admin_seller.php - Display all sellers

// Connect to database
$conn = new mysqli("localhost", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM sellers WHERE id = $delete_id");
    echo "<script>alert('Seller deleted successfully!'); window.location.href='admin_dashboard.php?page=admin_seller';</script>";
}

// Get all sellers
$result = $conn->query("SELECT * FROM sellers ORDER BY id DESC");
?>

<div class="content-card">
    <h3>Manage Sellers</h3>
    
    <?php if($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Shop Name</th>
                    <th>Owner Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Registered On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['shop_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['owner_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <button class="action-btn btn-view" onclick="alert('View seller details')">View</button>
                        <button class="del_btn" onclick="if(confirm('Are you sure you want to delete this seller?')) window.location.href='admin_dashboard.php?page=admin_seller&delete_id=<?php echo $row['id']; ?>'">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; padding: 40px; color: #718096;">No sellers found.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>