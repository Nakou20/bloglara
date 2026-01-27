Tortue Blog — README
=====================

But du projet
------------
Tortue Blog est une application de blog Laravel + Tailwind permettant aux auteurs de publier des articles, gérer des catégories et tags, recevoir des likes et gérer leur profil (dont une photo de profil). Ce dépôt contient l'application, les vues Blade, des composants réutilisables et la logique serveur (controllers, models).

Points clés
-----------
- Framework : Laravel (PHP)
- Frontend : Tailwind CSS (Vite)
- Base de données : SQLite (par défaut dans le dossier database) ou MySQL (configurable)
- Fonctionnalités principales : création/édition/suppression d'articles, tags, catégories, likes, photo de profil, estimation du temps de lecture
- Le thème sombre a été retiré (clean) pour éviter des incohérences visuelles

Prérequis
---------
- PHP >= 8.x
- Composer
- Node.js & npm
- Un serveur MySQL ou SQLite

Installation (locale)
---------------------
1. Cloner le dépôt

```bash
cd ~
git clone <URL_DU_DEPOT>
cd bloglara
```

2. Installer les dépendances PHP et JS

```bash
composer install
npm install
```

3. Copier le fichier d'environnement et générer une clé d'application

```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de données
- Par défaut le projet contient un fichier SQLite `database/database.sqlite`. Si tu veux utiliser MySQL, mets à jour `.env` (DB_CONNECTION, DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

5. Exécuter les migrations

```bash
php artisan migrate
```

6. Créer le lien public pour le stockage (pour la photo de profil)

```bash
php artisan storage:link
```

7. Construire les assets (dev ou prod)

- En développement (watch)

```bash
npm run dev
```

- Pour une build de production

```bash
npm run build
```

8. Lancer le serveur local

```bash
php artisan serve
# puis ouvrir http://127.0.0.1:8000
```

Principales fonctionnalités et notes d'implémentation
----------------------------------------------------
- Photo de profil
  - Les utilisateurs peuvent uploader une image depuis la page de profil.
  - Les fichiers sont stockés dans `storage/app/public/profiles` et accessibles via `public/storage/profiles/...` après `php artisan storage:link`.
  - La migration `2026_01_27_000001_add_profile_photo_to_users_table.php` ajoute la colonne `profile_photo` à `users`.

- Temps de lecture estimé
  - Calculé dans le modèle `Article` (200 mots/min), méthode `getReadingTimeAttribute()` et `formattedReadingTime()`.
  - Affiché dans la carte d'article sous la date de publication.

- Likes
  - Les likes sont stockés en relation many-to-many (`article_likes` pivot table).
  - Affichage et positionnement du badge "like" sur la carte d'article (composant `resources/views/components/article-card.blade.php`).

- Suppression d'articles
  - Avant suppression, les relations (categories, tags, likers) sont détachées et les commentaires liés sont supprimés, pour éviter les erreurs de contrainte FK.

- Validation
  - `UserController::store` et `update` (gestion des articles) intègrent maintenant une validation serveur : `title` et `content` sont requis.
  - Les vues `create` et `edit` affichent les erreurs et conservent les valeurs précédemment saisies.

Branches Git & historique
-------------------------
- La branche `dev` contient les dernières fonctionnalités (photo de profil, temps de lecture). Si tu veux que la branche `master` reflète `dev`, on peut faire un `reset --hard` puis un `push --force` (attention : cela réécrit l'historique distant et écrase master).

Commandes Git utiles
--------------------
- Pour créer une branche locale à partir de `origin/dev` :

```bash
git fetch --all
git checkout -b dev origin/dev
```

- Pour écraser `master` par `dev` (action irréversible : *vérifie bien*) :

```bash
git checkout master
git reset --hard dev
git push origin master --force
```

Tests
-----
- Si le projet contient des tests PHPUnit (dossier `tests/`), lance :

```bash
./vendor/bin/phpunit
# ou
php artisan test
```



