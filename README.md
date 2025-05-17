# Projet programmation web 2

## 📝 Description

Ce projet est un site web dédié à la Karmine Corp, une équipe professionnelle française d’esport évoluant principalement sur League of Legends.  
Le site permet de retrouver les articles, vidéos et performances des joueurs selon les champions joués, avec une interface dynamique.  
Chaque article est associé à 5 champions car une équipe de League of Legends est composée de 5 joueurs, chacun jouant un champion différent.

Pour tester la recherche, voici quelques champions ayant au moins un article associé :
- Corki, Ambessa, Vi, Rumble, Rell, Zyra, Draven

## 🚀 Fonctionnalités principales

- **Recherche dynamique :** Recherchez des champions en temps réel avec des suggestions automatiques.
- **Articles récents :** Affiche une liste des articles récents avec des miniatures YouTube.
- **Gestion des articles :** Ajoutez, modifiez ou supprimez des articles associés à des champions.
- **Commentaires :** Laissez des commentaires sur les articles avec des dates formatées dynamiquement.
- **Multilingue :** Basculer entre le Français et l'Anglais.
- **Responsive :** Compatible avec les différentes tailles d'écran.

## 🛠 Installation

### Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- PHP
- SQLite
- Git

### 1. Cloner le dépôt GitLab

Clonez le projet depuis GitLab en utilisant la commande suivante dans votre terminal :

```bash
git clone X
```

### 2. Configurer le projet

#### 1. Base de données : 

Le fichier SQLite est déjà  inclus dans le projet `/app/config/db.sqlite)`

#### 2. Vérifiez les permissions : 

Assurez-vous que le dossier contenant la base de données a les bonnes permissions pour que PHP puisse y accéder :

```bash
chmod -R 775 app/config/
```

#### 3. Configuration des langues :

Les fichiers de traduction se trouvent dans ``/public/lang``.

### 3. Lancer le serveur PHP local

Utilisez le serveur intégré de PHP pour lancer le site. Exécutez la commande suivante dans le dossier racine du projet :

```bash
php -S localhost:8000
```

Ensuite, ouvrez votre navigateur et accédez à l'URL suivante :


[http://localhost:8000](http://localhost:8000)


## 📦 Structure du projet

Voici un aperçu des dossiers principaux et de leur contenu :

```
/app/                          # Cœur de l’application
│
├── config/                    # Fichiers de configuration (BDD, langue)
├── controllers/               # Logique métier (traitement des formulaires, etc.)
├── models/                    # Accès aux données (connexion et classes BDD)
│
/public/                       # Fichiers accessibles par le navigateur
│
├── index.php                  # Page d’accueil (recherche + articles récents)
├── article.php                # Page d’affichage d’un article avec vidéo et commentaires
├── search_results.php         # Page d’affichage des articles liés à un champion
│
├── assets/                    # Fichiers statiques
│   ├── css/                   # Feuilles de style (styles.css, article.css…)
│   ├── images/                # Logos, icônes, miniatures, etc.
│   ├── js/                    # Scripts JS (ex : recherche AJAX, validation…)
│   └── php/                   # Inclut nav.php, footer.php, etc.
│
├── lang/                      # Fichiers de traduction (fr.php, en.php)
│
.gitignore                     # Fichiers/dossiers ignorés par Git
README.md                      # Documentation du projet
```

## ⚙️ Fonctionnalités détaillées

Recherche de champions

- **Description :** Une barre de recherche dynamique permet de trouver des champions associés à la KCorp.
- **Technologie utilisée :** JavaScript (AJAX) pour les requêtes dynamiques vers ``search_champion.php``.

Articles

- **Description :** Les articles incluent un titre, un contenu, une vidéo YouTube et une liste de champions associés.
- **Gestion :** Les articles peuvent être ajoutés, modifiés ou supprimés via des formulaires sécurisés.

Commentaires

- **Description :** Les utilisateurs peuvent laisser des commentaires sur les articles.
- **Validation :** Les champs pseudo et contenu sont obligatoires, avec une vérification JavaScript avant envoi.

Multilingue

- **Description :** Le site est disponible en Français et en Anglais.
- **Gestion :** Les fichiers de traduction se trouvent dans ``lang``.

## ✏️ Utilisation – Gestion des articles

### ➕ Ajouter un article

📍 Accès : [`/app/controllers/ajouter_article.php`](http://localhost:8000/app/controllers/ajouter_article.php)

- Remplir :
  - **Titre**
  - **Contenu de l’article**
  - **URL YouTube** de la vidéo
  - **5 champions maximum** (sélection via un menu déroulant avec recherche)
- Une validation **JavaScript** empêche l’envoi si les champs sont incomplets ou mal formatés.

### 🛠 Modifier un article

📍 Accès : [`/app/controllers/liste_articles.php`](http://localhost:8000/app/controllers/liste_articles.php)

- Cliquez sur **“Modifier”** sous l’article concerné.
- Vous pouvez mettre à jour :
  - Le **texte**
  - L’**URL de la vidéo**
  - Les **champions associés** (ajout/suppression dynamique)


### 🗑 Supprimer un article

📍 Accès : [`/app/controllers/liste_articles.php`](http://localhost:8000/app/controllers/liste_articles.php)

- Cliquez sur **“Supprimer”**
- Une **boîte de confirmation** s’affiche pour éviter les suppressions accidentelles.
- La suppression est **définitive** (article + liaisons avec champions en base).

## 🔌 API

Le projet utilise l’API Data Dragon de [Riot Games](https://developer.riotgames.com/docs/lol) pour récupérer les informations des champions :
- Version league (à changer tous les 2 semaines) : [https://ddragon.leagueoflegends.com/api/versions.json](https://ddragon.leagueoflegends.com/api/versions.json)
- Informations sur les champions : [https://ddragon.leagueoflegends.com/cdn/{version}/data/en_US/champion.json](https://ddragon.leagueoflegends.com/cdn/{version}/data/en_US/champion.json)
- Miniatures des champions : [https://ddragon.leagueoflegends.com/cdn/{version}/img/champion/{champion}.png](https://ddragon.leagueoflegends.com/cdn/{version}/img/champion/{champion}.png)

---

#### 🛠 Mise à jour de la base de données des champions

Si Riot Games ajoute un nouveau champion, tu peux mettre à jour ta base de données locale très facilement.

##### 📌 Étapes :

1. **Modifier le script PHP `import_champions.php`** avec la nouvelle version du jeu à l'emplacement `{VERSION}` :
```php
$url = "https://ddragon.leagueoflegends.com/{VERSION}/data/en_US/champion.json";
```

2. **Lancer le script PHP `import_champions.php`** à la racine du projet.

Ce script utilise l’API Data Dragon (version de League définie en dur) pour récupérer tous les champions disponibles et les insère automatiquement dans la base db.sqlite.

3. **Les nouveaux champions seront ajoutés s’ils n’existent pas déjà**, sans dupliquer les anciens.


## 👤 Auteur 

**hiden**  
Étudiant

## 📄 Licence

Ce projet est sous licence MIT. Vous êtes libre de l'utiliser, de le modifier et de le distribuer.