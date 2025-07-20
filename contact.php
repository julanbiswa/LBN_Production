<?php
include("conn.php");

$errors = [];
$name = $email = $number = $subject = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['Uname']);
    $email = trim($_POST['Uemail']);
    $number = trim($_POST['Unumber']);
    $subject = trim($_POST['Usubject']);
    $message = trim($_POST['Umessage']);

    // Validate required fields
    if (empty($name) || empty($email) || empty($number) || empty($subject) || empty($message)) {
        $errors[] = "All fields are required.";
    }
    // Validate email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    // Validate Nepali phone number: starts with 98 or 97, 10 digits
    elseif (!preg_match('/^(98|97)\d{8}$/', $number)) {
        $errors[] = "Please enter a valid Nepali phone number (starts with 98 or 97, 10 digits).";
    }

    if (empty($errors)) {
        // Prepared statement to avoid SQL injection
        $stmt = $conn->prepare("INSERT INTO userdetails (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $number, $subject, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Message Submitted Successfully! Our team will get back you soon.'); window.location.href = 'contact.php';</script>";
            exit();
        } else {
            $errors[] = "Error inserting data.";
        }
        $stmt->close();
    }
}
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

   <!-- Contact Section -->
  <main class="main">
    <section style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 2rem;">
      
      <!-- Contact Form -->
      <div style="
  width: 320px;
  min-width: 220px;
  max-width: 500px;
  background: transparent;
  /* box-shadow: 0 8px 32px rgba(0,0,0,0.25); */
  /* padding: 1.2rem 1rem; */
  
  overflow: visible;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-item:center;
  height: auto;
">
  <h2 style="margin:1rem 3rem 1rem -3rem; font-size: 1.2rem;">Write to Us</h2>
  <form class="contact-form" method="POST" action="contact.php" style="display: flex; flex-direction: column; gap: 1rem;">
    <input class="c-inputfield" type="text" name="Uname" id="Uname" placeholder="Your Name" value="<?php echo htmlspecialchars($name); ?>">
    <input class="c-inputfield" type="email" id="email" name="Uemail" placeholder="Your Email" value="<?php echo htmlspecialchars($email); ?>">
    <input class="c-inputfield" type="text" id="number" name="Unumber" placeholder="Your Phone Number" value="<?php echo htmlspecialchars($number); ?>">
    <input class="c-inputfield" type="text" name="Usubject" id="Usubject" placeholder="Subject" value="<?php echo htmlspecialchars($subject); ?>">
    <textarea class="c-inputfield" name="Umessage" placeholder="Your Message" id="Umessage" style="resize: none; min-height: 60px; font-size: 0.95rem;"><?php echo htmlspecialchars($message); ?></textarea>
    
      <?php if (!empty($errors)): ?>
    <div style="color: orange; margin-bottom: 1rem;">
        <?php echo htmlspecialchars($errors[0]); ?>
    </div>
<?php endif; ?>
    <button type="submit" class="submit-button" style="text-align:center; height: 40px; font-size: 1rem; margin-top: 0.5rem;">Send Message</button>
    <p id="feedback"></p>
  </form>


</div>

      <!-- Contact Details -->
      <div style="flex: 1 1 40%; min-width: 300px;">
        <h2>Contact Information</h2>
        <p><strong>Address:</strong><br/>Tahachal-13, Kathmandu, Nepal</p>
        <p><strong>Phone:</strong> +977 9849961889</p>
        <p><strong>Email:</strong><br/>paradygmtv@gmail.com</p>
        <h3 style="margin-top: 1.5rem;">Follow Us</h3>
      </div>
      <div class="social-links" style="font-size: 1.5rem; gap: 1.5rem;">
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
      </div>

    </section>
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

