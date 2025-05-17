<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Méthode non autorisée.");
}

$id_article = isset($_POST['id_article']) ? (int) $_POST['id_article'] : null;
$pseudo = trim($_POST['pseudo'] ?? '');
$contenu = trim($_POST['contenu'] ?? '');

if (!$id_article || empty($pseudo) || empty($contenu)) {
    die("Tous les champs sont obligatoires.");
}

$db = new Database();
$pdo = $db->getPDO();

// Insertion du commentaire
$stmt = $pdo->prepare("INSERT INTO commentaires (id_article, pseudo, contenu) VALUES (?, ?, ?)");
$stmt->execute([$id_article, $pseudo, $contenu]);

// Redirection vers l’article
header("Location: ../../article.php?id=" . $id_article);
exit;