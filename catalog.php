<?php
session_start();
function getSavedProjects($userId)
{
  $file = "saves/user_{$userId}.json";
  return $userId && file_exists($file) ? (json_decode(file_get_contents($file), true) ?? []) : [];
}
$savedProjects = getSavedProjects($_SESSION['user_id'] ?? null);
$projects = json_decode(file_get_contents('data/ideas.json'), true)['projects'] ?? [];
$filterType = $_GET['type'] ?? '';
$filterCategory = $_GET['category'] ?? '';
$filterFeature = $_GET['feature'] ?? '';
$filterDifficulty = $_GET['difficulty'] ?? '';
$filteredProjects = array_values(array_filter($projects, function ($project) use ($filterType, $filterCategory, $filterFeature, $filterDifficulty) {
  return (!$filterType || $project['type'] === $filterType) && (!$filterCategory || $project['category'] === $filterCategory) && (!$filterDifficulty || $project['difficulty'] === $filterDifficulty) && (!$filterFeature || in_array($filterFeature, $project['features']));
}));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catalog</title>
  <link rel="stylesheet" href="style/base_catalog.css">
  <link rel="stylesheet" href="style/switch.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="style/expand.css">
  <script src="node.js" defer></script>
</head>

<body>
  <div class="main">
    <div class="navbar">
      <div class="nav_left"><a class="link" href="index.php">SiteStarter</a></div>
      <div class="nav_mid"><a class="link" href="resources.php">Resources</a><a class="link active" href="catalog.php">Catalog</a><a class="link" href="saved.php">Saved</a></div>
      <div class="nav_right"><?php if (!isset($_SESSION['user_id'])): ?><a class="link" href="login.php"><i class="fas fa-user"></i> Login</a><?php else: ?><a class="link" href="profile.php"><i class="fas fa-user"></i>Profile</a><?php endif; ?><button id="theme-toggle" class="toggle-btn" aria-pressed="false"><span class="knob"></span></button></div>
    </div>
    <div class="catalog">
      <aside class="filters">
        <form method="GET" action="catalog.php">
          <?php $sections = ['Type' => ['type' => ['Frontend', 'Fullstack']], 'Features' => ['feature' => ['API', 'Database', 'Authentication', 'Payment', 'Real-time', 'Analytics']], 'Category' => ['category' => ['Personal', 'Creative', 'Productivity', 'E-commerce', 'Lifestyle', 'Health', 'Education', 'Finance', 'Entertainment']], 'Difficulty' => ['difficulty' => ['Beginner', 'Intermediate', 'Advanced']]];
          foreach ($sections as $heading => $sets): foreach ($sets as $field => $options): $selected = ${'filter' . ucfirst($field)} ?? ''; ?><div class="filter-section">
                <h3 class="filter-title"><?= htmlspecialchars($heading) ?><button type="button" class="expand-button collapsed" aria-label="Expand"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="18 15 12 9 6 15" />
                    </svg></button></h3>
                <div class="filter-options collapsed">
                  <div class="filter-option"><input type="radio" id="<?= $field ?>-all" name="<?= $field ?>" value="" <?= $selected === '' ? 'checked' : '' ?>><label for="<?= $field ?>-all">All</label></div><?php foreach ($options as $option): $id = strtolower(str_replace([' ', '-'], '', $option)); ?><div class="filter-option"><input type="radio" id="<?= $field ?>-<?= $id ?>" name="<?= $field ?>" value="<?= htmlspecialchars($option) ?>" <?= $selected === $option ? 'checked' : '' ?>><label for="<?= $field ?>-<?= $id ?>"><?= htmlspecialchars($option) ?></label></div><?php endforeach; ?>
                </div>
              </div><?php endforeach;
                endforeach; ?>
          <div class="filter-actions"><button class="filter-btn apply-btn">Apply</button><a href="catalog.php" class="filter-btn clear-btn">Clear</a></div>
        </form>
      </aside>
      <main class="catalog-projects"><?php foreach ($filteredProjects as $project): $isSaved = in_array($project['name'], $savedProjects); ?><article class="project"><button class="save-btn" data-project="<?= htmlspecialchars($project['name'], ENT_QUOTES, 'UTF-8') ?>" data-saved="<?= $isSaved ? 'true' : 'false' ?>"><i class="<?= $isSaved ? 'fas' : 'far' ?> fa-bookmark"></i></button>
            <div class="name"><?= htmlspecialchars($project['name']) ?></div>
            <div class="description">
              <div class="desc">Description: <br></div><?= htmlspecialchars($project['description']) ?>
            </div>
            <div class="tags">
              <div class="tag">Tags: <br></div><?= htmlspecialchars(implode(', ', $project['tags'])) ?>
            </div>
            <div class="languages">
              <div class="lang">Languages: <br></div><?= htmlspecialchars(implode(', ', $project['lang'])) ?>
            </div>
            <div class="difficulty">
              <div class="diff">Difficulty: </div><?= htmlspecialchars($project['difficulty']) ?>
            </div><?php foreach ($project['links'] as $i => $link): ?><a class="btn" href="<?= htmlspecialchars($link) ?>"><?= htmlspecialchars($project['linkNames'][$i]) ?></a><?php endforeach; ?>
          </article><?php endforeach;
                                      if (!$filteredProjects): ?><div class="no-results"><i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i><br>No projects found. Try different filters.</div><?php endif; ?></main>
    </div>
  </div>
</body>

</html>