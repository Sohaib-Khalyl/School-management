<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmploiDuTemps extends Model
{
    use HasFactory;

    protected $table = 'emplois_du_temps';

    protected $fillable = [
        'classe_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'matiere_id',
        'enseignant_id',
        'salle',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the classe that this timetable entry belongs to.
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Get the matiere that this timetable entry belongs to.
     */
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    /**
     * Get the enseignant that this timetable entry belongs to.
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    /**
     * Scope to get timetable for a specific classe.
     */
    public function scopeForClasse($query, $classeId)
    {
        return $query->where('classe_id', $classeId);
    }

    /**
     * Scope to get timetable for a specific day.
     */
    public function scopeForDay($query, $day)
    {
        return $query->where('jour', $day);
    }

    /**
     * Check if a time slot overlaps with existing entries for the same classe.
     */
    public static function hasOverlap($classeId, $jour, $heure_debut, $heure_fin, $excludeId = null)
    {
        $query = self::where('classe_id', $classeId)
            ->where('jour', $jour)
            ->where(function ($q) use ($heure_debut, $heure_fin) {
                $q->whereBetween('heure_debut', [$heure_debut, $heure_fin])
                    ->orWhereBetween('heure_fin', [$heure_debut, $heure_fin])
                    ->orWhere(function ($q) use ($heure_debut, $heure_fin) {
                        $q->where('heure_debut', '<', $heure_debut)
                            ->where('heure_fin', '>', $heure_fin);
                    });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
