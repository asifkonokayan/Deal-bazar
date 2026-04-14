<?php
session_start();
include('config/db.php');

$search = $_GET['search'] ?? "";

/* DEALS */
$deals = mysqli_query($conn, "
    SELECT p.*, s.name AS seller_name 
    FROM products p
    JOIN sellers s ON p.seller_id = s.id
    WHERE s.is_approved = 1 
    AND p.name LIKE '%$search%'
    ORDER BY p.created_at DESC
");

/* TOP SELLERS */
$top_sellers = mysqli_query($conn, "
    SELECT * FROM sellers 
    WHERE is_approved = 1
    ORDER BY views DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deal Bazar</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="homeindex.css">
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

<!-- HERO -->
<section class="banner">
    <div class="hero">
        <h1>Discover Premium Deals 🔥</h1>
        <p>Top brands. Best prices.</p>

        <div class="hero-buttons">
            <a href="showrooms.php" class="btn primary">Explore</a>
            <a href="deal.php" class="btn secondary">Deals</a>
        </div>
    </div>
</section>

<!-- TOP BRANDS -->
<div class="container">
    <h3 class="section-title">🔥 Top Brands</h3>

    <div class="categories">
        <?php while($row = mysqli_fetch_assoc($top_sellers)): ?>
            <a href="shop.php?id=<?php echo $row['id']; ?>">
                <?php echo $row['name']; ?>
            </a>
        <?php endwhile; ?>
    </div>
</div>

<!-- SEARCH -->
<div class="container search-wrap">
    <form method="GET">
        <input type="text" name="search" placeholder="Search products..." value="<?php echo $search; ?>">
    </form>
</div>

<!-- DEALS -->
<main class="container" id="deals">
    <h3 class="section-title">🔥 Deals</h3>

    <div class="grid">
        <?php while($row = mysqli_fetch_assoc($deals)): ?>
        
        <div class="card">

            <!-- CLICKABLE -->
            <a href="product.php?id=<?php echo $row['id']; ?>" class="card-link">

                <div class="badge">-<?php echo $row['discount']; ?>%</div>

                <img src="<?php echo !empty($row['photo']) ? $row['photo'] : 'photos/default.png'; ?>">

                <div class="info">
                    <h4><?php echo $row['name']; ?></h4>

                    <div class="price">
                        <span class="new">
                            ৳<?php echo $row['price'] - ($row['price'] * $row['discount']/100); ?>
                        </span>
                        <span class="old">৳<?php echo $row['price']; ?></span>
                    </div>
                </div>

            </a>

            <!-- CART -->
            <a href="cart.php?id=<?php echo $row['id']; ?>" class="cart-btn">
                Add to Cart
            </a>

        </div>

        <?php endwhile; ?>
    </div>
</main>

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