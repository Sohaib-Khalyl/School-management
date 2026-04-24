<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = ['id_matiere', 'type'];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'id_matiere');
    }
}
