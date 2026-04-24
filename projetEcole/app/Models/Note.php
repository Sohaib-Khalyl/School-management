<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = ['id_eleve', 'id_evaluation'];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'id_eleve');
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'id_evaluation');
    }
}
