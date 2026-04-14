<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Login | Deal Bazar</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<link rel="stylesheet" href="login_sell.css">
</head>
<body>

<!-- HEADER -->
<header class="header">
  <div class="container nav">
    <div class="logo">Deal<span>Bazar</span></div>

    <ul class="menu">
      <li><a href="home.php">Home</a></li>
      <li><a href="showrooms.php">Showrooms</a></li>
      <li><a href="deal.php">Deals</a></li>
      <li><a href="login_seller.php" class="active">Seller Login</a></li>
    </ul>
  </div>
</header>

<!-- LOGIN -->
<main class="login-page">

  <div class="login-card">

    <div class="login-header">
      <h2>Seller Login</h2>
      <p>Welcome back! Enter your credentials</p>
    </div>

    <form action="auth/login.php" method="POST">

      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" placeholder="Email address" required>
      </div>

      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required>
      </div>

      <button type="submit" class="login-btn">Login</button>

    </form>

    <p class="signup-text">
      Don't have an account? <a href="seller_register.php">Register</a>
    </p>

  </div>

</main>

<!-- FOOTER -->

<script>
function toggleMenu(){
    document.querySelector(".menu").classList.toggle("show");
}

document.addEventListener("click", function(e){
    const menu = document.querySelector(".menu");
    const toggle = document.querySelector(".menu-toggle");

    if(!menu.contains(e.target) && !toggle.contains(e.target)){
        menu.classList.remove("show");
    }
});
</script>

</body>
</html>