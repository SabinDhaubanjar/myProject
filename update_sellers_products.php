<?php
    
     $conn=mysqli_connect("localhost","root","","test");
    if(!$conn){
        die("connection failed");
    }

    if (isset($_GET['id'])) {
    $p_id=$_GET['id'];
    }

   if($_SERVER['REQUEST_METHOD']=="POST"){
    $des=$_POST['pdes']; 
   $name=$_POST['pname']; 
   $price=$_POST['pprice']; 

   

    if(!empty($_FILES['pimage']['name'])){

          $image_name = $_FILES['pimage']['name'];
    $tmp_name = $_FILES['pimage']['tmp_name'];

    $folder = "uploads/".$image_name;
    move_uploaded_file($tmp_name, $folder); 

    $query = "update products set name='$name', image='$folder',price= '$price', description='$des' WHERE id = $p_id";
    }
     else{
    $query = "UPDATE products 
                  SET name='$name',
                      price='$price',
                      description='$des'
                  WHERE id=$p_id";
   }

  
   $res = mysqli_query($conn, $query);
            header("Location:seller.php?page=myProduct");
            
   }
   

?>

 <h3>Update Details</h3>

<html>
    <body>

    <form method="post" action="update_sellers_products.php?id=<?php echo $p_id; ?>" enctype="multipart/form-data"
 >
 
        <input type="text" placeholder="enter product name" name="pname"><br><br>
        <input type="file" name="pimage" ><br><br>
        <input type="text" name="pprice" placeholder="Enter product price"><br><br>
        <input type="text" name="pdes" placeholder="Enter product description"><br><br>
        <input type="submit">
    </form>
</body>
    </html>