<?php
session_start();

// Check if admin is logged in (you can add admin authentication later)
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: admin_login.html");
//     exit();
// }

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Market Hub</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            color: #2d3748;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            color: white;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-left h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logout-btn {
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Container */
        .container {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        /* Sidebar */
        .side_bar {
            width: 250px;
            background-color: white;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
            position: fixed;
            left: 0;
            top: 70px;
            bottom: 0;
            overflow-y: auto;
            padding: 20px 0;
        }

        .side_bar h2 {
            padding: 0 20px 20px 20px;
            color: #2d3748;
            font-size: 20px;
            border-bottom: 2px solid #e2e8f0;
        }

        .side_bar ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .side_bar ul li {
            margin: 0;
        }

        .side_bar ul li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 25px;
            text-decoration: none;
            color: #2d3748;
            font-weight: 500;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .side_bar ul li a:hover {
            background-color: rgba(102, 126, 234, 0.05);
            border-left-color: #667eea;
            padding-left: 30px;
        }

        .side_bar ul li a.active {
            background: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, transparent 100%);
            border-left-color: #667eea;
            color: #667eea;
            font-weight: 600;
        }

        .icon {
            font-size: 20px;
        }

        /* Content */
        .content {
            margin-left: 250px;
            flex: 1;
            padding: 30px;
        }

        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            border-radius: 15px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .welcome-card h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .welcome-card p {
            opacity: 0.9;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #f7fafc;
        }

        /* Delete Button */
        .del_btn {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s;
        }

        .del_btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 101, 101, 0.4);
        }

        /* Action Buttons */
        .action-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s;
            margin-right: 5px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
        }

        .btn-view {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            color: #718096;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-card .icon {
            font-size: 40px;
            float: right;
            opacity: 0.2;
        }

        /* Content Card */
        .content-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .content-card h3 {
            font-size: 24px;
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .side_bar {
                width: 200px;
            }

            .content {
                margin-left: 200px;
                padding: 20px;
            }

            .header {
                padding: 0 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .side_bar {
                position: fixed;
                left: -250px;
                width: 250px;
                transition: left 0.3s;
                z-index: 999;
            }

            .side_bar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
                padding: 15px;
            }

            .header-left h1 {
                font-size: 18px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>🛡️ Admin Dashboard</h1>
        </div>
        <div class="header-right">
            <div class="admin-info">
                <span>👤 Administrator</span>
            </div>
            <button class="logout-btn" onclick="window.location.href='admin_logout.php'">Logout</button>
        </div>
    </div>

    <!-- Container -->
    <div class="container">
        <!-- Sidebar -->
        <div class="side_bar">
            <h2>Navigation</h2>
            <ul>
                <li>
                    <a href="admin_dashboard.php?page=dashboard" class="<?php echo $page == 'dashboard' ? 'active' : ''; ?>">
                        <span class="icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="admin_dashboard.php?page=product" class="<?php echo $page == 'product' ? 'active' : ''; ?>">
                        <span class="icon">📦</span>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="admin_dashboard.php?page=user" class="<?php echo $page == 'user' ? 'active' : ''; ?>">
                        <span class="icon">👥</span>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="admin_dashboard.php?page=admin_seller" class="<?php echo $page == 'admin_seller' ? 'active' : ''; ?>">
                        <span class="icon">🏪</span>
                        <span>Sellers</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="welcome-card">
                <h2>Welcome back, Administrator!</h2>
                <p>Manage your marketplace efficiently from this dashboard</p>
            </div>

            <?php 
            if($page == "dashboard"){
                include('dashboard.php');
            }
            elseif($page == "user"){
                include("user.php");
            }
            elseif($page == "product"){
                include("product.php");
            }
            elseif($page == "admin_seller"){
                include("admin_seller.php");
            }
            else{
                echo '<div class="content-card"><h3>Page not found</h3><p>The requested page does not exist.</p></div>';
            }
            ?>
        </div>
    </div>

</body>
</html>