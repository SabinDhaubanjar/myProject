<?php 
 session_start();
 $conn=mysqli_connect("localhost:3307","root","","test");
    if(!$conn){
        die("connection failed");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
     $f_email=$_POST['smail'];
     $p = $_POST['spass'];

            $sql="select * from sellers where email= '$f_email'";
            $res=mysqli_query($conn,$sql);
           
            if($res && mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);
                    

                    if($f_email==$row['email']){
                            $s_email=$row['email'];
                            $hashed_password = password_hash($p, PASSWORD_DEFAULT);
                         $update_pass="update sellers set password ='$hashed_password' where email= '$f_email'";

                         $update_res=mysqli_query($conn,$update_pass);

                         if($update_res){
                            // $_SESSION['seller_id'] = $row['id'];
                            //     $_SESSION['shop_name'] = $row['shop_name'];
                            //     $_SESSION['owner_name'] = $row['owner_name'];
                             header("Location: seller_login.html"); // go to login
                             exit();
                         }
                         else{
                            echo 'failed to changed. Try again';
                         }
                    }
                    else{
                        echo "email not found";
                    }
                }

   }

?>
<body>
<form method="post" action="seller_forget_pass.php">
    <label>Email </label><br><br><input type="email" name="smail" placeholder="Enter  email "><br><br>
     <label>New Password </label><br><br><input type="password" name="spass" placeholder="Enter your new password "><br><br>
    <button type="submit">Continue</button>
</form>

</body>