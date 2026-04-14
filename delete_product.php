<?php
include('config/db.php');

$id = $_GET['id'];

// ❗ first delete images
mysqli_query($conn, "DELETE FROM product_images WHERE product_id='$id'");

// ❗ then delete product
mysqli_query($conn, "DELETE FROM products WHERE id='$id'");

header("Location: my_products.php");
?>