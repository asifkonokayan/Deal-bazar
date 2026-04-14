<?php
include('config/db.php');

$id = $_GET['id'];

mysqli_query($conn,"
UPDATE commissions SET amount=0 WHERE seller_id='$id'
");

header("Location: admin_commission.php");