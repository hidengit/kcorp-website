<?php include 'app/config/lang.php'; ?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $traduction['title'] ?></title>
    <link rel="stylesheet" href="public/assets/css/styles.css">

</head>
<body>
    <!-- Barre de navigation -->
    <?php include 'public/assets/php/nav.php'; ?>
    
    <!-- Section principale avec image et barre de recherche -->
    <section class="hero">
        <div class="hero-image">
            <div class="search-container">
                <form id="searchForm" action="search_results.php" method="GET">
                <input type="text" id="championSearch" name="champion" placeholder="<?= $traduction['search_placeholder'] ?>" aria-label="Rechercher un champion">
                    <div id="championResults"></div>
                </form>
            </div>
        </div>
    </section>
    
    <!-- Section Articles Récents -->
    <section class="articles">
        <h2><?= $traduction['recent_articles'] ?></h2>
        <div class="article-list" id="articleList"></div>
        <button id="loadMore"><?= $traduction['read_more'] ?></button>
    </section>
    
    <!-- Pied de page avec réseaux sociaux -->
    <?php include 'public/assets/php/footer.php'; ?>

    <!--Include le script de recherche -->
    <script src="public/assets/js/search.js"></script>

    <!--Include le script de load d'articles -->
    <script src="public/assets/js/loadArticles.js"></script>
</body>
</html>
