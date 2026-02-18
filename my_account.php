<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "test");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, dob, gender FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Market Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 36px;
        }

        .nav {
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
            margin-right: 20px;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
        }

        .account-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .account-card h2 {
            color: #667eea;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .info-row {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #2d3748;
            width: 200px;
        }

        .info-value {
            color: #718096;
            flex: 1;
        }

        .welcome-message {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }

        .welcome-message h2 {
            margin-bottom: 10px;
        }

        .actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 30px;
        }

        .action-btn {
             padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .action-btn.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .action-btn.secondary {
            background: #f7fafc;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        @media (max-width: 600px) {
            .actions {
                grid-template-columns: 1fr;
            }

            .info-row {
                flex-direction: column;
            }

            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
<div class="header">
    <h1>My Account</h1>
</div>

<div class="nav">
    <a href="homePage.php">← Back to Home</a>
    <a href="seller.php">Seller Dashboard</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <div class="welcome-message">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
        <p>Manage your account information and settings</p>
    </div>

    <div class="account-card">
        <h2>Account Information</h2>
        
        <div class="info-row">
            <div class="info-label">Username:</div>
            <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Date of Birth:</div>
            <div class="info-value"><?php echo htmlspecialchars($user['dob']); ?></div>
        </div>

        <div class="info-row">
            <div class="info-label">Gender:</div>
            <div class="info-value"><?php echo htmlspecialchars(ucfirst($user['gender'])); ?></div>
        </div>

        <div class="actions">
            <a href="homePage.php" class="action-btn primary">Continue Shopping</a>
            <a href="seller.php" class="action-btn secondary">Become a Seller</a>
        </div>
    </div>
</div>

</body>
</html>