<?php
session_start();
include('config/db.php');

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

/* ADD TO CART */
if(isset($_GET['id'])){
    $id = $_GET['id'];

    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id] += 1;
    }else{
        $_SESSION['cart'][$id] = 1;
    }

    header("Location: cart.php");
}

/* UPDATE QTY */
if(isset($_POST['update'])){
    foreach($_POST['qty'] as $id => $qty){
        if($qty <= 0){
            unset($_SESSION['cart'][$id]);
        }else{
            $_SESSION['cart'][$id] = $qty;
        }
    }
}

/* REMOVE */
if(isset($_GET['remove'])){
    unset($_SESSION['cart'][$_GET['remove']]);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cart</title>

<style>
body{background:#0f0f0f;color:white;font-family:Arial;}
.container{width:90%;margin:auto;}

.item{
    display:flex;
    gap:10px;
    margin:10px 0;
    background:#111;
    padding:10px;
    border-radius:8px;
}

.item img{
    width:80px;
    height:80px;
    object-fit:cover;
}

input{
    width:50px;
}

.btn{
    background:red;
    color:white;
    padding: 5px;
    border-radius: 7px;
    text-decoration:none;
    display:inline-block;
    margin-top:10px;
}
.remove-btn{
    background: #e3e0e3;
    padding: 4px 8px;
    color:red;
    text-decoration:none;
    font-size:10px;
    margin-top:8px;
    display:inline-block;
    border-radius: 5px;
}

.total{
    margin-top:15px;
    font-size:18px;
}
</style>

</head>

<body>

<div class="container">

<h2>🛒 Your Cart</h2>

<form method="POST">

<?php
$total = 0;

foreach($_SESSION['cart'] as $id => $qty):

$product = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$row = mysqli_fetch_assoc($product);

$price = $row['price'] - ($row['price'] * $row['discount']/100);
$sub = $price * $qty;
$total += $sub;
?>

<div class="item">

<img src="<?php echo $row['photo']; ?>">

<div>
<h4><?php echo $row['name']; ?></h4>

<p>৳<?php echo $price; ?></p>

<input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $qty; ?>">

<a href="cart.php?remove=<?php echo $id; ?>"class="remove-btn">Remove</a>

</div>

</div>

<?php endforeach; ?>

<button type="submit" name="update" class="btn">Update Cart</button>

</form>

<div class="total">
Total: ৳<?php echo $total; ?>
</div>

<a href="checkout.php" class="btn">Checkout</a>

</div>

</body>
</html>