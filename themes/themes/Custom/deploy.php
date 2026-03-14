<?php
define('SECRET_TOKEN', 'nigiwaifesta_deploy_2026');
define('GITHUB_RAW', 'https://raw.githubusercontent.com/Takuya-masutani/nakano-nigiwai-hp/main/themes/themes/Custom');

if (($_GET['token'] ?? '') !== SECRET_TOKEN) {
    http_response_code(403);
    die('Unauthorized');
}

$files = [
    'customcss.css', 'style.css', 'footer.php', 'functions.php',
    'header.php', 'single.php', 'sub-head.php',
    'inc/views/main/class-hestia-footer.php',
    'inc/views/main/class-hestia-header.php',
    'inc/views/blog/class-hestia-additional-views.php',
    'inc/views/blog/class-hestia-header-layout-manager.php',
];

foreach ($files as $file) {
    $content = file_get_contents(GITHUB_RAW . '/' . $file . '?nocache=' . time());
    if ($content === false) { echo "FAIL: $file\n"; continue; }
    $local = __DIR__ . '/' . $file;
    $dir = dirname($local);
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    file_put_contents($local, $content) !== false ? print("OK: $file\n") : print("FAIL write: $file\n");
}
echo "完了";
