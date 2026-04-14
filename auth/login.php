<?php
session_start();
include('../config/db.php');

if(isset($_POST['email']) && isset($_POST['password'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM sellers WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $seller = mysqli_fetch_assoc($result);

        if(password_verify($password, $seller['password'])){
            if($seller['is_approved'] == 1){
                $_SESSION['seller_id'] = $seller['id'];
                $_SESSION['seller_name'] = $seller['name'];
                $_SESSION['shop_name'] = $seller['shop_name'];
                $_SESSION['seller_logo'] = $seller['logo'];
                
                header("Location: ../seller_dashboard.php");
                exit();
            } else {
                echo "Your registration is not approved yet!";
            }
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "Invalid credentials!";
    }
} else {
    echo "Please enter both email and password!";
}
?>