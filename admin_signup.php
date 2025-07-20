<?php
include("conn.php");
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if (empty($username) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM admin_users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hash);
            if ($stmt->execute()) {
                $success = "Admin account created! You can now <a href='admin_login.php'>login</a>.";
            } else {
                $error = "Error creating account.";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Signup</title>
    <style>
        body { background: #181818; color: #fff; font-family: 'Poppins', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .signup-container { background: rgba(30,30,30,0.95); padding: 2rem; border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.35); width: 340px; max-width: 90vw; }
        .signup-container h2 { color: #00ff88; margin-bottom: 1.5rem; }
        .signup-container input { width: 100%; padding: 0.7rem 1rem; margin-bottom: 1rem; border-radius: 8px; border: 1px solid #444; background: #222; color: #fff; font-size: 1rem; }
        .signup-container button { width: 100%; padding: 0.7rem 1rem; background: linear-gradient(90deg, #00ff88 60%, #FFA500 100%); color: #222; font-weight: bold; border: none; border-radius: 8px; font-size: 1.1rem; cursor: pointer; }
        .signup-container .error { color: orange; margin-bottom: 1rem; }
        .signup-container .success { color: #00ff88; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <form class="signup-container" method="POST" autocomplete="off">
        <h2>Admin Signup</h2>
        <?php if ($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
        <?php if ($success): ?><div class="success"><?php echo $success; ?></div><?php endif; ?>
        <input type="text" name="username" placeholder="Username" required autofocus>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm" placeholder="Confirm Password" required>
        <button type="submit">Sign Up</button>
    </form>
</body>
</html>