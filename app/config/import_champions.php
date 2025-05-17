<?php
require 'database.php';

function importChampionsFromRiotAPI() {
    $db = new Database();
    $pdo = $db->getPDO();

    // Récupération des champions via l'API Riot
    $url = "https://ddragon.leagueoflegends.com/cdn/15.7.1/data/en_US/champion.json";
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    if (!$data || !isset($data['data'])) {
        die("Erreur : Impossible de récupérer les champions.");
    }
    
    $sql = "INSERT OR IGNORE INTO champions (nom, riot_key) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    
    foreach ($data['data'] as $champKey => $champInfo) {
        $stmt->execute([$champInfo['name'], $champKey]);  // On stocke aussi champKey
    }

    echo "Importation terminée.";
}

// Lancer l'importation
importChampionsFromRiotAPI();
?>