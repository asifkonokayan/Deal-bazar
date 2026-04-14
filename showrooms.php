<?php
session_start();
include('config/db.php');

/* FETCH SELLERS */
$sellers = mysqli_query($conn, "SELECT * FROM sellers WHERE is_approved=1 ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Showrooms | DealBazar</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="showroom.css">
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
            <li><a href="deal.php">Deals</a></li>

            <?php if(isset($_SESSION['seller_name'])): ?>
                <li>
                    <a href="seller_dashboard.php" class="seller-btn">
                        <?php 
                            $name = $_SESSION['seller_name'];
                            $parts = explode(" ", $name);
                            echo end($parts);
                        ?>
                    </a>
                </li>

                <li><a href="auth/logout.php">Logout</a></li>

            <?php else: ?>
                <li><a href="login_seller.php">Seller Login</a></li>
            <?php endif; ?>
        </ul>

    </div>
</header>

<!-- CONTENT -->
<div class="container">

    <h3 class="title">🏬 All Showrooms</h3>

    <div class="showroom-grid">

        <?php while($row = mysqli_fetch_assoc($sellers)): ?>

        <div class="showroom-card">

            <!-- IMAGE -->
            <div class="img-box">
                <img src="<?php echo !empty($row['logo']) ? $row['logo'] : 'photos/default-user.png'; ?>">
                <span class="badge">Shop</span>
            </div>

            <!-- INFO -->
            <div class="info">

                <h4>
                    <?php echo $row['shop_name'] ?? $row['name']; ?>
                </h4>

                <div class="shop-name">
                    📍 <?php echo $row['location'] ?? 'No location'; ?>
                </div>

                <div class="shop-name">
                    👁 <?php echo $row['views']; ?> views
                </div>

                <!-- BUTTON -->
                <a href="shop.php?id=<?php echo $row['id']; ?>" class="view-btn">
                    Visit Shop
                </a>

            </div>

        </div>

        <?php endwhile; ?>

    </div>

</div>

<!-- JS -->
<script>
function toggleMenu(){
    document.querySelector(".menu").classList.toggle("show");
}

document.addEventListener("click", function(e){
    const menu = document.querySelector(".menu");
    const toggle = document.querySelector(".menu-toggle");

    if(!menu.contains(e.target) && !toggle.contains(e.target)){
        menu.classList.remove("show");
    }
});
</script>

</body>
</html>