<?php
include('config/db.php');

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM sellers WHERE id='$id'");

header("Location: admin_panel.php");
exit();
?>