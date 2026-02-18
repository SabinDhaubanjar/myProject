<?php 
session_start();
$conn = mysqli_connect("localhost", "root", "", "test");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

$error_message = "";
$success_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $f_email = mysqli_real_escape_string($conn, $_POST['smail']);
    $p = $_POST['spass'];

    $sql = "SELECT * FROM sellers WHERE email = '$f_email'";
    $res = mysqli_query($conn, $sql);
   
    if($res && mysqli_num_rows($res) > 0){
        $row = mysqli_fetch_assoc($res);
        
        if($f_email == $row['email']){
            $hashed_password = password_hash($p, PASSWORD_DEFAULT);
            $update_pass = "UPDATE sellers SET password = '$hashed_password' WHERE email = '$f_email'";

            $update_res = mysqli_query($conn, $update_pass);

            if($update_res){
                echo "<script>
                    alert('Password changed successfully! Please login with your new password.');
                    window.location.href = 'seller_login.html';
                </script>";
                exit();
            }
            else{
                $error_message = "Failed to change password. Please try again.";
            }
        }
        else{
            $error_message = "Email not found.";
        }
    }
    else{
        $error_message = "Email not found. Please check and try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Seller - Market Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #718096;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 500;
            font-size: 14px;
        }

        input[type="email"], 
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
            background-color: #f7fafc;
            color: #2d3748;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        input::placeholder {
            color: #a0aec0;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
            margin-top: 20px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fee;
            color: #c53030;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #fc8181;
        }

        .success-message {
            background: #efe;
            color: #2f855a;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #68d391;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #e2e8f0;
        }

        .divider span {
            background-color: white;
            padding: 0 15px;
            color: #a0aec0;
            font-size: 13px;
            position: relative;
            z-index: 1;
        }

        .info-box {
            background: #ebf4ff;
            border-left: 4px solid #4299e1;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box p {
            color: #2c5282;
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 550px) {
            .container {
                padding: 30px 25px;
            }

            h2 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Reset Password</h2>
    <p class="subtitle">Enter your email and new password for your seller account</p>
    
    <?php if($error_message): ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <?php if($success_message): ?>
        <div class="success-message">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <div class="info-box">
        <p>💡 <strong>Tip:</strong> Choose a strong password with at least 8 characters including letters and numbers.</p>
    </div>
    
    <form method="POST" action="seller_forget_pass.php">
        <div class="form-group">
            <label for="smail">Email Address</label>
            <input type="email" id="smail" name="smail" placeholder="Enter your registered email" required>
        </div>

        <div class="form-group">
            <label for="spass">New Password</label>
            <input type="password" id="spass" name="spass" placeholder="Enter your new password" required minlength="6">
        </div>

        <button type="submit">Reset Password</button>
    </form>

    <div class="divider">
        <span>OR</span>
    </div>

    <div class="back-link">
        <a href="seller_login.html">← Back to Login</a>
    </div>
</div>

</body>
</html>