<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UniqueProduction Admin Panel</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <?php
  session_start();
  include("conn.php");

  if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
      header("Location: admin_login.php");
      exit();
  }

  // PHOTO UPLOAD
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['upload_photo'])) {
      $title = $_POST['photo_title'];
      $description = $_POST['photo_description'];
      $file = $_FILES['photo_file'];

      if ($file['error'] === 0) {
          $uploadDir = "uploads/photos/";
          if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
          $uploadPath = $uploadDir . basename($file["name"]);

          if (move_uploaded_file($file["tmp_name"], $uploadPath)) {
              $stmt = $conn->prepare("INSERT INTO photos (title, description, image_path) VALUES (?, ?, ?)");
              $stmt->bind_param("sss", $title, $description, $uploadPath);
              $stmt->execute();
              $stmt->close();
              echo "<script>alert('Photo uploaded successfully');</script>";
          }
      }
  }

  // VIDEO UPLOAD
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['upload_video'])) {
      $title = $_POST['video_title'];
      $description = $_POST['video_description'];
      $youtube_url = $_POST['video_url'];

      $stmt = $conn->prepare("INSERT INTO videos (title, description, youtube_url) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $title, $description, $youtube_url);
      $stmt->execute();
      $stmt->close();
      echo "<script>alert('Video uploaded successfully');</script>";
  }

  // PORTFOLIO UPLOAD
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['upload_portfolio'])) {
      $title = $_POST['portfolio_title'];
      $description = $_POST['portfolio_description'];
      $file = $_FILES['portfolio_file'];

      if ($file['error'] === 0) {
          $uploadDir = "uploads/portfolio/";
          if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
          $uploadPath = $uploadDir . basename($file["name"]);

          if (move_uploaded_file($file["tmp_name"], $uploadPath)) {
              $stmt = $conn->prepare("INSERT INTO portfolio (title, description, image_path) VALUES (?, ?, ?)");
              $stmt->bind_param("sss", $title, $description, $uploadPath);
              $stmt->execute();
              $stmt->close();
              echo "<script>alert('Portfolio item uploaded successfully');</script>";
          }
      }
  }

  // DELETE PHOTO
  if (isset($_GET['delete_photo'])) {
      $id = $_GET['delete_photo'];
      $conn->query("DELETE FROM photos WHERE id=$id");
      echo "<script>alert('Photo deleted');window.location='admin.php';</script>";
  }

  // DELETE VIDEO
  if (isset($_GET['delete_video'])) {
      $id = $_GET['delete_video'];
      $conn->query("DELETE FROM videos WHERE id=$id");
      echo "<script>alert('Video deleted');window.location='admin.php';</script>";
  }

  // DELETE PORTFOLIO
  if (isset($_GET['delete_portfolio'])) {
      $id = $_GET['delete_portfolio'];
      $conn->query("DELETE FROM portfolio WHERE id=$id");
      echo "<script>alert('Portfolio item deleted');window.location='admin.php';</script>";
  }

  // Mark message as pending
  if (isset($_GET['pending_message'])) {
      $id = intval($_GET['pending_message']);
      $conn->query("UPDATE userdetails SET status='pending' WHERE id=$id");
      echo "<script>window.location='admin.php';</script>";
  }

  // Delete message
  if (isset($_GET['delete_message'])) {
      $id = intval($_GET['delete_message']);
      $conn->query("DELETE FROM userdetails WHERE id=$id");
      echo "<script>window.location='admin.php';</script>";
  }

  // Mark message as read
  if (isset($_GET['read_message'])) {
      $id = intval($_GET['read_message']);
      $conn->query("UPDATE userdetails SET status='read' WHERE id=$id");
      header("Location: admin.php");
      exit();
  }

  $changePassMsg = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
      $old = $_POST['old_password'];
      $new = $_POST['new_password'];
      $confirm = $_POST['confirm_password'];
      $username = $_SESSION['admin_username'];

      if (empty($old) || empty($new) || empty($confirm)) {
          $changePassMsg = "All fields are required.";
      } elseif ($new !== $confirm) {
          $changePassMsg = "New passwords do not match.";
      } elseif (strlen($new) < 6) {
          $changePassMsg = "New password must be at least 6 characters.";
      } else {
          $stmt = $conn->prepare("SELECT password_hash FROM admin_users WHERE username=?");
          $stmt->bind_param("s", $username);
          $stmt->execute();
          $stmt->bind_result($hash);
          if ($stmt->fetch() && password_verify($old, $hash)) {
              $stmt->close();
              $newHash = password_hash($new, PASSWORD_DEFAULT);
              $stmt = $conn->prepare("UPDATE admin_users SET password_hash=? WHERE username=?");
              $stmt->bind_param("ss", $newHash, $username);
              if ($stmt->execute()) {
                  $changePassMsg = "Password changed successfully!";
              } else {
                  $changePassMsg = "Error updating password.";
              }
          } else {
              $changePassMsg = "Current password is incorrect.";
          }
          $stmt->close();
      }
  }
  ?>

  <div class="layout">
    <aside class="sidebar">
      <div class="brand" >🎬 UniqueProduction</div>
      <nav>
        <ul>
          <li class="active" onclick="showTab('userMessages', this)">Messages</li>
          <li onclick="showTab('photos', this)">Photos</li>
          <li onclick="showTab('videos', this)">Videos</li>
          <li onclick="showTab('portfolio', this)">Portfolio</li>
          <li onclick="showTab('changePassword', this)">Change Password</li>
        </ul>
      </nav>
    </aside>

    <main class="main">
      <header class="header">
        <h2>Admin Dashboard</h2>
        <a href="logout.php" style="color:#FFA500;float:right;margin:1rem;">Logout</a>
      </header>

      <!-- User Messages Tab -->
      <section id="userMessages" class="tab active">
        <h3>Contact Form Submissions</h3>
        <div id="messageList" class="machinery-list">
          <?php
          $result = mysqli_query($conn, "SELECT * FROM userdetails ORDER BY submitted_at DESC");
          while($row = mysqli_fetch_assoc($result)) {
              echo "<div class='machinery-item'>
                <h4>" . htmlspecialchars($row['name']) . "</h4>
                <p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>
                <p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>
                <p><strong>Subject:</strong> " . htmlspecialchars($row['subject']) . "</p>
                <p><strong>Message:</strong> " . nl2br(htmlspecialchars($row['message'])) . "</p>
                <p><em>Submitted: " . $row['submitted_at'] . "</em></p>
                <p>Status: <span style='color:" . ($row['status']=='pending'?'orange':'#00ff88') . ";font-weight:bold;'>" . ucfirst($row['status']) . "</span></p>
                <a href='?pending_message=" . $row['id'] . "' onclick='return confirm(\"Mark as pending?\")' style='color:orange;margin-right:1rem;'>Pending</a>
                <a href='?delete_message=" . $row['id'] . "' onclick='return confirm(\"Delete this message permanently?\")' style='color:red;'>Delete</a>
                <a href='?read_message=" . $row['id'] . "' onclick='return confirm(\"Mark as read?\")' style='color:#00ff88;margin-right:1rem;'>Read</a>
              </div>";
          }
          ?>
        </div>
      </section>

      <!-- Photos Tab -->
      <section id="photos" class="tab">
        <h3>Upload Photos</h3>
        <form class="machinery-form" method="POST" enctype="multipart/form-data">
          <input type="text" name="photo_title" placeholder="Photo Title" required />
          <input type="text" name="photo_description" placeholder="Description" required />
          <input type="file" name="photo_file" accept="image/*" required />
          <button type="submit" name="upload_photo">Upload Photo</button>
        </form>

        <div class="machinery-list">
          <?php
          $photos = mysqli_query($conn, "SELECT * FROM photos ORDER BY uploaded_at DESC");
          while ($row = mysqli_fetch_assoc($photos)) {
              echo "<div class='machinery-item'>
                <img src='" . $row['image_path'] . "' alt='Photo' />
                <h4>" . htmlspecialchars($row['title']) . "</h4>
                <p>" . htmlspecialchars($row['description']) . "</p>
                <a href='?delete_photo=" . $row['id'] . "' onclick='return confirm(\"Delete this photo?\")'>Delete</a>
              </div>";
          }
          ?>
        </div>
      </section>

      <!-- Videos Tab -->
      <section id="videos" class="tab">
        <h3>Upload Videos</h3>
        <form class="machinery-form" method="POST">
          <input type="text" name="video_title" placeholder="Video Title" required />
          <input type="text" name="video_description" placeholder="Description" required />
          <input type="url" name="video_url" placeholder="YouTube Video URL" required />
          <button type="submit" name="upload_video">Add Video</button>
        </form>

        <div class="machinery-list">
          <?php
          $videos = mysqli_query($conn, "SELECT * FROM videos ORDER BY uploaded_at DESC");
          while ($row = mysqli_fetch_assoc($videos)) {
              $vidId = '';
              parse_str(parse_url($row['youtube_url'], PHP_URL_QUERY), $params);
              if (isset($params['v'])) {
                  $vidId = $params['v'];
              }
              echo "<div class='machinery-item'>
                <h4>" . htmlspecialchars($row['title']) . "</h4>
                <p>" . htmlspecialchars($row['description']) . "</p>
                <iframe width='300' height='200' src='https://www.youtube.com/embed/" . $vidId . "' frameborder='0' allowfullscreen></iframe>
                <br><a href='?delete_video=" . $row['id'] . "' onclick='return confirm(\"Delete this video?\")'>Delete</a>
              </div>";
          }
          ?>
        </div>
      </section>

      <!-- Portfolio Tab -->
      <section id="portfolio" class="tab">
        <h3>Upload Portfolio Item</h3>
        <form class="machinery-form" method="POST" enctype="multipart/form-data">
          <input type="text" name="portfolio_title" placeholder="Portfolio Title" required />
          <input type="text" name="portfolio_description" placeholder="Description" required />
          <input type="file" name="portfolio_file" accept="image/*" required />
          <button type="submit" name="upload_portfolio">Upload Portfolio</button>
        </form>

        <div class="machinery-list">
          <?php
          $portfolios = mysqli_query($conn, "SELECT * FROM portfolio ORDER BY uploaded_at DESC");
          while ($row = mysqli_fetch_assoc($portfolios)) {
              echo "<div class='machinery-item'>
                <img src='" . $row['image_path'] . "' alt='Portfolio' />
                <h4>" . htmlspecialchars($row['title']) . "</h4>
                <p>" . htmlspecialchars($row['description']) . "</p>
                <a href='?delete_portfolio=" . $row['id'] . "' onclick='return confirm(\"Delete this portfolio item?\")'>Delete</a>
              </div>";
          }
          ?>
        </div>
      </section>

      <!-- Change Password Tab -->
      <section id="changePassword" class="tab">
        <h3>Change Password</h3>
        <form class="machinery-form" method="POST">
          <input type="password" name="old_password" placeholder="Current Password" required />
          <input type="password" name="new_password" placeholder="New Password" required />
          <input type="password" name="confirm_password" placeholder="Confirm New Password" required />
          <button type="submit" name="change_password">Change Password</button>
        </form>
        <?php if (isset($changePassMsg)): ?>
          <div style="color:orange;margin-top:1rem;"><?php echo $changePassMsg; ?></div>
        <?php endif; ?>
      </section>
    </main>
  </div>

  <script>
    function showTab(id, element) {
      document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
      document.getElementById(id).classList.add('active');
      document.querySelectorAll('.sidebar nav ul li').forEach(li => li.classList.remove('active'));
      if (element) element.classList.add('active');
    }
  </script>
</body>
</html>

<?php
// Run this ONCE to create your admin user, then delete or comment it out!
include("conn.php");
$username = 'admin';
$password = 'LNBproduction';
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hash);
$stmt->execute();
echo "Admin user created!";
?>
