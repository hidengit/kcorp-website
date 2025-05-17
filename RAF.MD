/kcorp-site/
│── /public/                   # Contient les fichiers accessibles par le navigateur
│   ├── index.php              # Page d'accueil (liste des articles & vidéos)
│   ├── search.php             # Page de recherche des champions
│   ├── article.php            # Page détaillée d’un article (avec commentaires)
│   ├── assets/                # Dossier des ressources statiques
│   │   ├── css/
│   │   │   ├── styles.css      # Feuille de styles principale
│   │   ├── js/
│   │   │   ├── main.js         # JavaScript principal (animations, interactions)
│   │   │   ├── ajax.js         # Requêtes AJAX (ex: "Voir plus de projets")
│   │   │   ├── validation.js   # Vérification des formulaires avant envoi
│   │   ├── images/             # Dossier des images et logos
│── /app/                      # Cœur du site (logique et gestion)
│   ├── /config/
│   │   ├── database.php        # Connexion PDO à la BDD SQLite
│   │   ├── config.php          # Paramètres globaux (langues, constantes)
│   ├── /models/                # Classes PHP pour la BDD
│   │   ├── Champion.php        # Classe pour gérer les champions
│   │   ├── Video.php           # Classe pour gérer les vidéos associées
│   │   ├── Comment.php         # Classe pour gérer les commentaires
│   ├── /controllers/           # Logique métier
│   │   ├── ChampionController.php  # Gestion de la recherche de champions
│   │   ├── VideoController.php     # Gestion des vidéos liées aux champions
│   │   ├── CommentController.php   # Gestion des commentaires (ajout, affichage)
│   ├── /views/                 # Fichiers HTML/PHP pour l'affichage
│   │   ├── header.php           # En-tête du site
│   │   ├── footer.php           # Pied de page
│   │   ├── champions-list.php   # Liste des champions joués par la KCorp
│   │   ├── video-list.php       # Liste des vidéos associées
│   │   ├── comment-section.php  # Section des commentaires sous les articles
│── /database/                   # Base de données SQLite
│   ├── database.sqlite          # Fichier SQLite contenant les champions et vidéos
│   ├── migrations/              # Scripts SQL pour créer/modifier la BDD
│── /lang/                       # Fichiers de traduction
│   ├── fr.php                   # Traductions en français
│   ├── en.php                   # Traductions en anglais
│── /tests/                      # Fichiers de tests (PHPUnit, vérifications)
│   ├── ChampionTest.php
│   ├── VideoTest.php
│── .gitignore                    # Fichiers à ignorer (database.sqlite, caches…)
│── README.md                     # Documentation du projet

📌 Explication des dossiers principaux :

✅ /public/ → Contient tous les fichiers accessibles via le navigateur.
✅ /app/ → Gère la logique métier et les classes PHP.
✅ /database/ → Stocke SQLite

et les scripts pour modifier la base.
✅ /views/ → Contient les fichiers HTML et PHP pour structurer les pages.
✅ /lang/ → Permet la gestion multilingue en PHP.
✅ /tests/ → Permet de tester les fonctionnalités du site avec PHPUnit.


A FAIRE : 
- [X] Créer un fichier README.md pour expliquer le projet et son installation. (api ddragon pour les versions lien)
- [X] Verification des formulaires avant envoi (validation.js)
- [X] Rendre plus lisible le code (ajouter des commentaires par exemple, faire des fichiers pour les .php et .js)
- [V] Tester l'affichage sur differents taille d'ecran
- [V] Rendre le site plus beau (ajouter des animations, des images, etc.)
- [X] Ajouter les liens ytb et twitch et X
- [X] Changer le bouton lire plus des aritcles
- [X] Bouton Kcorp sur la nav renvoie vers la page d'accueil
- [V] Footer bien en base de page
- [X] Modifier la date des commentaires pour qu'elle soit plus lisible
- [V] si le temps rendre plus beau les pages d'ajout d'articles etc
- [X] Faire la partie utilisation de la BDD sur le readme