# BlogTech – ECF Symfony

Projet d'évaluation ECF : plateforme de blog collaboratif avec back-office, front public et API REST en lecture.

Dépôt GitHub : https://github.com/abdelazizfiddah-beep/ecf3-blogtech

## Prérequis

- PHP 8.2+
- Composer
- Symfony CLI (recommandé)
- Docker + Docker Compose
- MySQL ou MariaDB

## Installation

1. Cloner le dépôt :

   ```bash
   git clone https://github.com/abdelazizfiddah-beep/ecf3-blogtech.git
   cd ecf3-blogtech
   ```

2. Installer les dépendances PHP :

   ```bash
   composer install
   ```

3. Lancer la base de données avec Docker :

   ```bash
   docker compose up -d
   ```

4. Configurer la base dans `.env.local` (exemple) :

   ```env
   DATABASE_URL="mysql://user:password@127.0.0.1:3306/blogtech?serverVersion=8.0"
   ```

5. Créer la base et charger les données :

   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   php bin/console doctrine:fixtures:load
   ```

6. Lancer le serveur Symfony :

   ```bash
   symfony server:start
   ```

## Fonctionnalités

- Authentification par formulaire (entité User, rôles).
- Back-office `/admin` réservé aux administrateurs :
  - Gestion des articles (CRUD, auteur automatique, statut draft/published).
  - Gestion des catégories (CRUD, slug automatique, nombre d’articles).
  - Modération des commentaires (toggle du champ `approved` avec Stimulus).
- Front-office public :
  - `/` : liste des articles publiés (du plus récent au plus ancien).
  - `/article/{id}` : détail d’un article + commentaires approuvés.
  - `/category` : liste des catégories.
  - `/category/{slug}` : articles publiés d’une catégorie.

## API REST (lecture seule)

Endpoints :

- `GET /api/articles` : liste des articles publiés (id, title, slug, author.username, createdAt, categories).
- `GET /api/articles/{id}` : détail d’un article publié avec ses commentaires.
- `GET /api/categories` : liste des catégories avec leurs articles.

La sérialisation des données est gérée par le Serializer Symfony avec des groupes (`#[Groups]`) sur les entités.
