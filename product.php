<?php
session_start();
include('config/db.php');

$id = $_GET['id'];

/* MAIN PRODUCT */
$product = mysqli_query($conn, "
SELECT p.*, s.name AS seller_name
FROM products p
JOIN sellers s ON p.seller_id = s.id
WHERE p.id='$id'
");
$data = mysqli_fetch_assoc($product);

/* MORE IMAGES */
$images = mysqli_query($conn, "
SELECT * FROM product_images WHERE product_id='$id'
");

/* RELATED PRODUCTS */
$related = mysqli_query($conn, "
SELECT * FROM products 
WHERE seller_id='{$data['seller_id']}' 
AND id != '$id'
ORDER BY created_at DESC
LIMIT 4
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $data['name']; ?></title>

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    background:#0f0f0f;
    color:white;
    font-family:Arial;
}

/* HEADER */
.header{
    background:#000;
    border-bottom:1px solid #222;
}

.container{
    width:92%;
    max-width:1100px;
    margin:auto;
}

.nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:10px 0;
}

.logo span{
    color:#ff3b3b;
}

/* MENU */
.menu{
    display:flex;
    list-style:none;
    gap:12px;
}

.menu a{
    text-decoration:none;
    color:#aaa;
    font-size:13px;
}

.menu a:hover{
    color:#ff3b3b;
}

.menu-toggle{
    display:none;
    font-size:22px;
    cursor:pointer;
}

/* PRODUCT */
.main-img{
    width: 100%;
    height:490px;
    object-fit:contain;
    background:black
    border-radius:30px;
    margin-top:10px;
}

.thumbs{
    display:flex;
    gap:10px;
    margin-top:10px;
}

.thumbs img{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:6px;
    cursor:pointer;
}

.info{
    margin-top:15px;
}

.price{
    color:#ff3b3b;
    font-size:22px;
}

.old{
    text-decoration:line-through;
    color:#777;
    font-size:14px;
}

.btn{
    display:block;
    background:#ff3b3b;
    padding:12px;
    text-align:center;
    margin-top:15px;
    color:white;
    text-decoration:none;
    border-radius:6px;
}

/* RELATED */
.related{
    margin-top:30px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:10px;
}

.card{
    background:#111;
    border-radius:10px;
    overflow:hidden;
    text-decoration:none;
    color:white;
}

.card img{
    width:100%;
    height:120px;
    object-fit:cover;
}

.card h4{
    font-size:13px;
    padding:5px;
}

/* MOBILE */
@media(max-width:768px){

    .menu{
        display:none;
        flex-direction:column;
        position:absolute;
        right:10px;
        top:60px;
        background:#000;
        padding:10px;
        border:1px solid #222;
    }

    .menu.show{
        display:flex;
    }

    .menu-toggle{
        display:block;
    }
}
</style>

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
        </ul>

    </div>
</header>

<div class="container">

<h2 style="margin-top:10px;"><?php echo $data['name']; ?></h2>

<!-- MAIN IMAGE -->
<img id="mainImage" class="main-img" src="<?php echo $data['photo']; ?>">

<!-- MORE IMAGES -->
<div class="thumbs">
<?php while($img = mysqli_fetch_assoc($images)): ?>
    <img src="<?php echo $img['image']; ?>" onclick="changeImage(this.src)">
<?php endwhile; ?>
</div>

<!-- INFO -->
<div class="info">

<p class="price">
৳<?php echo $data['price'] - ($data['price'] * $data['discount']/100); ?>
<span class="old">৳<?php echo $data['price']; ?></span>
</p>

<p>Seller: <?php echo $data['seller_name']; ?></p>

<p><?php echo $data['description']; ?></p>

<a href="cart.php?id=<?php echo $data['id']; ?>" class="btn">
Add to Cart
</a>

</div>

<!-- RELATED -->
<div class="related">

<h3>More from this seller</h3>

<div class="grid">

<?php while($row = mysqli_fetch_assoc($related)): ?>

<a href="product.php?id=<?php echo $row['id']; ?>" class="card">

<img src="<?php echo $row['photo']; ?>">

<h4><?php echo $row['name']; ?></h4>

</a>

<?php endwhile; ?>

</div>

</div>

</div>

<!-- JS -->
<script>

function changeImage(src){
    document.getElementById("mainImage").src = src;
}

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