 <?php 
// session_start();
 $conn=mysqli_connect("localhost:3307","root","","test");
    if(!$conn){
        die("connection failed");
    }

//  if (!isset($_SESSION['seller_id'])) {
//     die("You must log in first.");
// }
if(isset($_GET['id'])){
    $seller_id = $_GET['id'];

    // Delete seller's products first
    $del_prod = "DELETE FROM products WHERE seller_id = $seller_id";
    mysqli_query($conn, $del_prod);

    // Delete seller
    $del_seller = "DELETE FROM sellers WHERE id = $seller_id";
    mysqli_query($conn, $del_seller);
}

    $sql="select * from sellers";
    $res=mysqli_query($conn,$sql);

    
           ?>
           <h2>Seller Management</h2>
              <table border="1">
 <tr>

    <th>id</th>
    <th>shop_name</th>
    <th>owner_name</th>
    <th>email</th>
    <th>number</th>
    <th>delete</th>
 </tr>
 <?php
 if($res){
        while($row=mysqli_fetch_assoc($res)){
            ?>
           <tr>
    <td>
         <?php echo $row['id'] ?>
    </td>
    <td>
         <?php echo  $row['shop_name'] ?>
</td>
    <td>
         <?php echo  $row['owner_name'] ?>
    </td>
     <td>
         <?php echo  $row['email'] ?>
    </td>
    <td>
         <?php echo  $row['phone'] ?>
    </td>
    <td><a onclick="return  confirm('Are you sure you want to delete??');" class='del_btn' href='admin_seller.php?id= 
    <?php echo $row['id'] ?>' >delete </a> </td>
</tr>
<?php
        }
    }

 ?>

</table>

    
