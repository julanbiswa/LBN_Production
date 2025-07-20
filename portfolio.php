<?php
include("conn.php");
$portfolios = mysqli_query($conn, "SELECT * FROM portfolio ORDER BY uploaded_at DESC");

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

  <!-- Hero Section: Middle Left Text and Button -->
  <h2 style="text-align:center;margin-top:2rem;">Our Portfolio</h2>
<p style="text-align: center; max-width: 700px; margin: 1rem auto 2rem;">
  Explore a collection of our most impactful photo and video projects. Our work spans product showcases, corporate branding, influencer marketing, and more.
</p>

<div class="portfolio-grid">
  <?php while ($row = mysqli_fetch_assoc($portfolios)): ?>
    <div class="portfolio-card">
      <div class="portfolio-img-wrap">
        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Portfolio" />
      </div>
      <div class="portfolio-card-body">
        <h4><?php echo htmlspecialchars($row['title']); ?></h4>
        <p><?php echo htmlspecialchars($row['description']); ?></p>
      </div>
    </div>
  <?php endwhile; ?>
</div>

  <!-- Social Icons at Bottom Right -->
  <div class="social-links-fixed" important>
    <a href="https://www.facebook.com/share/1AvSkgZumX/?mibextid=wwXIfr" class="social-icon" target="_blank"><i class="fab fa-facebook"></i></a>
    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
    <a href="https://www.instagram.com/thelbnproduction?igsh=MXUwMTVkdnhveDgwNg==" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
  </div>

   <script src="new.js"></script>
    

</body>
</html>

