<?php
session_start();
include('config/db.php');

if(!isset($_GET['id'])){
    echo "Seller not found!";
    exit();
}

$seller_id = intval($_GET['id']);

/* VIEW COUNT */
if(!isset($SESSION['viewed'.$seller_id])){
    mysqli_query($conn, "UPDATE sellers SET views = views + 1 WHERE id='$seller_id'");
    $SESSION['viewed'.$seller_id] = true;
}

/* SELLER */
$seller_query = mysqli_query($conn, "SELECT * FROM sellers WHERE id='$seller_id' AND is_approved=1");
if(mysqli_num_rows($seller_query) == 0){
    echo "Seller not found or not approved!";
    exit();
}
$seller = mysqli_fetch_assoc($seller_query);

/* PRODUCTS */
$products = mysqli_query($conn, "SELECT * FROM products WHERE seller_id='$seller_id' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo !empty($seller['shop_name']) ? $seller['shop_name'] : $seller['name']; ?> | Shop</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="shopstore.css">
</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="container nav">
        <div class="logo">Deal<span>Bazar</span></div>
        <div class="menu-toggle" onclick="toggleMenu()">☰</div>
        <ul class="menu" id="menu">
            <li><a href="home.php">Home</a></li>
            <li><a href="showrooms.php">Showrooms</a></li>
        </ul>
    </div>
</header>

<div class="container">

    <!-- BANNER -->
    <div class="shop-banner">
        <img src="<?php echo !empty($seller['banner']) ? $seller['banner'] : 'photos/default-banner.jpg'; ?>" alt="Banner">
    </div>

    <!-- PROFILE -->
    <div class="shop-profile">
        <img class="shop-logo" src="<?php echo !empty($seller['logo']) ? $seller['logo'] : 'photos/default-user.png'; ?>" alt="Logo">
        <div class="shop-info">
            <h2><?php echo !empty($seller['shop_name']) ? $seller['shop_name'] : $seller['name']; ?></h2>
            <p>📍 <?php echo $seller['location'] ?? 'No location'; ?></p>
            <p>📞 <?php echo $seller['phone'] ?? 'No phone'; ?></p>
            <p>👁 <?php echo $seller['views']; ?> views</p>
        </div>
    </div>

    <!-- DESCRIPTION -->
    <p class="shop-desc">
        <?php echo !empty($seller['description']) ? $seller['description'] : 'No description available.'; ?>
    </p>

    <!-- PRODUCTS -->
    <h2 class="shop-title">🔥 All Deals</h2>
    <div class="deals-grid">

        <?php if(mysqli_num_rows($products) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($products)): ?>
                <div class="deal-card">
                    <div class="badge"><?php echo $row['discount']; ?>% OFF</div>
                    <img src="<?php echo !empty($row['photo']) ? $row['photo'] : 'photos/default.png'; ?>" alt="Product">
                    <div class="card-details">
                        <h4><?php echo $row['name']; ?></h4>
                        <p class="seller">Sold by: <?php echo !empty($seller['shop_name']) ? $seller['shop_name'] : $seller['name']; ?></p>
                        <div class="prices">
                            <span class="old-price">৳<?php echo $row['price']; ?></span>
                            <span class="new-price">৳<?php echo $row['price'] - ($row['price'] * $row['discount']/100); ?></span>
                        </div>
                        <a href="product.php?id=<?php echo $row['id']; ?>" class="view-btn">Grab Deal</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-product">No products found for this seller.</p>
        <?php endif; ?>

    </div>

</div>

<script>
// Toggle Menu Function
function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('show');
}
</script>

</body>
</html>