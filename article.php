<?php
require_once 'app//models/recuperer_data_articles.php';
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($article['titre']) ?></title>
  <link rel="stylesheet" href="public/assets/css/article.css">
  <!-- <link rel="stylesheet" href="public/assets/css/styles.css"> -->

</head>
<body>

    <!-- Barre de navigation -->
    <?php include 'public/assets/php/nav.php'; ?>

  <div class="container">
    <h1><?= htmlspecialchars($article['titre']) ?></h1>

    <!-- Intégration vidéo YouTube -->
    <?php if (str_contains($article['video_url'], 'youtube.com') || str_contains($article['video_url'], 'youtu.be')): ?>
      <div class="video-container">
        <?php
          // Extract video ID from URL (youtube.com or youtu.be)
          preg_match('/(?:v=|\/)([0-9A-Za-z_-]{11})/', $article['video_url'], $matches);
          $video_id = $matches[1] ?? null;
        ?>
        <?php if ($video_id): ?>
          <iframe class="responsive-iframe" src="https://www.youtube.com/embed/<?= $video_id ?>" frameborder="0" allowfullscreen></iframe>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <!-- Affichage des champions associés -->
    <div class="content">
      <p class="champions"><?= $traduction['associated_champions'] ?> :</p>
      <div class="champion-list">
        <?php foreach ($champions as $champ): ?>
          <span><?= htmlspecialchars($champ) ?></span>
        <?php endforeach; ?>
      </div>

      <!-- Affichage du contenu de l'article -->
      <div>
        <p><?= nl2br(htmlspecialchars($article['contenu'])) ?></p>
      </div>
    </div>

    <!-- Affichage des commentaires -->
    <hr>
    <h2><?= $traduction['comments'] ?></h2>

    <div class="comment-section">
      <?php if (empty($commentaires)): ?>
        <p><?= $traduction['first_comment'] ?> !</p>
      <?php else: ?>
        <?php foreach ($commentaires as $com): ?>
          <div class="comment">
            <?php
            $date = new DateTime($com['date_publication']);
            $now = new DateTime();
            $diff = $now->diff($date);
            if ($diff->y > 0 || $diff->m > 0 || $diff->d > 7) {
                $formattedDate = $date->format('d/m/Y H:i');
            } elseif ($diff->d > 0) {
                $formattedDate = ($diff->d === 1) ? 'Il y a 1 jour' : 'Il y a ' . $diff->d . ' jours';
            } elseif ($diff->h > 0) {
                $formattedDate = ($diff->h === 1) ? 'Il y a 1 heure' : 'Il y a ' . $diff->h . ' heures';
            } elseif ($diff->i > 0) {
                $formattedDate = ($diff->i === 1) ? 'Il y a 1 minute' : 'Il y a ' . $diff->i . ' minutes';
            } else {
                $formattedDate = 'À l’instant';
            }
            ?>
            <strong><?= htmlspecialchars($com['pseudo']) ?></strong> (<?= $formattedDate ?>) :
            <p><?= nl2br(htmlspecialchars($com['contenu'])) ?></p>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Formulaire d'ajout de commentaire -->
    <hr>
    <h3><?= $traduction['comment'] ?></h3>
    <form action="app/models/ajouter_commentaire.php" method="POST" onsubmit="return validerCommentaire()" class="comment-form">
      <input type="hidden" name="id_article" value="<?= $id_article ?>">
      <label for="pseudo"><?= $traduction['pseudo'] ?></label><br>
      <input type="text" name="pseudo" id="pseudo" required><br><br>

      <label for="contenu"><?= $traduction['comment_single'] ?> :</label><br>
      <textarea name="contenu" id="contenu" rows="4" required></textarea><br><br>

      <button type="submit"><?= $traduction['send'] ?></button>
    </form>
  </div>

    <!-- Pied de page avec réseaux sociaux -->
    <?php include 'public/assets/php/footer.php'; ?>

    <!-- Include le script de validation du commentaire -->
    <script src="public/assets/js/validerCommentaire.js"></script>

</body>
</html>