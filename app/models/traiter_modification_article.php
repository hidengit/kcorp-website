<?php
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Méthode non autorisée.");
}

// Récupération des données
$id = (int) $_POST['id'];
$titre = trim($_POST['titre']);
$contenu = trim($_POST['contenu']);
$video_url = trim($_POST['video_url']);
$champions = json_decode($_POST['champions_json'], true);

if (!$id || empty($titre) || empty($contenu) || empty($video_url) || !is_array($champions)) {
    die("Champs invalides ou incomplets.");
}

if (count($champions) !== 5) {
    die("Il faut exactement 5 champions sélectionnés.");
}

$db = new Database();
$pdo = $db->getPDO();

// 1. Mise à jour de l'article
$stmt = $pdo->prepare("UPDATE articles SET titre = ?, contenu = ?, video_url = ? WHERE id = ?");
$stmt->execute([$titre, $contenu, $video_url, $id]);

// 2. Suppression des anciennes associations
$pdo->prepare("DELETE FROM article_champion WHERE id_article = ?")->execute([$id]);

// 3. Ajout des nouvelles associations
foreach ($champions as $nomChampion) {
    // Récupérer l'ID du champion (ou l'ajouter s’il n’existe pas)
    $stmt = $pdo->prepare("SELECT id FROM champions WHERE nom = ?");
    $stmt->execute([$nomChampion]);
    $id_champion = $stmt->fetchColumn();

    if (!$id_champion) {
        $stmt = $pdo->prepare("INSERT INTO champions (nom) VALUES (?)");
        $stmt->execute([$nomChampion]);
        $id_champion = $pdo->lastInsertId();
    }

    // Insertion dans la table de liaison
    $stmt = $pdo->prepare("INSERT INTO article_champion (id_article, id_champion) VALUES (?, ?)");
    $stmt->execute([$id, $id_champion]);
}

echo "L’article a bien été modifié.<br><a href='../controllers/liste_articles.php'>Retour à la liste</a>";