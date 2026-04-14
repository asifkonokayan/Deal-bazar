<?php
session_start();
include('config/db.php');

if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
    echo "Cart is empty!";
    exit();
}

if(isset($_POST['order'])){

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $district = $_POST['district'];
    $address = $_POST['address'];

    foreach($_SESSION['cart'] as $id => $qty){

        $p = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM products WHERE id='$id'"));

        $price = $p['price'] - ($p['price'] * $p['discount']/100);
        $total = $price * $qty;

        mysqli_query($conn,"
        INSERT INTO orders (product_id,seller_id,customer_name,phone,address,price,qty,total)
        VALUES ('$id','{$p['seller_id']}','$name','$phone','$district, $address','$price','$qty','$total')
        ");

        // commission
        $seller = $p['seller_id'];

        $check = mysqli_query($conn,"SELECT * FROM commissions WHERE seller_id='$seller'");
        if(mysqli_num_rows($check)>0){
            mysqli_query($conn,"UPDATE commissions SET amount=amount+20 WHERE seller_id='$seller'");
        }else{
            mysqli_query($conn,"INSERT INTO commissions (seller_id,amount) VALUES ('$seller',20)");
        }
    }

    unset($_SESSION['cart']);
    $success = "✅ Order placed successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial;}

body{
    background:#0f0f0f;
    color:white;
}

.container{
    width:92%;
    max-width:500px;
    margin:30px auto;
    background:#111;
    padding:20px;
    border-radius:10px;
}

h2{
    margin-bottom:15px;
    text-align:center;
}

.input-group{
    margin-bottom:12px;
}

label{
    font-size:13px;
    color:#aaa;
}

input,select,textarea{
    width:100%;
    padding:10px;
    margin-top:5px;
    border:none;
    border-radius:6px;
    background:#1a1a1a;
    color:white;
}

textarea{
    resize:none;
    height:80px;
}

.btn{
    width:100%;
    padding:12px;
    background:#ff3b3b;
    border:none;
    border-radius:6px;
    color:white;
    font-size:15px;
    margin-top:10px;
    cursor:pointer;
}

.btn:hover{
    background:#e60000;
}

.success{
    background:#0a3;
    padding:10px;
    margin-bottom:10px;
    border-radius:6px;
    text-align:center;
}
</style>

</head>

<body>

<div class="container">

<h2>🧾 Checkout</h2>

<?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>

<form method="POST">

<div class="input-group">
<label>Full Name</label>
<input type="text" name="name" required>
</div>

<div class="input-group">
<label>Phone Number</label>
<input type="text" name="phone" required>
</div>

<div class="input-group">
<label>District</label>
<select name="district" required>
<option value="">Select District</option>
<option>Dhaka</option>
<option>Chattogram</option>
<option>Khulna</option>
<option>Rajshahi</option>
<option>Sylhet</option>
<option>Barishal</option>
<option>Rangpur</option>
<option>Mymensingh</option>
</select>
</div>

<div class="input-group">
<label>Full Address</label>
<textarea name="address" required></textarea>
</div>

<button type="submit" name="order" class="btn">
Confirm Order
</button>

</form>

</div>

</body>
</html>