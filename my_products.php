<?php
session_start();
include('config/db.php');

if(!isset($_SESSION['seller_id'])){
    header("Location: seller_login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

// Fetch seller products
$products = mysqli_query($conn, "SELECT * FROM products WHERE seller_id='$seller_id' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Products</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="my_products.css">

</head>

<body>

<!-- HEADER -->
<header class="header">
    <div class="container nav">

        <div class="logo">Deal<span>Bazar</span></div>

        <ul class="menu">
            <li><a href="home.php">Home</a></li>
            <li><a href="showrooms.php">Showrooms</a></li>

            <!-- 🔥 SELLER LOGO -->
            <li>
                <a href="seller_dashboard.php" class="profile-icon">

                    <?php
                    $logo = $_SESSION['seller_logo'] ?? '';
                    ?>

                    <img src="<?php echo !empty($logo) ? $logo : 'photos/default-user.png'; ?>" alt="Seller">

                </a>
            </li>

            <li><a href="auth/logout.php">Logout</a></li>
        </ul>

    </div>
</header>

<!-- DASHBOARD -->
<div class="dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Seller Panel</h2>

        <a href="seller_dashboard.php">🏠 Dashboard</a>
        <a href="edit_profiles.php">👤 Edit Profile</a>
        <a href="add_product.php">➕ Add Product</a>
        <a href="my_products.php">📦 My Products</a>
        <a href="shop.php?id=<?php echo $_SESSION['seller_id']; ?>">🛍 View Shop</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <h1>My Products 📦</h1>

        <div class="product-grid">

            <?php while($row = mysqli_fetch_assoc($products)){ ?>

                <div class="product-card">

                    <img src="<?php echo $row['photo']; ?>" alt="">

                    <h3><?php echo $row['name']; ?></h3>

                    <p>৳ <?php echo $row['price']; ?></p>

                    <div class="actions">
                        <a href="edit_product_details.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                        <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn danger" onclick="return confirm('Delete this product?')">Delete</a>
                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</div>

</body>
</html>