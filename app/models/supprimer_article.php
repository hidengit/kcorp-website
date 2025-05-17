<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    die("Article non spécifié.");
}

$id = (int)$_GET['id'];
$db = new Database();
$pdo = $db->getPDO();

// Supprimer les liens
$pdo->prepare("DELETE FROM article_champion WHERE id_article = ?")->execute([$id]);
$pdo->prepare("DELETE FROM commentaires WHERE id_article = ?")->execute([$id]);

// Supprimer l'article
$pdo->prepare("DELETE FROM articles WHERE id = ?")->execute([$id]);

echo "Article supprimé avec succès.<br><a href='liste_articles.php'>Retour à la liste</a>";