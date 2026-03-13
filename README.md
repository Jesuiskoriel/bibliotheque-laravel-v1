# Bibliothèque Laravel V1

Application de gestion de bibliothèque (Laravel 12 + MySQL), avec séparation **Admin / Utilisateur**.

## Fonctionnalités
- Authentification (connexion / inscription)
- Rôles:
  - **Admin**: gestion complète (auteurs, catégories, livres, adhérents, emprunts/retours)
  - **Utilisateur**: page dédiée avec consultation catalogue + emprunts en cours
- Tableau de bord admin (livres, adhérents, emprunts actifs, retards)
- CRUD Auteurs / Catégories / Livres / Adhérents / Emprunts
- Gestion des retours via l’édition des emprunts (`returned_at`)
- Seed de données de démo

## Architecture V2 (plus simple à comprendre)
Le projet suit une logique claire:
1. **Route** → reçoit l'URL
2. **Controller** → orchestre l'action
3. **FormRequest** → valide les données utilisateur
4. **Service** → applique la logique métier
5. **Model** → lit/écrit en base MySQL
6. **Blade View** → affiche à l'écran

### Exemple concret
- `StoreLoanRequest` et `UpdateLoanRequest` valident les formulaires d'emprunt.
- `LoanService` gère les règles métier (stock, retour, suppression).
- `LoanController` reste lisible et court.

## Stack
- PHP 8.3+
- Laravel 12
- MySQL 8+

## Installation
```bash
cp .env.example .env
composer install
php artisan key:generate
```

Configurer la base dans `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bibliotheque_laravel_v1
DB_USERNAME=root
DB_PASSWORD=
```

Créer la base MySQL `bibliotheque_laravel_v1`, puis:
```bash
php artisan migrate --seed
php artisan serve
```

## Accès
- URL: `http://127.0.0.1:8000/login`

Comptes de démo (créés par le seeder):
- **Admin**
  - Email: `admin@biblio.local`
  - Mot de passe: `password`
- **Utilisateur**
  - Email: `user@biblio.local`
  - Mot de passe: `password`

## Routes utiles
- `/login` (connexion)
- `/register` (inscription utilisateur)
- `/admin/dashboard` (admin)
- `/utilisateur` (espace utilisateur)

## Repo
<https://github.com/Jesuiskoriel/bibliotheque-laravel-v1>
