<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Display SQL images</title>
</head>
<body>
  <?php
  $mysqli = new mysqli("localhost", "root", "", "images");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$table = "animals";

$result = $mysqli->query("SELECT * FROM $table") or die($mysqli->error);

while($data = $result->fetch_assoc()) {
    echo '<h3>'.$data['name'].'</h3>';
    echo '<img src="'.$data['img_dir'].'" alt="'.$data['name'].'" style="max-width:300px;"/>';
    echo '</div>';
}
  ?>
</body>
</html>