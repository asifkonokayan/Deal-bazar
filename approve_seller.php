<?php
include('config/db.php');
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    mysqli_query($conn, "UPDATE sellers SET is_approved=1 WHERE id='$id'");
    header("Location: admin_panel.php");
}
?> 