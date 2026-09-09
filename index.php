<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SiteStarter</title>
    <link rel="stylesheet" href="style/base_home.css" />
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
          <a class="link active" href="index.php">SiteStarter</a>
        </div>
        <div class="nav_mid">
          <a class="link" href="resources.php">Resources</a>
          <a class="link" href="catalog.php">Catalog</a>
          <a class="link" href="saved.php">Saved</a>
        </div>
        <div class="nav_right">
          <?php if (!isset($_SESSION['user_id'])): ?>
          <a class="link" href="login.php">
            <i class="fas fa-user"></i>Login
          </a>
          <?php else: ?>
            <a class="link" href="profile.php"><i class="fas fa-user"></i><?php if (isset($_SESSION['username'])) { echo "Profile"; }; ?></a>
            <?php endif; ?>
          <button id="theme-toggle" class="toggle-btn" aria-pressed="false">
            <span class="knob"></span>
          </button>
        </div>
      </div>
      <div class="main1">
        <div class="hero_section">
          <div class="main1_left">
            <img src="img/home.webp" alt="Project ideas inspiration" />
          </div>
          <div class="main1_right">
            <h1>Find Your Next Project</h1>
            <h2>Simple. Inspiring. Ready to Build.</h2>
            <p>
              Explore our collection of curated project ideas to kickstart your
              next build. Whether you're into websites, apps, or games, we've
              got inspiring ideas that will get you started right away.
            </p>
            <a href="catalog.php" class="explore_button">
              Browse Ideas <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>

        <div class="features_section">
          <div class="feature_card">
            <i class="fas fa-lightbulb"></i>
            <h3>Beginner Friendly</h3>
            <p>
              Find perfect starter projects that match your skill level and help
              you learn while building.
            </p>
          </div>

          <div class="feature_card">
            <i class="fas fa-layer-group"></i>
            <h3>Various Categories</h3>
            <p>
              Explore ideas across different categories - from simple utilities
              to full-featured applications.
            </p>
          </div>

          <div class="feature_card">
            <i class="fas fa-star"></i>
            <h3>Curated Selection</h3>
            <p>
              Each project idea is carefully selected to ensure it's practical,
              achievable, and worth building.
            </p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>