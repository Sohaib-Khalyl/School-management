<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop timetable and cours tables (not needed)
        Schema::dropIfExists('emplois_du_temps');
        Schema::dropIfExists('cours');

        // Rebuild evaluations to be more useful
        Schema::table('evaluations', function (Blueprint $table) {
            $table->date('date')->nullable()->after('type');
            $table->foreignId('classe_id')->nullable()->after('date')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('id_enseignant')->nullable()->after('classe_id')->constrained('enseignants')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_enseignant');
            $table->dropConstrainedForeignId('classe_id');
            $table->dropColumn('date');
        });

        // Recreate cours table
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_enseignant')->constrained('enseignants')->cascadeOnDelete();
            $table->foreignId('id_matiere')->constrained('matieres')->cascadeOnDelete();
            $table->timestamps();
        });

        // Recreate emplois_du_temps table
        Schema::create('emplois_du_temps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('classes')->cascadeOnDelete();
            $table->string('jour');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->foreignId('matiere_id')->constrained('matieres')->cascadeOnDelete();
            $table->foreignId('enseignant_id')->constrained('enseignants')->cascadeOnDelete();
            $table->string('salle')->nullable();
            $table->timestamps();
        });
    }
};
