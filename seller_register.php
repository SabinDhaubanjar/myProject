<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data from POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shop_name = $_POST['shop_name'];
    $owner_name = $_POST['owner_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM sellers WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>
            alert('Email already registered as seller! Please use a different email.');
            window.location.href = 'seller_register.html';
        </script>";
        exit();
    }
    $check_stmt->close();

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO sellers (shop_name, owner_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $shop_name, $owner_name, $email, $phone, $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>
            alert('Seller registration successful! Please login.');
            window.location.href = 'seller_login.html';
        </script>";
    } else {
        echo "<script>
            alert('Error: " . $stmt->error . "');
            window.location.href = 'seller_register.html';
        </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>