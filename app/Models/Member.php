<?php
/* Ce fichier fait une partie du boulot de l'app bibliothèque. 
 * Version simple: ce fichier sert à éviter que tout parte en spaghetti .
 * Lisez les fonctions une par une: chacune fait un mini boulot précis.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'first_name', 'last_name', 'email', 'phone'];

    /**
     * Cette fonction 'loans' fait une étape précise du flux applicatif.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cette fonction 'getFullNameAttribute' fait une étape précise du flux applicatif.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
