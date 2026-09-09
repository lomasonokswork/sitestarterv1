<?php
session_start();
include 'config.php';

$signupErrors = [];
$loginErrors = [];
if (isset($_POST['signup']) && $_POST['signup'] == 1) {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $verify = $_POST['verify'] ?? '';

if ($username === '') $signupErrors[] = "Enter a username.";
if (strlen($password) < 6) $signupErrors[] = "Password must be at least 6 characters long.";
if ($password !== $verify) $signupErrors[] = "Passwords do not match.";

if (empty($signupErrors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
if ($stmt->num_rows > 0) {
            $signupErrors[] = "Username already taken.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username,password_hash) VALUES (?,?)");
            $stmt->bind_param("ss", $username, $hash);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                $signupErrors[] = "Unable to create the account. Please try again.";
            }
        }
    }
}
}
if (isset($_POST['login']) && $_POST['login'] == 2) {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username === '' || $password === '') {
        $loginErrors[] = "Enter your username and password.";
  } else {
        $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username=? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $username, $hash);
        if ($stmt->fetch()) {
            if (password_verify($password, $hash)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                $loginErrors[] = "Wrong credentials.";
            }
        } else {
            $loginErrors[] = "Wrong credentials.";
        }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log in</title>
    <link rel="stylesheet" href="style/base_login.css" />
    <link rel="stylesheet" href="style/switch.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link rel="icon" type="image/x-icon" href="/img/image.png">
    <script src="node.js" defer></script>
  </head>
  <body>
    <div class="main">
      <div class="navbar">
        <div class="nav_left">
          <a class="link" href="index.php">SiteStarter</a>
        </div>
        <div class="nav_mid">
          <a class="link" href="resources.php">Resources</a>
          <a class="link" href="catalog.php">Catalog</a>
          <a class="link" href="saved.php">Saved</a>
        </div>
        <div class="nav_right">
          <?php if (!isset($_SESSION['user_id'])): ?>
          <a class="link active" href="login.php">
            <i class="fas fa-user"></i> Login
          </a>
          <?php else: ?>
            <a class="link" href="profile.php"><i class="fas fa-user"></i><?php if (isset($_SESSION['username'])) { echo "Profile"; }; ?></a>
            <?php endif; ?>
          <button id="theme-toggle" class="toggle-btn" aria-pressed="false">
            <span class="knob"></span>
          </button>
        </div>
      </div>

      <div class="login-wrap">
        <div class="login-hero">
          <h1>Welcome to SiteStarter</h1>
          <p>
            Sign in to save your favorite project ideas, or create an account
            to start building your collection.
          </p>
        </div>

        <div class="login">
          <div class="auth-card">
            <i class="fas fa-user-plus auth-icon"></i>
            <div class="login_h1">Sign Up</div>
            <p class="auth-subtitle">Create a free account in seconds.</p>

            <form method="POST" class="form signup-form" novalidate>
              <div class="form-group">
                <label for="signup-username">Username</label>
                <input
                  id="signup-username"
                  name="username"
                  type="text"
                  autocomplete="username"
                  required
                />
              </div>

              <div class="form-group">
                <label for="signup-password">Password</label>
                <input
                  id="signup-password"
                  name="password"
                  type="password"
                  autocomplete="new-password"
                  required
                />
              </div>

              <div class="form-group">
                <label for="signup-verify">Verify Password</label>
                <input
                  id="signup-verify"
                  name="verify"
                  type="password"
                  autocomplete="new-password"
                  required
                />
              </div>
              <?php foreach($signupErrors as $e) echo "<p class='form-error'>".htmlspecialchars($e)."</p>"; ?>
              <div class="form-actions">
                <button type="submit" name="signup" class="btn" value="1">Create account</button>
              </div>
            </form>
          </div>

          <div class="auth-card">
            <i class="fas fa-right-to-bracket auth-icon"></i>
            <div class="login_h1">Log In</div>
            <p class="auth-subtitle">Welcome back, pick up where you left off.</p>

            <form method="POST" class="form login-form" novalidate>
              <div class="form-group">
                <label for="login-username">Username</label>
                <input
                  id="login-username"
                  name="username"
                  type="text"
                  autocomplete="username"
                  required
                />
              </div>

              <div class="form-group">
                <label for="login-password">Password</label>
                <input
                  id="login-password"
                  name="password"
                  type="password"
                  autocomplete="current-password"
                  required
                />
              </div>
              <?php foreach($loginErrors as $e) echo "<p class='form-error'>".htmlspecialchars($e)."</p>";?>
              <div class="form-actions">
                <button type="submit" name="login" class="btn" value="2">Log in</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
