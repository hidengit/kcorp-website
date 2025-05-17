<?php
require_once '../config/database.php';
$db = new Database();
$pdo = $db->getPDO();

if (!isset($_GET['id'])) {
    die("Article non spécifié.");
}

$id_article = (int)$_GET['id'];

// Récupère les données de l'article
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id_article]);
$article = $stmt->fetch();

if (!$article) {
    die("Article introuvable.");
}

// Tous les champions
$champions = $pdo->query("SELECT nom FROM champions ORDER BY nom")->fetchAll();

// Champions liés à l'article
$stmt = $pdo->prepare("SELECT c.nom FROM article_champion ac JOIN champions c ON ac.id_champion = c.id WHERE ac.id_article = ?");
$stmt->execute([$id_article]);
$champions_associes = array_column($stmt->fetchAll(), 'nom');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un article</title>
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
        position: relative;
    }
    .champion-box span button {
        position: absolute;
        right: 0;
        top: 0;
        background: red;
        color: white;
        border: none;
        padding: 2px 6px;
        cursor: pointer;
    }
    </style>
</head>
<body>
    <h1>Modifier l'article</h1>

    <form action="../models/traiter_modification_article.php" method="POST" onsubmit="return validerFormulaire()">
    <input type="hidden" name="id" value="<?= $id_article ?>">

    <label for="titre">Titre :</label><br>
    <input type="text" name="titre" value="<?= htmlspecialchars($article['titre']) ?>" required><br><br>

    <label for="contenu">Contenu :</label><br>
    <textarea name="contenu" rows="5" cols="50" required><?= htmlspecialchars($article['contenu']) ?></textarea><br><br>

    <label for="video_url">URL YouTube :</label><br>
    <input type="text" name="video_url" value="<?= htmlspecialchars($article['video_url']) ?>" required><br><br>

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

    <input type="hidden" name="champions_json" id="champions_json">

    <br><br>
    <button type="submit">Enregistrer les modifications</button>
    </form>

    <script>
    const searchInput = document.getElementById('searchChampion');
    const select = document.getElementById('championSelect');
    const liste = document.getElementById('listeChampions');
    const hiddenInput = document.getElementById('champions_json');

    let championsChoisis = <?= json_encode($champions_associes) ?>;

    function afficherChampions() {
        liste.innerHTML = '<strong>Champions sélectionnés :</strong>';
        championsChoisis.forEach(nom => {
        const span = document.createElement('span');
        span.textContent = nom;

        const btn = document.createElement('button');
        btn.textContent = 'x';
        btn.onclick = () => supprimerChampion(nom);

        span.appendChild(btn);
        liste.appendChild(span);
        });
        hiddenInput.value = JSON.stringify(championsChoisis);
    }

    function ajouterChampion() {
        const selected = select.value;
        if (!selected || championsChoisis.includes(selected)) return;

        if (championsChoisis.length >= 5) {
        alert("Tu as déjà 5 champions.");
        return;
        }

        championsChoisis.push(selected);
        afficherChampions();
    }

    function supprimerChampion(nom) {
        championsChoisis = championsChoisis.filter(c => c !== nom);
        afficherChampions();
    }

    function validerFormulaire() {
        if (championsChoisis.length !== 5) {
        alert("Tu dois sélectionner exactement 5 champions.");
        return false;
        }
        return true;
    }

    searchInput.addEventListener('keyup', function () {
        const query = this.value.toLowerCase();
        for (let option of select.options) {
        const nom = option.text.toLowerCase();
        option.style.display = nom.includes(query) ? '' : 'none';
        }
    });

    afficherChampions();
    </script>
</body>
</html>
