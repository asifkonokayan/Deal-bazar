<?php
session_start();
if(!isset($_SESSION['seller_id'])){
    header("Location: seller_login.php");
    exit();
}

include('config/db.php');

$seller_id = $_SESSION['seller_id'];

$orders = mysqli_query($conn,"
SELECT o.*, p.name, p.photo 
FROM orders o
JOIN products p ON o.product_id = p.id
WHERE o.seller_id='$seller_id'
ORDER BY o.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Orders</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif;}

body{
    background:#0f0f0f;
    color:white;
}

/* HEADER */
.header{
    background:#000;
    border-bottom:1px solid #222;
}

.container{
    width:92%;
    max-width:1200px;
    margin:auto;
}

.nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 0;
}

.logo span{color:#ff3b3b;}

.menu{
    display:flex;
    gap:15px;
    list-style:none;
}

.menu a{
    color:#aaa;
    text-decoration:none;
}

.menu a:hover{
    color:#ff3b3b;
}

.profile-icon img{
    width:32px;
    height:32px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #ff3b3b;
    cursor:pointer;
    transition:0.3s;
}

.profile-icon img:hover{
    transform:scale(1.1);
}

/* DASHBOARD */
.dashboard{
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:220px;
    background:#111;
    min-height:100vh;
    padding:15px;
}

.sidebar h2{
    margin-bottom:15px;
}

.sidebar a{
    display:block;
    padding:10px;
    color:#aaa;
    text-decoration:none;
    border-radius:6px;
    margin-bottom:5px;
}

.sidebar a:hover{
    background:#222;
    color:#fff;
}

/* MAIN */
.main{
    flex:1;
    padding:20px;
}

.order-card{
    display:flex;
    gap:10px;
    background:#111;
    padding:10px;
    border-radius:10px;
    margin-bottom:10px;
}

.order-card img{
    width:80px;
    height:80px;
    object-fit:cover;
    border-radius:6px;
}

.order-info h4{
    margin-bottom:5px;
}

.order-info p{
    font-size:13px;
    color:#aaa;
}

/* STATUS */
.status{
    margin-top:5px;
    font-size:12px;
    padding:3px 6px;
    border-radius:4px;
    display:inline-block;
}

.pending{background:orange;}
</style>

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
        <a href="seller_orders.php">📦 All Orders</a>
        <a href="shop.php?id=<?php echo $_SESSION['seller_id']; ?>">🛍 View Shop</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <h1>📦 All Orders</h1>

        <?php if(mysqli_num_rows($orders) > 0): ?>

            <?php while($row = mysqli_fetch_assoc($orders)): ?>

            <div class="order-card">

                <img src="<?php echo $row['photo']; ?>">

                <div class="order-info">

                    <h4><?php echo $row['name']; ?></h4>

                    <p>👤 <?php echo $row['customer_name']; ?></p>
                    <p>📞 <?php echo $row['phone']; ?></p>
                    <p>📍 <?php echo $row['address']; ?></p>

                    <p>💰 ৳<?php echo $row['total']; ?></p>

                    <span class="status pending">
                        <?php echo $row['status']; ?>
                    </span>

                </div>

            </div>

            <?php endwhile; ?>

        <?php else: ?>

            <p>No orders yet.</p>

        <?php endif; ?>

    </div>

</div>

</body>
</html>