<?php
// user.php - Display all users

// Connect to database
$conn = new mysqli("localhost", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM users WHERE id = $delete_id");
    echo "<script>alert('User deleted successfully!'); window.location.href='admin_dashboard.php?page=user';</script>";
}

// Get all users
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<div class="content-card">
    <h3>Manage Users</h3>
    
    <?php if($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Registered On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['dob']); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($row['gender'])); ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <button class="action-btn btn-view" onclick="alert('View user details')">View</button>
                        <button class="del_btn" onclick="if(confirm('Are you sure you want to delete this user?')) window.location.href='admin_dashboard.php?page=user&delete_id=<?php echo $row['id']; ?>'">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; padding: 40px; color: #718096;">No users found.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>