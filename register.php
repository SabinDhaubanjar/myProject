<?php

use Joomla\CMS\Date\Date;

session_start();
// Connect to the database
$servername = "localhost:3307";
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

    if(empty($username)|| strlen($username)<5||!preg_match("/^[a-zA-Z0-9_ ]{5,20}$/",$username)){
        $_SESSION['username_error']="username must be atleast 5 characters upto 20 and contain letters,numbers, and _";
       header("Location: registration.php");
        exit();
    }
   
    if(empty($email)||!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $_SESSION['email_error']="invalid email format.";
        header("Location: registration.php");
        exit();
    }
    if(empty($password)|| strlen($password)<8){
        $_SESSION['pass_err']="password must contain atleat 8 characters";
          header("Location: registration.php");
    exit();
    }
  
    $currentTime= Date('d-m-h');
    if($currentTime<$dob){
        $_SESSION['dob_err']="Are you sure.. You were born in the future :)";
        header("Location: registration.php");
    exit();
    }
    // elseif(!preg_match("/^*[a-zA-Z]/",$pasword)){}
    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>
            alert('Email already registered! Please use a different email.');
            window.location.href = 'registration.php';
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
    // if ($stmt->execute()) {
    //     // echo "<script>
    //     //     alert('Registration successful! Please login.');
    //     //     window.location.href = 'login.html';
    //     // </script>";
    //     header("Location:login.html");
    // } else {
    //     // echo "<script>
    //     //     alert('Error: " . $stmt->error . "');
    //     //     window.location.href = 'registration.php';
    //    // </script>";
    //    header("Location:registration.php");
    // }
    if ($stmt->execute()) {
    // Redirect to login page
    header("Location: login.html");
    exit();
} else {
    $_SESSION['reg_error'] = "Error: " . $stmt->error;
    header("Location: registration.php");
    exit();
}


    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
