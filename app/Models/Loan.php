<?php
/* METAL-EXPLAIN: Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti 😄.
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'member_id', 'loaned_at', 'due_at', 'returned_at', 'notes'];

    protected $casts = [
        'loaned_at' => 'date',
        'due_at' => 'date',
        'returned_at' => 'date',
    ];

    /**
     * EXPLAIN-FUNC: Cette fonction 'book' fait une étape précise du flux applicatif.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * EXPLAIN-FUNC: Cette fonction 'member' fait une étape précise du flux applicatif.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * EXPLAIN-FUNC: Cette fonction 'isOverdue' fait une étape précise du flux applicatif.
     */
    public function isOverdue(): bool
    {
        return is_null($this->returned_at) && Carbon::parse($this->due_at)->isPast();
    }
}

