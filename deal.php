<?php
session_start();
include('config/db.php');

$products = mysqli_query($conn, "
SELECT p.*, s.name AS seller_name
FROM products p
JOIN sellers s ON p.seller_id = s.id
WHERE s.is_approved = 1
ORDER BY p.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deals</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="deals.css">
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

<!-- TITLE -->
<div class="container">
    <h2 class="title">🔥 All Deals</h2>
</div>

<!-- PRODUCTS -->
<div class="container">
    <div class="grid">

    <?php while($row = mysqli_fetch_assoc($products)): ?>

        <div class="card">

            <!-- CLICKABLE IMAGE -->
            <a href="product.php?id=<?php echo $row['id']; ?>">
                <div class="img-box">
                    <div class="badge">-<?php echo $row['discount']; ?>%</div>
                    <img src="<?php echo $row['photo']; ?>">
                </div>
            </a>

            <div class="info">

                <h4>
                    <a href="product.php?id=<?php echo $row['id']; ?>">
                        <?php echo $row['name']; ?>
                    </a>
                </h4>

                <p class="seller">by <?php echo $row['seller_name']; ?></p>

                <div class="price">
                    <span class="new">
                        ৳<?php echo $row['price'] - ($row['price'] * $row['discount']/100); ?>
                    </span>
                    <span class="old">৳<?php echo $row['price']; ?></span>
                </div>

                <!-- ADD TO CART -->
                <a href="cart.php?id=<?php echo $row['id']; ?>" class="cart-btn">
                    Add to Cart
                </a>

            </div>

        </div>

    <?php endwhile; ?>

    </div>
</div>

<!-- JS -->
<script>

// TOGGLE MENU FIX
function toggleMenu(){
    document.querySelector(".menu").classList.toggle("show");
}

// CLICK OUTSIDE CLOSE (PRO)
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