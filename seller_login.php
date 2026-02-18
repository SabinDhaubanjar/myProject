<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL
    $stmt = $conn->prepare("SELECT id, shop_name, owner_name, password FROM sellers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    // Check if email exists
    if ($result->num_rows === 1) {
        $seller = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $seller['password'])) {
            // Login success
            $_SESSION['seller_id'] = $seller['id'];
            $_SESSION['shop_name'] = $seller['shop_name'];
            $_SESSION['owner_name'] = $seller['owner_name'];

            echo "<script>
                alert('Login successful! Welcome to your dashboard.');
                window.location.href = 'seller.php';
            </script>";
            exit();
        } else {
            // Wrong password
            echo "<script>
                alert('Incorrect password!');
                window.location.href = 'seller_login.html';
            </script>";
        }
    } else {
        // Email not found
        echo "<script>
            alert('Seller account not found! Please register first.');
            window.location.href = 'seller_registration.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>