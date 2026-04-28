<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_eleve',
        'matiere_id',
        'cc1',
        'cc2',
        'cc3',
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'id_eleve');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }
}
