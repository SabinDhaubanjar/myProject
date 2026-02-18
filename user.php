 <?php 
 $conn=mysqli_connect("localhost:3307","root","","test");
    if(!$conn){
        die("connection failed");
    }


    if(isset($_GET['id'])){
        $p_id=$_GET['id'];
        $del="delete from users where id=$p_id";
        $del_res=mysqli_query($conn,$del);
        header("Location: admin_dashboard.php?page=user");
    }
   
    $sql="select *  from users";
    $ress=mysqli_query($conn,$sql);
    
    ?>
    <h2>User Management</h2>
    <table border="1">
 <tr>
    <th>id</th>
    <th>username</th>
    <th>email</th>
    <th>Date Of Birth</th>
    <th>Gender</th>
    <th>Created At</th>
    <th>Delete </th>
 </tr>
 <?php
 if($ress){
        while($row=mysqli_fetch_assoc($ress)){
            ?>
           <tr>
    <td>
         <?php echo $row['id'] ?>
    </td>
    <td>
         <?php echo  $row['username'] ?>
    </td>
    <td>
         <?php echo  $row['email'] ?>
    </td>
    <td>
         <?php echo  $row['dob'] ?>
    </td>
    <td>
         <?php echo  $row['gender'] ?>
    </td>
    <td>
         <?php echo  $row['created_at'] ?>
    </td>
    <td><a onclick="return  confirm('Are you sure you want to delete??');" class='del_btn' href='user.php?id= 
    <?php echo $row['id'] ?>' >delete </a> </td>
</tr>
<?php
        }
    }
 ?>

</table>

    
