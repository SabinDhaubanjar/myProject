<?php
session_start();

// Destroy seller session
unset($_SESSION['seller_id']);
unset($_SESSION['shop_name']);
unset($_SESSION['owner_name']);

// Redirect to seller login
header("Location: seller_login.html");
exit();
?>