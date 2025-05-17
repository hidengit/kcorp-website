<?php
require_once '../config/database.php';
require_once '../config/lang.php';

$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;

$db = new Database();
$pdo = $db->getPDO();

// Récupère les articles les plus récents
$stmt = $pdo->prepare("SELECT id, titre, contenu, video_url FROM articles ORDER BY date_publication DESC LIMIT 3 OFFSET ?");
$stmt->execute([$offset]);
$articles = $stmt->fetchAll();

function getYoutubeId($url) {
    preg_match('/(?:v=|\/)([0-9A-Za-z_-]{11})/', $url, $matches);
    return $matches[1] ?? null;
}

foreach ($articles as $article) {
    $videoId = getYoutubeId($article['video_url']);
    $thumbnail = $videoId
        ? "https://img.youtube.com/vi/$videoId/hqdefault.jpg"
        : "public/assets/images/tb.jpg";

    echo '<article>';
    echo '<img class="youtube-thumbnail" src="' . htmlspecialchars($thumbnail) . '" alt="Miniature">';
    echo '<h3>' . htmlspecialchars($article['titre']) . '</h3>';
    echo '<p>' . htmlspecialchars(mb_strimwidth($article['contenu'], 0, 100, '...')) . '</p>';
    echo '<a href="article.php?id=' . $article['id'] . '">' . $traduction['read_more_article'] . '</a>';
    echo '</article>';
}