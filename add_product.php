<?php
session_start();
include('config/db.php');

if(!isset($_SESSION['seller_id'])){
    header("Location: seller_login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $description = $_POST['description'];

    // ✅ MAIN IMAGE UPLOAD
    $main_img = "uploads/" . time() . "_" . $_FILES['main_image']['name'];
    move_uploaded_file($_FILES['main_image']['tmp_name'], $main_img);

    // ✅ INSERT INTO PRODUCTS (MAIN IMAGE HERE)
    mysqli_query($conn, "
        INSERT INTO products (seller_id,name,price,discount,description,photo)
        VALUES ('$seller_id','$name','$price','$discount','$description','$main_img')
    ");

    // ✅ GET PRODUCT ID
    $product_id = mysqli_insert_id($conn);

    // ✅ MULTIPLE IMAGES INSERT
    if(!empty($_FILES['images']['name'][0])){

        foreach($_FILES['images']['name'] as $key => $value){

            if(!empty($_FILES['images']['name'][$key])){

                $img_name = time() . "_" . $_FILES['images']['name'][$key];
                $tmp = $_FILES['images']['tmp_name'][$key];

                $path = "uploads/" . $img_name;

                move_uploaded_file($tmp, $path);

                mysqli_query($conn, "
                    INSERT INTO product_images (product_id,image)
                    VALUES ('$product_id','$path')
                ");
            }
        }
    }

    header("Location: my_products.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<!-- SAME CSS AS DASHBOARD -->
<link rel="stylesheet" href="add_products.css">
</head>

<body>

<!-- HEADER -->
<header class="header">
    <div class="container nav">

        <div class="logo">Deal<span>Bazar</span></div>

        <div class="menu-toggle" onclick="toggleMenu()">☰</div>

        <ul class="menu">
            <li><a href="home.php">Home</a></li>
            <li><a href="showrooms.php">Showrooms</a></li>

            <?php if(isset($_SESSION['seller_name'])): ?>
                <li>
                    <a href="seller_dashboard.php" class="seller-name">
                        <?php
                        $name = $_SESSION['seller_name'];
                        $parts = explode(" ", $name);
                        echo end($parts); // last name
                        ?>
                    </a>
                </li>

                <li><a href="auth/logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>

    </div>
</header>
<!-- DASHBOARD -->
<div class="dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Seller Panel</h2>

        <a href="seller_dashboard.php">🏠 Dashboard</a>
        <a href="edit_seller_profile.php">👤 Edit Profile</a>
        <a href="add_product.php">➕ Add Product</a>
        <a href="my_products.php">📦 My Products</a>
        <a href="shop.php?id=<?php echo $seller_id; ?>">🛍 View Shop</a>
        <a href="seller_oders.php">🧾 All Orders</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <h1>Add Product ➕</h1>

        <!-- SAME STYLE AS DASHBOARD -->
        <div class="cards">

            <div class="card" style="text-align:left;">

                <form method="POST" enctype="multipart/form-data">

                    <label>Product Name</label>
                    <input type="text" name="name" required>

                    <label>Price</label>
                    <input type="number" name="price" required>

                    <label>Discount (%)</label>
                    <input type="number" name="discount">

                    <label>Description</label>
                    <textarea name="description"></textarea>

                    <label>Main Image</label>
                    <input type="file" name="main_image" required>

                    <label>1st Image</label>
                    <input type="file" name="images[]" required>

                    <label>2nd Image</label>
                    <input type="file" name="images[]" required>

                    <label>3rd Image</label>
                    <input type="file" name="images[]" required>

                    <button type="submit" class="btn">Add Product</button>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
function toggleMenu(){
    document.querySelector(".menu").classList.toggle("show");
}
</script>

</body>
</html>