<?php
require '../config/database.php';

if (isset($_GET['query'])) {
    $db = new Database();
    $pdo = $db->getPDO();

    $sql = "SELECT nom, riot_key FROM champions WHERE LOWER(nom) LIKE ? LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([strtolower($_GET['query']) . '%']);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
}
?>