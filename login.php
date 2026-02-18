<?php
session_start();



// Database connection
$conn = new mysqli("localhost:3307", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    // Check if email exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Login success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            echo "<script>
                alert('Login successful!');
                window.location.href = 'homePage.php';
            </script>";
            exit();
        } else {
            // Wrong password
            echo "<script>
                alert('Incorrect password!');
                window.location.href = 'login.html';
            </script>";
        }
    } else {
        // Email not found
        echo "<script>
            alert('Account not found! Please register first.');
            window.location.href = 'registration.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>