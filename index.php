<?php
require 'menu.php';

$menuHtml = renderMenu();
$content = '';

$p = $_GET['p'] ?? 'viewer';
$allowed = ['viewer', 'add', 'edit', 'delete'];

if (!in_array($p, $allowed)) {
    $p = 'viewer';
}

if ($p === 'viewer') {
    include 'viewer.php';
    $sort = $_GET['sort'] ?? 'byid';
    $page = isset($_GET['pg']) && is_numeric($_GET['pg']) && $_GET['pg'] >= 0 ? (int)$_GET['pg'] : 0;
    $content = getContactsList($sort, $page);
} else {
    if (file_exists($p . '.php')) {
        include $p . '.php';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="/lab9/style.css">
</head>
<body>
    <?php echo $menuHtml; ?>
    <div class="content">
        <?php echo $content; ?>
    </div>
</body>
</html>