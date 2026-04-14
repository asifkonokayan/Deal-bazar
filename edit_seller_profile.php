<?php
session_start();
include('config/db.php');

if(!isset($_SESSION['seller_id'])){
    header("Location: seller_login.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

// Fetch seller data
$seller = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM sellers WHERE id='$seller_id'"));

// UPDATE PROFILE
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $shop_name = $_POST['shop_name'];
    $location = $_POST['location'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];

    // LOGO
    if(!empty($_FILES['logo']['name'])){
        $logo = "uploads/" . time() . "_" . $_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], $logo);
    } else {
        $logo = $seller['logo'];
    }

    // BANNER
    if(!empty($_FILES['banner']['name'])){
        $banner = "uploads/" . time() . "_" . $_FILES['banner']['name'];
        move_uploaded_file($_FILES['banner']['tmp_name'], $banner);
    } else {
        $banner = $seller['banner'];
    }

    mysqli_query($conn, "
        UPDATE sellers SET 
        shop_name='$shop_name',
        location='$location',
        phone='$phone',
        description='$description',
        logo='$logo',
        banner='$banner'
        WHERE id='$seller_id'
    ");

    header("Location: seller_dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<!-- ✅ External CSS -->
<link rel="stylesheet" href="edit_seller_profile.css">
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

        <h1>Edit Shop Profile ✏️</h1>

        <div class="form-box">

            <form method="POST" enctype="multipart/form-data">

                <label>Shop Name</label>
                <input type="text" name="shop_name" value="<?php echo $seller['shop_name']; ?>" required>

                <label>Location</label>
                <input type="text" name="location" value="<?php echo $seller['location']; ?>">

                <label>Phone</label>
                <input type="text" name="phone" value="<?php echo $seller['phone']; ?>">

                <label>Short Description</label>
                <textarea name="description"><?php echo $seller['description'] ?? ''; ?></textarea>

                <label>Shop Logo</label>
                <input type="file" name="logo">

                <label>Shop Banner</label>
                <input type="file" name="banner">

                <button type="submit" class="btn">Update Profile</button>

            </form>

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