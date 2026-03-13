<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti 😄.
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * EXPLAIN-FUNC: Migration UP = crée/ajoute la structure dans la base de données.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('isbn')->unique();
            $table->unsignedInteger('published_year')->nullable();
            $table->unsignedInteger('stock_total')->default(1);
            $table->unsignedInteger('stock_available')->default(1);
            $table->foreignId('author_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * EXPLAIN-FUNC: Migration DOWN = annule ce que UP a fait (rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

