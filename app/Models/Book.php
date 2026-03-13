<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti 😄.
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'isbn', 'published_year', 'stock_total', 'stock_available', 'author_id', 'category_id',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}

