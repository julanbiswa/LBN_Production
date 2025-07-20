<?php
include("conn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LBNproduction</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="styles.css"/>
</head>
<body>
  <div class="video-background">
    <video autoplay muted loop playsinline id="myVideo">
      <source src="background.MP4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>

  <!-- Navbar with logo and hamburger -->
  <nav class="navbar">
  <div class="logo"><a href="index.php" style="color:inherit;text-decoration:none;">LBN Production</a></div>
  <div class="nav-toggle" id="navToggle">
    <i class="fas fa-bars" id="openMenu"></i>
    <i class="fas fa-times" id="closeMenu" style="display:none;"></i>
  </div>
</nav>

  <div class="nav-links" id="navLinks">
    <a href="index.php">Home</a>
    <a href="about.php">About Us</a>
    <a href="services.php">Services</a>
    <a href="portfolio.php">Portfolio</a>
    <a href="contact.php">Contact</a>
  </div>
  <div class="menu-overlay" id="menuOverlay"></div>

 <main class="hero">
    <div class="hero-content">
      <h1>About Us</h1>
      <p>
        We are a team of creative professionals dedicated to crafting powerful photo and video content for brands, businesses, and influencers.
        Our mission is to help you stand out in the digital space with engaging visual media tailored to your brand identity.
      </p>
    </div>
  </main>

  <!-- Social Icons at Bottom Right -->
  <div class="social-links-fixed" important>
    <a href="https://www.facebook.com/share/1AvSkgZumX/?mibextid=wwXIfr" class="social-icon" target="_blank"><i class="fab fa-facebook"></i></a>
    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
    <a href="https://www.instagram.com/thelbnproduction?igsh=MXUwMTVkdnhveDgwNg==" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
  </div>

   <script src="new.js"></script>
    

</body>
</html>
