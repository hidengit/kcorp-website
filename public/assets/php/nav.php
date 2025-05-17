<?php
require_once __DIR__ . '/../../../app/config/lang.php';
?>

<header>
    <div class="logo">
        <a href="index.php">
            <img src="public/assets/images/logo.png" alt="Logo de la Karmine Corp">
        </a>
    </div>
    <div class="lang-switch">
        <a href="<?= $lang_urls['fr'] ?>"><img src="public/assets/images/fr.png" alt="Changer la langue en Français" width="24"></a>
        <a href="<?= $lang_urls['en'] ?>"><img src="public/assets/images/en.png" alt="Changer la langue en Anglais" width="24"></a>
    </div>
</header>
