<?php
session_start();
include('config/db.php');

/* ================= ACTION ================= */

// APPROVE SELLER
if(isset($_GET['approve'])){
    $id = intval($_GET['approve']);
    mysqli_query($conn,"UPDATE sellers SET status='approved', is_approved=1 WHERE id=$id");
    header("Location: admin_panel.php");
    exit();
}

// DELETE SELLER
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    mysqli_query($conn,"DELETE FROM products WHERE seller_id=$id");
    mysqli_query($conn,"DELETE FROM sellers WHERE id=$id");

    header("Location: admin_panel.php");
    exit();
}

// CLEAR COMMISSION
if(isset($_GET['clear'])){
    $id = intval($_GET['clear']);
    mysqli_query($conn,"UPDATE commissions SET amount=0 WHERE seller_id=$id");
    header("Location: admin_panel.php");
    exit();
}

/* ================= DATA ================= */

// Sellers
$pending = mysqli_query($conn,"SELECT * FROM sellers WHERE is_approved=0");
$approved = mysqli_query($conn,"SELECT * FROM sellers WHERE is_approved=1");

// Stats
$total_sellers = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM sellers"));
$total_products = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM products"));
$total_orders = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM orders"));

// Commission Total
$total_commission = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(amount) as total FROM commissions"))['total'] ?? 0;

// Seller-wise commission
$commissions = mysqli_query($conn,"
SELECT c.*, s.name 
FROM commissions c
JOIN sellers s ON c.seller_id = s.id
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Panel | Deal Bazar</title>
<link rel="stylesheet" href="admin_panel.css">
</head>

<body>

<div class="admin-container">

<h1>Admin Dashboard</h1>

<!-- STATS -->
<div class="stats">
    <div class="card">👨‍💼 Sellers<br><?php echo $total_sellers; ?></div>
    <div class="card">📦 Products<br><?php echo $total_products; ?></div>
    <div class="card">🛒 Orders<br><?php echo $total_orders; ?></div>
    <div class="card">💰 Commission<br>৳<?php echo $total_commission; ?></div>
</div>

<!-- PENDING -->
<h2>Pending Sellers</h2>
<table>
<tr>
<th>Name</th>
<th>Email</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($pending)): ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td>
<a href="?approve=<?php echo $row['id']; ?>" class="approve">Approve</a>
<a href="?delete=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Delete?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<!-- APPROVED -->
<h2>Approved Sellers</h2>
<table>
<tr>
<th>Name</th>
<th>Email</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($approved)): ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td>
<a href="?delete=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Delete?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

<!-- COMMISSION -->
<h2>Seller Commission</h2>
<table>
<tr>
<th>Seller</th>
<th>Amount</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($commissions)): ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td>৳<?php echo $row['amount']; ?></td>
<td>
<a href="?clear=<?php echo $row['seller_id']; ?>" class="clear">Clear</a>
</td>
</tr>
<?php endwhile; ?>
</table>

</div>

</body>
</html>