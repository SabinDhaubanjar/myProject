 <?php 
 session_start();
 $conn=mysqli_connect("localhost:3307","root","","test");
    if(!$conn){
        die("connection failed");
    }
    
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $del_sql="delete from products where  id= $id";
          $del_res = mysqli_query($conn, $del_sql);
          if($del_res){
            header("Location:admin_dashboard.php?page=admin_seller");
          }
    }
   

    $sql="select * from products";
    $res=mysqli_query($conn,$sql);
    
            ?>
            <h2>product Management</h2>
            <table style="
            border:1px solid black;
            ">
                <tr>
                    <th>Product Id</th>
                    <th>Product Namee</th>
                    <th>product Image</th>
                    <th>product Price</th>
                    <th>Product Description</th>
                    <th>Date and Time</th>
                    <th>Seller_id</th>
                    <th>delete product</th>
                </tr>
                <?php if($res){

        while($row=mysqli_fetch_assoc($res)){
             
               ?>
                    <td>
                        <?php echo $row['id']?>
                    </td>
                    <td>
                        <?php echo $row['name'] ?>
                    </td>
                    <td>
                       <img  width="100" src="<?php echo $row['image']  ?>"> 
                    </td>
                    <td>
                         <?php echo $row['price']?>
                    </td>
                    <td>
                        <?php echo $row['description']?>
                    </td>
                    <td>
                        <?php echo $row['created_at']?>
                    </td>
                    <td>
                        <?php echo $row['seller_id']?>
                    </td>
                     <td>
                       
                     <a onclick="return confirm('Are you sure you want to delete');" class='del_btn' href='product.php?id=<?php echo $row['id']?>'>delete</a>
                     </td>
                </tr>
                <?php
                }
                }
                
                ?>
            </table>