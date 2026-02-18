<?php 
session_start();
 $conn=mysqli_connect("localhost","root","","test");
    if(!$conn){
        die("connection failed");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
         

     $f_email=$_POST['mail'];
     $p = $_POST['pass'];

            $sql="select email from users where email= '$f_email'";
            $res=mysqli_query($conn,$sql);

            if($res && mysqli_num_rows($res)>0){
            $row=mysqli_fetch_assoc($res);
                    

                    if($f_email==$row['email']){
                            $u_email=$row['email'];
                            $hashed_password = password_hash($p, PASSWORD_DEFAULT);
                         $update_pass="update users set password ='$hashed_password' where email= '$u_email'";

                         $update_res=mysqli_query($conn,$update_pass);

                         if($update_res){
                            
                             header("Location:login.html"); // go to login
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
<form method="post" action="user_forget_pass.php">
    <label>Email </label><br><br><input type="email" name="mail" placeholder="Enter  email "><br><br>
     <label>New Password </label><br><br><input type="password" name="pass" placeholder="Enter your new password "><br><br>
    <button type="submit">Continue</button>
</form>

</body>