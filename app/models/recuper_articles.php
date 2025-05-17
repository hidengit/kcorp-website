<?php
require_once 'app/config/database.php';
function getYoutubeId($url) {
    preg_match('/(?:v=|\/)([0-9A-Za-z_-]{11})/', $url, $matches);
    return $matches[1] ?? null;
}

if (!isset($_GET['champion']) || empty($_GET['champion'])) {
    die("Aucun champion sélectionné.");
}

$champion_nom = trim($_GET['champion']);
$db = new Database();
$pdo = $db->getPDO();

// ID du champion recherché
$stmt = $pdo->prepare("SELECT id FROM champions WHERE nom = ?");
$stmt->execute([$champion_nom]);
$id_champion = $stmt->fetchColumn();

if (!$id_champion) {
    die("Champion introuvable : " . htmlspecialchars($champion_nom));
}

// Articles associés à ce champion
$sql = "
SELECT a.id, a.titre, a.contenu, a.date_publication, a.video_url
FROM articles a
JOIN article_champion ac ON a.id = ac.id_article
WHERE ac.id_champion = ?
ORDER BY a.date_publication DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_champion]);
$articles = $stmt->fetchAll();

// On va maintenant aussi récupérer les champions associés à chaque article
$champions_par_article = [];
foreach ($articles as $article) {
    $stmt = $pdo->prepare("
        SELECT c.nom FROM article_champion ac
        JOIN champions c ON c.id = ac.id_champion
        WHERE ac.id_article = ?
    ");
    $stmt->execute([$article['id']]);
    $champions_par_article[$article['id']] = array_column($stmt->fetchAll(), 'nom');
}