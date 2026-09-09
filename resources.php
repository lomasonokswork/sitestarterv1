<?php
session_start();
$data = json_decode(file_get_contents('data/resources.json'), true);
$resources = $data['resources'];
$fonts = $resources['fonts'];
$color_schemes = $resources['color_schemes'];
$icons = $resources['icons'];
$images = $resources['images'];
if (isset($_POST['resource_type'])) $_SESSION['resource_type'] = $_POST['resource_type'];
elseif (!isset($_SESSION['resource_type'])) $_SESSION['resource_type'] = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover</title>
    <link rel="stylesheet" href="style/base_resources.css">
    <link rel="stylesheet" href="style/switch.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="node.js" defer></script>
</head>

<body>
    <div class="main">
        <div class="navbar">
            <div class="nav_left"><a class="link" href="index.php">SiteStarter</a></div>
            <div class="nav_mid"><a class="link active" href="resources.php">Resources</a><a class="link" href="catalog.php">Catalog</a><a class="link" href="saved.php">Saved</a></div>
            <div class="nav_right"><?php if (!isset($_SESSION['user_id'])): ?><a class="link" href="login.php"><i class="fas fa-user"></i> Login</a><?php else: ?><a class="link" href="profile.php"><i class="fas fa-user"></i>Profile</a><?php endif; ?><button id="theme-toggle" class="toggle-btn"><span class="knob"></span></button></div>
        </div>
        <div class="resources">
            <div class="sidebar">
                <form method="POST"><button name="resource_type" value="1" class="sidebar-item <?= $_SESSION['resource_type'] == 1 ? 'active' : '' ?>">Fonts</button><button name="resource_type" value="2" class="sidebar-item <?= $_SESSION['resource_type'] == 2 ? 'active' : '' ?>">Color Schemes</button><button name="resource_type" value="3" class="sidebar-item <?= $_SESSION['resource_type'] == 3 ? 'active' : '' ?>">Images</button><button name="resource_type" value="4" class="sidebar-item <?= $_SESSION['resource_type'] == 4 ? 'active' : '' ?>">Icons</button></form>
            </div>
            <div class="resources-main">
                <?php if ($_SESSION['resource_type'] == 1): ?><div class="info-box"><strong>How to use:</strong> Add @import url("URL") at the top of your CSS file, then use the font-family property in your styles.</div>
                    <div class="font-items"><?php foreach ($fonts as $f): ?><div class="font-item">
                                <h3 class="font-title" style="font-family: <?= htmlspecialchars($f['stylename']) ?>"><?= htmlspecialchars($f['name']) ?></h3>
                                <p class="font-description"><?= htmlspecialchars($f['text']) ?></p><button class="copy-btn" data-url="<?= htmlspecialchars($f['url']) ?>"><i class="fas fa-link"></i> Copy URL</button><button class="copy-btn" data-font="<?= htmlspecialchars($f['stylename']) ?>"><i class="fas fa-font"></i> Copy Font-Family</button>
                            </div><?php endforeach; ?></div><?php endif; ?>
                <?php if ($_SESSION['resource_type'] == 2): ?><div class="font-items"><?php foreach ($color_schemes as $c): ?><div class="font-item" style="background-color: <?= htmlspecialchars($c['colors']['background']) ?>">
                                <h3 class="color-title" style="color: <?= htmlspecialchars($c['colors']['text']) ?>"><?= htmlspecialchars($c['name']) ?></h3>
                                <p class="font-description" style="color: <?= htmlspecialchars($c['colors']['primary']) ?>"><?= htmlspecialchars($c['text']) ?></p>
                            </div><?php endforeach; ?></div><?php endif; ?>
                <?php if ($_SESSION['resource_type'] == 3 || $_SESSION['resource_type'] == 4): $items = $_SESSION['resource_type'] == 3 ? $images : $icons; ?><div class="info-box">Places where you can find good quality <?= $_SESSION['resource_type'] == 3 ? 'stock images' : 'icons' ?>.</div>
                    <div class="font-items"><?php foreach ($items as $i): ?><div class="font-item">
                                <h3 class="font-title"><?= htmlspecialchars($i['name']) ?></h3>
                                <p class="font-description"><?= htmlspecialchars($i['text']) ?></p><a class="copy-btn" href="<?= htmlspecialchars($i['url']) ?>">Take me there <i class="fas fa-arrow-right"></i></a>
                            </div><?php endforeach; ?></div><?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>