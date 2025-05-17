<?php
require_once '../config/database.php';
$db = new Database();
$pdo = $db->getPDO();
$champions = $pdo->query("SELECT nom FROM champions ORDER BY nom")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un article</title>
    <style>
    .flex {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    .champion-box {
        border: 1px solid #ccc;
        padding: 10px;
        width: 200px;
        min-height: 150px;
        background-color: #f9f9f9;
    }
    .champion-box span {
        display: block;
        margin-bottom: 5px;
    }
    </style>
</head>
<body>
    <h1>Ajouter un article</h1>

    <form action="../models/traiter_article.php" method="POST" onsubmit="return validerFormulaire()">

    <label for="titre">Titre :</label><br>
    <input type="text" name="titre" required><br><br>

    <label for="contenu">Contenu :</label><br>
    <textarea name="contenu" rows="5" cols="50" required></textarea><br><br>

    <label for="video_url">URL YouTube :</label><br>
    <input type="text" name="video_url" required><br><br>

    <h3>Associer 5 champions</h3>
    <div class="flex">
    <div>
        <label for="searchChampion">Recherche :</label><br>
        <input type="text" id="searchChampion" placeholder="Tape un nom..."><br><br>

        <select id="championSelect">
        <?php foreach ($champions as $champion): ?>
            <option value="<?= htmlspecialchars($champion['nom']) ?>"><?= htmlspecialchars($champion['nom']) ?></option>
        <?php endforeach; ?>
        </select><br><br>

        <button type="button" onclick="ajouterChampion()">Ajouter ce champion</button>
    </div>

    <div class="champion-box" id="listeChampions">
        <strong>Champions sélectionnés :</strong>
        </div>
    </div>

    <!-- Champ caché qui contiendra la liste à envoyer en POST -->
    <input type="hidden" name="champions_json" id="champions_json">

    <br><br>
    <button type="submit">Ajouter l'article</button>
    </form>

    <script>
    const searchInput = document.getElementById('searchChampion');
    const select = document.getElementById('championSelect');
    const liste = document.getElementById('listeChampions');
    const hiddenInput = document.getElementById('champions_json');

    let championsChoisis = [];

    searchInput.addEventListener('keyup', function () {
        const query = this.value.toLowerCase();
        for (let option of select.options) {
        const nom = option.text.toLowerCase();
        option.style.display = nom.includes(query) ? '' : 'none';
    }
    });

    function ajouterChampion() {
        const selected = select.value;
        if (!selected) return;

        if (championsChoisis.length >= 5) {
        alert("Tu as déjà sélectionné 5 champions.");
        return;
    }

    if (championsChoisis.includes(selected)) {
        alert("Ce champion est déjà sélectionné.");
        return;
    }

    championsChoisis.push(selected);

    const champSpan = document.createElement('span');
    champSpan.textContent = selected;
    liste.appendChild(champSpan);

      hiddenInput.value = JSON.stringify(championsChoisis); // pour l'envoi POST
    }

    function validerFormulaire() {
        if (championsChoisis.length !== 5) {
        alert("Tu dois sélectionner exactement 5 champions.");
        return false;
    }
    return true;
    }
    </script>
</body>
</html>