<?php
include('config/db.php');

$data = mysqli_query($conn,"
SELECT c.*, s.name 
FROM commissions c
JOIN sellers s ON c.seller_id = s.id
");
?>

<h2>Admin Earnings</h2>

<?php while($row = mysqli_fetch_assoc($data)): ?>

<div>
<p>Seller: <?php echo $row['name']; ?></p>
<p>Commission: ৳<?php echo $row['amount']; ?></p>

<a href="clear.php?id=<?php echo $row['seller_id']; ?>">
Clear
</a>
</div>

<?php endwhile; ?>