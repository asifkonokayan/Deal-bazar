<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Register | Deal Bazar</title>

<!-- GOOGLE FONT -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- CSS -->
<link rel="stylesheet" href="register.css">
</head>
<body>

<header>
  <div class="container">
    <div class="logo">Deal<span>Bazar</span></div>
    <nav>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="showrooms.php">Showrooms</a></li>
        <li><a href="seller_login.php">Seller Login</a></li>
        <li><a href="seller_register.php" class="active">Register</a></li>
      </ul>
    </nav>
  </div>
</header>

<main class="register-page">
  <div class="register-card">
    <div class="register-header">
      <h2>Seller Register</h2>
      <p>Create your seller account to start listing deals.</p>
    </div>

   <form action="auth/register.php" method="POST">
    <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="name" placeholder="Full Name" required>
    </div>

    <div class="input-group">
        <i class="fas fa-store"></i>
        <input type="text" name="shop_name" placeholder="Shop / Brand Name" required>
    </div>

    <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" placeholder="Email" required>
    </div>

    <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required>
    </div>

    <button type="submit" class="register-btn" name="register_btn">Register</button>
   </form>

  </div>
</main>

<footer>
  <p>&copy; 2026 Deal Bazar | All Rights Reserved</p>
</footer>

</body>
</html>