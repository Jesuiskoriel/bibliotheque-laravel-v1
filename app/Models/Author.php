<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti .
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'bio'];

    /**
     * EXPLAIN-FUNC: Cette fonction 'books' fait une étape précise du flux applicatif.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}

