<?php
include 'config/db.php';
session_start();

if(!isset($_SESSION['seller_id'])){
    header("Location: seller_login.php");
    exit();
}

$id = $_GET['id'];

// product load
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $description = $_POST['description'];

    // MAIN IMAGE UPDATE
    if(!empty($_FILES['image']['name'])){
        $image = "uploads/".time()."_".$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);

        mysqli_query($conn, "UPDATE products SET photo='$image' WHERE id=$id");
    }

    // MULTIPLE IMAGES
    if(!empty($_FILES['images']['name'][0])){
        foreach($_FILES['images']['name'] as $key => $val){

            $img = "photos/".time()."_".$val;
            move_uploaded_file($_FILES['images']['tmp_name'][$key], $img);

            mysqli_query($conn, "INSERT INTO product_images(product_id,image) VALUES('$id','$img')");
        }
    }

    // UPDATE INFO
    mysqli_query($conn, "UPDATE products SET 
        name='$name',
        price='$price',
        discount='$discount',
        description='$description'
        WHERE id=$id
    ");

    header("Location: my_products.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

    <!-- IMPORTANT -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="edit_product.css">
</head>

<body>

<div class="container">

    <a href="my_products  .php" class="back-btn">Back</a>

    <h2>Edit Product ✏️</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>Product Name</label>
        <input type="text" name="name" value="<?= $product['name'] ?>" required>

        <label>Price</label>
        <input type="number" name="price" value="<?= $product['price'] ?>" required>

        <label>Discount (%)</label>
        <input type="number" name="discount" value="<?= $product['discount'] ?>">

        <label>Description</label>
        <textarea name="description"><?= $product['description'] ?></textarea>

        <label>Current Image</label>
        <img src="<?= $product['photo'] ?>" class="preview">

        <label>Change Main Image</label>
        <input type="file" name="image">

        <label>Add More Images</label>
        <input type="file" name="images[]" multiple>

        <button name="update">Update Product</button>

    </form>

</div>

</body>
</html>