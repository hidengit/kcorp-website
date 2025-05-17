<?php
require_once '../config/database.php';
$db = new Database();
$pdo = $db->getPDO();

$articles = $pdo->query("SELECT * FROM articles ORDER BY date_publication DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des articles</title>
</head>
<body>
    <h1>Liste des articles</h1>

    <?php foreach ($articles as $article): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h2><?= htmlspecialchars($article['titre']) ?></h2>
        <p><strong>Vidéo :</strong> <?= htmlspecialchars($article['video_url']) ?></p>
        <p><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>

        <a href="modifier_article.php?id=<?= $article['id'] ?>">🖊 Modifier</a> |
        <a href="../models/supprimer_article.php?id=<?= $article['id'] ?>" onclick="return confirm('Confirmer la suppression de cet article ?')">🗑 Supprimer</a>
    </div>
    <?php endforeach; ?>
</body>
</html>