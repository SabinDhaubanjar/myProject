<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Image</title>
</head>
<body>
  
<form action="" method="post" enctype="multipart/form-data">
  <input type="file" name="userfile[]" value="" multiple=""/>
  <input type="submit" name="upload" value="Upload Image" />
</form>

<?php

// 1. Connect to the MySQL database
$mysqli = new mysqli("localhost", "root", "", "images");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$phpFileUploadErrors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
);

$table = "animals";

//$_FILES global variable
if(isset($_FILES['userfile'])) {
  $file_array = reArrayFiles($_FILES['userfile']);

  for($i=0;$i<count($file_array);$i++) {
    if($file_array[$i]['error']) {
      ?> <div class="alert alert-danger">
        <?php echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']]; 
        ?></div> <?php
    }
    else {
      $extensions = array('jpg','jpeg','png','gif');

      $file_ext = explode('.',$file_array[$i]['name']);
      $name = $file_ext[0];
      $file_ext = end($file_ext);

      if(!in_array($file_ext,$extensions)) {
        ?> <div class = "alert alert-danger">
          <?php echo "{$file_array[$i]['name']} - Invalid file extension!"; 
          ?></div> <?php
      }
      else {
        $img_dir = 'web/'.$file_array[$i]['name'];

        move_uploaded_file($file_array[$i]['tmp_name'], $img_dir);

        $sql = "INSERT IGNORE INTO $table (name,img_dir) VALUES ('$name','$img_dir')";
        $mysqli->query($sql);

        ?> <div class = "alert alert-success">
          <?php echo $file_array[$i]['name'].'-'.$phpFileUploadErrors[$file_array[$i]['error']];
          ?></div> <?php
      }
    }
  }
}

function reArrayFiles(&$file_post) {
  $file_ary = array();
  $file_count = count($file_post['name']);
  $file_keys = array_keys($file_post);

  for($i=0; $i<$file_count; $i++) {
    foreach($file_keys as $key) {
      $file_ary[$i][$key] = $file_post[$key][$i];
    }
  }
  return $file_ary;
}
?>

</body>
</html>