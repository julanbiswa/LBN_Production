<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

$photos = mysqli_query($conn, "SELECT * FROM photos ORDER BY uploaded_at DESC");
$videos = mysqli_query($conn, "SELECT * FROM videos ORDER BY uploaded_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LBNproduction</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <link rel="stylesheet" href="styles.css"/>
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    body {
      min-height: 100vh;
      width: 100vw;
      overflow-x: hidden;
    }

    main {
      height: 100vh;
      width: 100vw;
      padding: 0;
      margin: 0;
      display: flex;
      align-items: stretch;
      justify-content: stretch;
      position: relative;
      z-index: 1;
    }

    .services-section {
      width: 100vw;
      height: 100vh;
      background-color: rgba(0,0,0,0.6);
      padding: 0;
      margin: 0;
      border-radius: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .hidden { display: none; }
    .center-buttons {
      display: flex;
      gap: 20px;
      justify-content: center;
      margin-top: 2rem;
    }
    .content-button {
      background-color: #ffffff10;
      color: white;
      padding: 1rem 2rem;
      border-radius: 8px;
      border: 1px solid white;
      cursor: pointer;
      font-size: 1.2rem;
      transition: 0.3s;
    }
    .content-button:hover {
      background-color: white;
      color: black;
    }
    .back-button {
      margin: 1rem 0;
      background: #333;
      color: white;
      padding: 8px 20px;
      border-radius: 5px;
      border: none;
      cursor: pointer;
    }
    .content-card {
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
      padding: 2rem;
      border-radius: 12px;
      border: 1px solid transparent;
      cursor: pointer;
      font-size: 1.5rem;
      transition: 0.3s;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
    .content-card:hover {
      border-color: white;
    }
    .card-icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .center-buttons {
  display: flex;
  gap: 3vw;
  justify-content: center;
  align-items: center;
  margin-top: 3rem;
}

.content-card {
  width: 320px;
  height: 220px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border-radius: 18px;
  border: none;
  box-shadow: 0 8px 32px rgba(0,0,0,0.25);
  font-size: 2rem;
  color: #fff;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  background-size: cover;
  background-position: center;
  transition: transform 0.2s, box-shadow 0.2s;
}

.content-card .card-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  text-shadow: 0 2px 12px rgba(0,0,0,0.5);
}

.content-card .card-title {
  font-size: 1.5rem;
  font-weight: bold;
  text-shadow: 0 2px 12px rgba(0,0,0,0.5);
}

.content-card:hover {
  transform: translateY(-8px) scale(1.04);
  box-shadow: 0 16px 40px rgba(0,0,0,0.35);
  opacity: 0.95;
}

/* Photo card background */
.photo-card {
  background-image: url('https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=600&q=80');
}

/* Video card background */
.video-card {
  background-image: url('https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80');
}
  </style>
</head>
<body>

  <!-- Background Video -->
  <div class="video-background">
    <video autoplay muted loop playsinline id="myVideo">
      <source src="background.MP4" type="video/mp4">
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

  <!-- Main -->
  <main style=" position: relative; z-index: 1;">
    <section class="services-section" style="background-color: rgba(0,0,0,0.1); padding: 3rem 10%; border-radius: 12px;">
      <h2>Our Services</h2>
      <p style="text-align: center;">Choose the type of content you want to view</p>

      <!-- Selection Buttons as Cards -->
      <div class="center-buttons" id="selection-buttons">
        <button class="content-card photo-card" onclick="showContent('photo')">
          <span class="card-icon"><i class="fas fa-camera"></i></span>
          <span class="card-title">Photo Content</span>
        </button>
        <button class="content-card video-card" onclick="showContent('video')">
          <span class="card-icon"><i class="fas fa-video"></i></span>
          <span class="card-title">Video Content</span>
        </button>
      </div>

      <!-- Photo Content -->
      <div id="photo-content" class="hidden">
        <button class="back-button" onclick="goBack()">← Back</button>
        <h3 style="color: white;">Photo Content</h3>
        <div class="media-grid">
          <?php while ($photo = mysqli_fetch_assoc($photos)): ?>
            <div class="media-item">
              <img src="<?= htmlspecialchars($photo['image_path']) ?>" alt="<?= htmlspecialchars($photo['title']) ?>" class="media-thumb">
              <h4><?= htmlspecialchars($photo['title']) ?></h4>
              <p><?= nl2br(htmlspecialchars($photo['description'])) ?></p>
            </div>
          <?php endwhile; ?>
        </div>
      </div>

      <!-- Video Content -->
      <div id="video-content" class="hidden">
        <button class="back-button" onclick="goBack()">← Back</button>
        <h3 style="color: white;">Video Content</h3>
        <div class="media-grid">
          <?php while ($video = mysqli_fetch_assoc($videos)): ?>
            <div class="media-item">
              <iframe class="media-thumb" src="<?= htmlspecialchars($video['youtube_url']) ?>" frameborder="0" allowfullscreen></iframe>
              <h4><?= htmlspecialchars($video['title']) ?></h4>
              <p><?= nl2br(htmlspecialchars($video['description'])) ?></p>
            </div>
          <?php endwhile; ?>
        </div>
      </div>

    </section>
  </main>

  <!-- Script -->
  <script>
    function showContent(type) {
      document.getElementById("selection-buttons").style.display = "none";
      document.getElementById(type + "-content").classList.remove("hidden");
    }

    function goBack() {
      document.getElementById("photo-content").classList.add("hidden");
      document.getElementById("video-content").classList.add("hidden");
      document.getElementById("selection-buttons").style.display = "flex";
    }

    const navToggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');
  let menuOpen = false;

  navToggle.onclick = function() {
    if (!menuOpen) {
      navLinks.style.right = '5px';
      menuOpen = true;
    } else {
      navLinks.style.right = '-300px';
      menuOpen = false;
    }
  };
  </script>
</body>
</html>
