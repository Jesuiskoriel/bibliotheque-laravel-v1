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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->date('loaned_at');
            $table->date('due_at');
            $table->date('returned_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * EXPLAIN-FUNC: Migration DOWN = annule ce que UP a fait (rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};

