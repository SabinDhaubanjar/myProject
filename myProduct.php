<?php 

 $page = isset($_GET['page'])?$_GET['page']:'';
    $conn=mysqli_connect("localhost","root","","test");
    if(!$conn){
        die("connection failed");
    }
  $res=null;
   if (isset($_SESSION['seller_id'])) {
    $s_id=$_SESSION['seller_id'];
   }
   if(isset($_GET['page'])){
    $page = $_GET['page'];

   }
    if($page == "myProduct"){
        $query = "SELECT * FROM products WHERE seller_id = $s_id";
        $res = mysqli_query($conn, $query);
    }
    
   
?>

<body>
    <?php     if($res && (mysqli_num_rows($res)>0)){
     ?>

    <h3>Products Details</h3>
    <a href="add_product.html">Add product</a>
<table>
    <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Product Image</th>
        <th>Price</th>
        <th>Description</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>
    <?php  
    if($res){
        while($row=mysqli_fetch_assoc($res)){
            ?>
             <tr class="display">
                <td ><?php echo $row['id']; ?> </td>
                <td ><?php echo $row['name']; ?></td>
                <td><img src="<?php echo $row['image']; ?> " height="70px" width="70px" ></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><a class='update_btn' href='update_sellers_products.php?id= 
    <?php echo $row['id'] ?>' >update </a> </td>
     <td><a onclick="return  confirm('Are you sure you want to delete??');" class='del_btn' href='myproduct.php?id= 
    <?php echo $row['id'] ?>' >delete </a> </td>
             </tr>

            <?php
        }
    } 
    ?>
    <?php } 
    else{
            echo "You have not added any product yet. "; 
            ?>
            <a href="add_product.html"> Click here to add a new product</a>
            <?php
        }
        ?>
    </table>

</body>   