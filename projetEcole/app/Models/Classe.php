<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    /**
     * Get the students (eleves) in this class.
     */
    public function eleves(): HasMany
    {
        return $this->hasMany(Eleve::class);
    }

    /**
     * Get the timetable entries for this class.
     */
    public function emploisDuTemps(): HasMany
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    /**
     * Get timetable grouped by day.
     */
    public function getTimetableByDay()
    {
        $timetable = [];
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

        foreach ($jours as $jour) {
            $timetable[$jour] = $this->emploisDuTemps()
                ->where('jour', $jour)
                ->with(['matiere', 'enseignant'])
                ->orderBy('heure_debut')
                ->get();
        }

        return $timetable;
    }
}
