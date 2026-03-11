# Bibliothèque Laravel V1

Application de gestion de bibliothèque (Laravel 12 + MySQL).

## Fonctionnalités
- Tableau de bord (livres, adhérents, emprunts actifs, retards)
- CRUD auteurs
- CRUD catégories
- CRUD livres (stock total/disponible)
- CRUD adhérents
- Gestion des emprunts/retours
- Seed de données de démo

## Prérequis
- PHP 8.3+
- Composer
- MySQL 8+

## Installation
```bash
cp .env.example .env
composer install
php artisan key:generate
```

Créer la base MySQL `bibliotheque_laravel_v1`, puis:
```bash
php artisan migrate --seed
php artisan serve
```

## Configuration DB (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bibliotheque_laravel_v1
DB_USERNAME=root
DB_PASSWORD=
```

## Repo
Le projet est prêt pour push GitHub.
