<?php
session_start();
include('config/db.php');

if(!isset($_SESSION['seller_id'])){
    header("Location: seller_login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

$seller = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM sellers WHERE id='$seller_id'"));

$total_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products WHERE seller_id='$seller_id'"));
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Seller Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="seller_board.css">
</head>

<body>

<!-- ✅ HEADER (HOME STYLE SAME) -->
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

        <h1>Welcome, <?php echo $_SESSION['seller_name']; ?> 👋</h1>

        <!-- STATS -->
        <div class="cards">

            <div class="card">
                <h3><?php echo $total_products; ?></h3>
                <p>Total Products</p>
            </div>

            <div class="card">
                <h3>Active</h3>
                <p>Status</p>
            </div>

        </div>

        <!-- PROFILE -->
        <div class="profile-box">

            <img src="<?php echo !empty($seller['logo']) ? $seller['logo'] : 'photos/default-user.png'; ?>">

            <div>
                <h2><?php echo $seller['shop_name'] ?? $seller['name']; ?></h2>
                <p>📍 <?php echo $seller['location']; ?></p>
                <p>📞 <?php echo $seller['phone']; ?></p>

                <a href="edit_seller_profile.php" class="btn">Edit Profile</a>
            </div>

        </div>

    </div>

</div>

<!-- JS -->
<script>
function toggleMenu(){
    document.querySelector(".menu").classList.toggle("show");
}
</script>

</body>
</html>