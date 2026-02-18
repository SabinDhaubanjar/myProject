<?php
   
    $page = isset($_GET['page'])? $_GET['page']:'dashboard';
?>

<html>
    <head>
        <title>
        admin dashboard
        </title>
        <style>
            .container{
                display:flex;
                padding:20px;
                
            }
            .side_bar{
                width:150px;
                height: 500px;
                background-color: #3e73a8;
            }

            .side_bar ul{
                padding: 0;
            }
            .side_bar ul li a{
                color: #9ea5c4;
                text-decoration: none;
            }
            .side_bar li{
                text-align: left;
            }
            .side_bar ul li:hover
            {
               background-color: #1c3f63;
            }
            .dashboard{
                 display: flex;
                 padding: 20px;
                justify-content: space-between;
                
            }
            .content{
                width: 100%;
            }
            .del_btn
            {
                background:red;
                padding:7px;
                border-radius: 10px;
                color: white;
            }
            
                table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
            
            

        </style>
    </head>
    <body>
        <div class="header">Header</div>

        <div class="container">
            <div class="side_bar">
                <h2>Admin</h2>
                <ul type="none">
                <li ><a href="admin_dashboard.php?page=dashboard">Dashboard</a></li>
                <li ><a href="admin_dashboard.php?page=product">Products</a></li>
                <li ><a href="admin_dashboard.php?page=user">Users</a></li>
                <li ><a href="admin_dashboard.php?page=admin_seller">Sellers</a></li>
              
                </ul>

            </div>
            <div class="content">

            <h2>Welcome back,Administrator!</h2>
               
               <?php if($page=="dashboard"){
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
            echo "Page not found";
        }
                ?>
            </div>
        </div>

       <!-- <div class="footer">footer</div> -->
    </body>
</html>
    

                 