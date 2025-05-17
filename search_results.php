<?php
require_once 'app/config/lang.php';
require_once 'app/models/recuper_articles.php';
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats pour <?= htmlspecialchars($champion_nom) ?> - KCorp</title>
    <link rel="stylesheet" href="public/assets/css/styles.css">
</head>
<body>
<!-- Barre de navigation -->
<?php include 'public/assets/php/nav.php'; ?>

<!-- Section principale avec image et barre de recherche -->
<section class="hero-image2">
    <div class="hero-image2">
        <div class="search-container2">
            <form id="searchForm" action="search_results.php" method="GET">
                <input type="text" id="championSearch" name="champion" placeholder="<?= $traduction['search_placeholder'] ?>" value="<?= htmlspecialchars($champion_nom) ?>">
                <div id="championResults"></div>
            </form>
        </div>
    </div>
</section>

<!-- Section Article -->
<section class="articles">
    <h2><?= $traduction['articles_with'] ?> <?= htmlspecialchars($champion_nom) ?></h2>

    <div class="article-list">
        <?php if (empty($articles)): ?>
            <p>Aucun article trouvé pour ce champion.</p>
        <?php else: ?>
            <?php foreach ($articles as $article): ?>
                <article>
                    <?php $videoId = getYoutubeId($article['video_url'] ?? ''); ?>
                    <?php if ($videoId): ?>
                        <img class="youtube-thumbnail" src="https://img.youtube.com/vi/<?= $videoId ?>/hqdefault.jpg" alt="Miniature vidéo">
                    <?php else: ?>
                        <img src="public/assets/images/tb.jpg" alt="Miniature vidéo par défaut">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($article['titre']) ?></h3>
                    <p><?= htmlspecialchars(mb_strimwidth($article['contenu'], 0, 100, '...')) ?></p>

                    <div class="champion-list">
                        Champions :
                        <?php foreach ($champions_par_article[$article['id']] as $champ): ?>
                            <?php if ($champ === $champion_nom): ?>
                                <span class="highlight"><?= htmlspecialchars($champ) ?></span>
                            <?php else: ?>
                                <span><?= htmlspecialchars($champ) ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <a href="article.php?id=<?= $article['id'] ?>"><?= $traduction['read_more_article'] ?></a>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

    <!-- Pied de page avec réseaux sociaux -->
<?php include 'public/assets/php/footer.php'; ?>

    <!--Include le script de recherche -->
<script src="public/assets/js/search.js"></script>

</body>
</html>