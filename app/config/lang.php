<?php
session_start();

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$lang = $_SESSION['lang'] ?? 'fr';

$lang_file = __DIR__ . '/../../public/lang/' . $lang . '.php';

if (file_exists($lang_file)) {
    $traduction = require $lang_file;
} else {
    $traduction = require __DIR__ . '/../../public/lang/fr.php';

}

function getLangSwitchUrls() {
    $params = $_GET;
    $params_fr = $params;
    $params_en = $params;

    $params_fr['lang'] = 'fr';
    $params_en['lang'] = 'en';

    $currentPage = basename($_SERVER['PHP_SELF']);

    return [
        'fr' => $currentPage . '?' . http_build_query($params_fr),
        'en' => $currentPage . '?' . http_build_query($params_en),
    ];
}

$lang_urls = getLangSwitchUrls();