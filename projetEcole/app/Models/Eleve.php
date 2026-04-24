<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Eleve extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'prenom', 'date_naissance', 'email', 'classe_id'];

    /**
     * Get the classe this student belongs to.
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }
}
