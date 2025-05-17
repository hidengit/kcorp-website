<?php
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);
    $video_url = trim($_POST['video_url']);
    $champions = json_decode($_POST['champions_json'], true);

    if (count($champions) > 5) {
        die("Erreur : Vous ne pouvez associer que 5 champions maximum.");
    }

    $db = new Database();
    $pdo = $db->getPDO();

    // Insère l’article
    $stmt = $pdo->prepare("INSERT INTO articles (titre, contenu, video_url) VALUES (?, ?, ?)");
    $stmt->execute([$titre, $contenu, $video_url]);
    $id_article = $pdo->lastInsertId();

    foreach ($champions as $champ) {
        $nom = ucfirst(trim($champ));

        // Récupère l’ID du champion (ou le crée s’il n’existe pas)
        $stmt = $pdo->prepare("SELECT id FROM champions WHERE nom = ?");
        $stmt->execute([$nom]);
        $id_champion = $stmt->fetchColumn();

        if (!$id_champion) {
            $stmt = $pdo->prepare("INSERT INTO champions (nom) VALUES (?)");
            $stmt->execute([$nom]);
            $id_champion = $pdo->lastInsertId();
        }

        // Lien article ↔ champion
        $stmt = $pdo->prepare("INSERT INTO article_champion (id_article, id_champion) VALUES (?, ?)");
        $stmt->execute([$id_article, $id_champion]);
    }

    echo "Article ajouté avec succès.";
}
?>