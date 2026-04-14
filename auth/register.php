<?php
session_start();
include('../config/db.php');

if(isset($_POST['email'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $shop_name = $_POST['shop_name'];

    // check email exists
    $check = mysqli_query($conn, "SELECT * FROM sellers WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        echo "Email already registered!";
    } else {

        // insert with status pending
        $sql = "INSERT INTO sellers (name,email,password,shop_name,status) 
                VALUES ('$name','$email','$password','$shop_name','pending')";

        if(mysqli_query($conn,$sql)){

            // session set
            $_SESSION['seller_email'] = $email;

            // redirect to wait page
            header("Location: wait_approval.php");
            exit();

        } else {
            echo "Error: ".mysqli_error($conn);
        }
    }
}
?>