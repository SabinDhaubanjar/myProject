 <?php 
 $conn=mysqli_connect("localhost:3307","root","","test");
    if(!$conn){
        die("connection failed");
    }

    $sql="select count(*) as total_user from users";
    $u_res=mysqli_query($conn,$sql);
    if($u_res){
        while($row=mysqli_fetch_assoc($u_res)){
            $u_total=$row['total_user'];
        }
    }
    $sql="select count(*) as total_products from products";
     $p_res=mysqli_query($conn,$sql);
    if($p_res){
        while($row=mysqli_fetch_assoc($p_res)){
            $p_total=$row['total_products'];
        }
    }
    $sql="select count(*) as total_sellers from sellers";
     $s_res=mysqli_query($conn,$sql);
    if($s_res){
        while($row=mysqli_fetch_assoc($s_res)){
            $s_total=$row['total_sellers'];
        }
    }
    
    
    ?>
    <div class="dashboard">

        <div style="border: 1px solid black;">
    <h4>users 👥</h4>
    <?php  echo $u_total ?>
    </div>

     <div style="border: 1px solid black;">
    <h5>sellers 👥🧍🏽‍♀️</h5>
    <?php  echo $s_total ?>
     </div>

     <div style="border: 1px solid black;">
    <h5>Products 🛒🛍️✨</h5>
    <?php  echo $p_total ?>
</div>

</div>
