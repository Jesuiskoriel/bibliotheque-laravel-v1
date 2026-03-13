# BibliothÃ¨que Laravel V1

Application de gestion de bibliothÃ¨que (Laravel 12 + MySQL), avec sÃ©paration **Admin / Utilisateur**.

## FonctionnalitÃ©s
- Authentification (connexion / inscription)
- RÃ´les:
  - **Admin**: gestion complÃ¨te (auteurs, catÃ©gories, livres, adhÃ©rents, emprunts/retours)
  - **Utilisateur**: page dÃ©diÃ©e avec consultation catalogue + emprunts en cours
- Tableau de bord admin (livres, adhÃ©rents, emprunts actifs, retards)
- CRUD Auteurs / CatÃ©gories / Livres / AdhÃ©rents / Emprunts
- Gestion des retours via lâ€™Ã©dition des emprunts (`returned_at`)
- Seed de donnÃ©es de dÃ©mo

## Architecture V2 (plus simple Ã  comprendre)
Le projet suit une logique claire:
1. **Route** â†’ reÃ§oit l'URL
2. **Contrôleur** â†’ orchestre l'action
3. **Requête de formulaire** â†’ valide les donnÃ©es utilisateur
4. **Service** â†’ applique la logique mÃ©tier
5. **Modèle** â†’ lit/Ã©crit en base MySQL
6. **Vue Blade** â†’ affiche Ã  l'Ã©cran

### Exemple concret
- `StoreLoanRequest` et `UpdateLoanRequest` valident les formulaires d'emprunt.
- `LoanService` gÃ¨re les rÃ¨gles mÃ©tier (stock, retour, suppression).
- `LoanContrôleur` reste lisible et court.

## Technologies
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

CrÃ©er la base MySQL `bibliotheque_laravel_v1`, puis:
```bash
php artisan migrate --seed
php artisan serve
```

## AccÃ¨s
- URL: `http://127.0.0.1:8000/login`

Comptes de dÃ©mo (crÃ©Ã©s par le seeder):
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

