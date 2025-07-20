<?php
session_start();
include("conn.php");

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: admin.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login - LBN Production</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="style.css"/>
  <style>
    body {
      background: #181818;
      color: #fff;
      font-family: 'Poppins', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .login-container {
      background: rgba(30,30,30,0.95);
      padding: 2.5rem 2rem 2rem 2rem;
      border-radius: 18px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.35);
      width: 340px;
      max-width: 90vw;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .login-container h2 {
      margin-bottom: 1.5rem;
      color: #00ff88;
      font-weight: bold;
      letter-spacing: 1px;
    }
    .login-container input {
      width: 100%;
      padding: 0.7rem 1rem;
      margin-bottom: 1rem;
      border-radius: 8px;
      border: 1px solid #444;
      background: #222;
      color: #fff;
      font-size: 1rem;
      outline: none;
      transition: border 0.2s;
    }
    .login-container input:focus {
      border-color: #FFA500;
    }
    .login-container button {
      width: 100%;
      padding: 0.7rem 1rem;
      background: linear-gradient(90deg, #00ff88 60%, #FFA500 100%);
      color: #222;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background 0.3s, color 0.3s;
    }
    .login-container button:hover {
      background: linear-gradient(90deg, #FFA500 60%, #00ff88 100%);
      color: #000;
    }
    .login-container .error {
      color: orange;
      margin-bottom: 1rem;
      text-align: center;
    }
  </style>
</head>
<body>
  <form class="login-container" method="POST" autocomplete="off">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
      <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <input type="text" name="username" placeholder="Username" required autofocus>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</body>
</html>