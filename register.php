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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>
            alert('Email already registered! Please use a different email.');
            window.location.href = 'register.html';
        </script>";
        exit();
    }
    $check_stmt->close();

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, dob, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $hashed_password, $dob, $gender);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>
            alert('Registration successful! Please login.');
            window.location.href = 'login.html';
        </script>";
    } else {
        echo "<script>
            alert('Error: " . $stmt->error . "');
            window.location.href = 'register.html';
        </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>