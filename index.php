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
      <source src="background.mp4" type="video/mp4">
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
  <!-- <div class="menu-overlay" id="menuOverlay"></div> -->

  <!-- Hero Section: Middle Left Text and Button -->
  <div class="hero-left">
    <h1>
      <span class="primary">We are LBN Production</span><br>
      <span class="secondary">Ever Seeking<br>New Horizons</span>
    </h1>
    <p>We want to take you on an adventure,<br>but are you ready to take the leap?</p>
    <a href="services.php" class="explore-btn">Explore Our Works</a>
  </div>

  <!-- Social Icons at Bottom Right -->
  <div class="social-links-fixed" important>
    <a href="https://www.facebook.com/share/1AvSkgZumX/?mibextid=wwXIfr" class="social-icon" target="_blank"><i class="fab fa-facebook"></i></a>
    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
    <a href="https://www.instagram.com/thelbnproduction?igsh=MXUwMTVkdnhveDgwNg==" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
  </div>

  <!-- Audio Toggle Button -->
<button id="audioToggle" style="
  position: fixed;
  bottom: 32px;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(30,30,30,0.5);
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 1rem;
  box-shadow: 0 2px 12px rgba(0,0,0,0.2);
  cursor: pointer;
  margin-right: -350px;
  margin-left: 350px;
  z-index: 3000;
">
  <i id="audioIcon" class="fas fa-volume-mute"></i>
</button>

   <script src="new.js"></script>
    

</body>
</html>
