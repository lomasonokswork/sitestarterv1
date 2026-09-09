<?php
session_start();

// This page assumes a logged-in user (it echoes $_SESSION['username']),
// but nothing was actually enforcing that — a signed-out visitor hitting
// profile.php directly would get a PHP warning and "Welcome, !".
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}


// One-time CSRF token for the delete form. delete.php must check
// $_POST['csrf_token'] against $_SESSION['csrf_token'] before deleting.
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile</title>
  <link rel="stylesheet" href="style/base_profile.css" />
  <link rel="stylesheet" href="style/switch.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
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
        <a class="link active" href="profile.php">
          <i class="fas fa-user" aria-hidden="true"></i>
          <?php echo isset($_SESSION['username']) ? 'Profile' : 'Account'; ?>
        </a>
        <button id="theme-toggle" class="toggle-btn" aria-pressed="false">
          <span class="knob"></span>
        </button>
      </div>
    </div>
    <div class="profile">
      <p>Welcome to your profile, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>!</p>
      <button class="logout-btn" type="button" onclick="window.location.href='logout.php'">
        Log Out <i class="fas fa-arrow-right" aria-hidden="true"></i>
      </button>
      <form method="POST" action="delete.php">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
        <button class="delete-btn" type="submit" onclick="return confirm('Are you sure? This cannot be undone!');">
          Delete Account
        </button>
      </form>
    </div>
  </div>
</body>

</html>
