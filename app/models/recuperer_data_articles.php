<?php
require_once 'app/config/database.php';

if (!isset($_GET['id'])) {
    die("Aucun article spécifié.");
}

$id_article = (int) $_GET['id'];
$db = new Database();
$pdo = $db->getPDO();

// 1. Récupère les infos de l’article
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id_article]);
$article = $stmt->fetch();

if (!$article) {
    die("Article introuvable.");
}

// 2. Récupère les champions associés
$stmt = $pdo->prepare("
    SELECT c.nom FROM article_champion ac
    JOIN champions c ON c.id = ac.id_champion
    WHERE ac.id_article = ?
");
$stmt->execute([$id_article]);
$champions = array_column($stmt->fetchAll(), 'nom');

// 3. Récupère les commentaires
$stmt = $pdo->prepare("SELECT pseudo, contenu, date_publication FROM commentaires WHERE id_article = ? ORDER BY date_publication DESC");
$stmt->execute([$id_article]);
$commentaires = $stmt->fetchAll();