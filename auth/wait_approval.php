<?php
session_start();
include('../config/db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['seller_email'])){
    header("Location: login_seller.php");
    exit();
}

$email = $_SESSION['seller_email'];

$query = mysqli_query($conn, "SELECT status FROM sellers WHERE email='$email'");
$user = mysqli_fetch_assoc($query);

if($user['status'] == 'approved'){
    header("Location: ../login_seller.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Waiting Approval</title>
</head>
<body>

<h2>⏳ Wait for Admin Approval</h2>
<p>Your request is pending...</p>

<meta http-equiv="refresh" content="5">

</body>
</html>