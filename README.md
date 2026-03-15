# Bibliothèque Laravel V1

Application de gestion de bibliothèque (Laravel 12 + MySQL), avec séparation **Admin / Utilisateur**.

## Fonctionnalités
- Authentification (connexion / inscription)
- Rôles :
  - **Admin** : gestion complète (auteurs, catégories, livres, adhérents, emprunts/retours)
  - **Utilisateur** : page dédiée avec consultation du catalogue + emprunts en cours
- Tableau de bord admin (livres, adhérents, emprunts actifs, retards)
- CRUD Auteurs / Catégories / Livres / Adhérents / Emprunts
- Gestion des retours via l’édition des emprunts (`returned_at`)
- Données de démonstration via seeder

## Architecture V2 (plus simple à comprendre)
Le projet suit une logique claire :

1. **Route** -> reçoit l’URL
2. **Contrôleur** -> orchestre l’action
3. **Requête de formulaire** -> valide les données utilisateur
4. **Service** -> applique la logique métier
5. **Modèle** -> lit/écrit en base MySQL
6. **Vue Blade** -> affiche à l’écran

### Exemple concret
- `StoreLoanRequest` et `UpdateLoanRequest` valident les formulaires d’emprunt.
- `LoanService` gère les règles métier (stock, retour, suppression).
- `LoanController` reste lisible et court.

## Technologies
- PHP 8.3+
- Laravel 12
- MySQL 8+

## Installation sur macOS

### 1) Pré-requis à installer (Homebrew)
Si Homebrew n'est pas installé :
```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

Installer les dépendances :
```bash
brew install php composer mysql
```

Démarrer MySQL :
```bash
brew services start mysql
```

Vérifier les versions :
```bash
php -v
composer -V
mysql --version
```

### 2) Installer le projet
Depuis le dossier du projet :
```bash
cp .env.example .env
composer install
php artisan key:generate
```

### 3) Configurer la base de données
Créer la base MySQL :
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS bibliotheque_laravel_v1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Configurer `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bibliotheque_laravel_v1
DB_USERNAME=root
DB_PASSWORD=
```

### 4) Initialiser l'application
```bash
php artisan migrate --seed
php artisan serve
```

Application disponible sur :
`http://127.0.0.1:8000/login`

## Dépannage macOS (rapide)

- Erreur `SQLSTATE[HY000] [2002]` : MySQL n'est pas démarré.
  ```bash
  brew services start mysql
  ```

- Erreur `Class "PDO" not found` ou `could not find driver` : extension MySQL absente.
  Vérifier que PHP est bien celui de Homebrew :
  ```bash
  which php
  php -m | grep pdo_mysql
  ```

- Erreur de cache/config Laravel :
  ```bash
  php artisan optimize:clear
  ```

## Accès
- URL : `http://127.0.0.1:8000/login`

Comptes de démonstration (créés par le seeder) :
- **Admin**
  - Email : `admin@biblio.local`
  - Mot de passe : `password`
- **Utilisateur**
  - Email : `user@biblio.local`
  - Mot de passe : `password`

## Routes utiles
- `/login` (connexion)
- `/register` (inscription utilisateur)
- `/admin/dashboard` (admin)
- `/utilisateur` (espace utilisateur)

## Repo
<https://github.com/Jesuiskoriel/bibliotheque-laravel-v1>
