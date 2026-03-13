<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti 😄.
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

