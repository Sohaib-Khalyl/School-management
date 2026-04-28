<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add coefficient to matieres
        Schema::table('matieres', function (Blueprint $table) {
            if (!Schema::hasColumn('matieres', 'coefficient')) {
                $table->integer('coefficient')->default(1)->after('nom');
            }
        });

        // 2. Add matiere_id to enseignants
        Schema::table('enseignants', function (Blueprint $table) {
            if (!Schema::hasColumn('enseignants', 'matiere_id')) {
                $table->foreignId('matiere_id')->nullable()->constrained('matieres')->nullOnDelete()->after('user_id');
            }
        });

        // 3. Drop old notes and evaluations
        Schema::dropIfExists('notes');
        Schema::dropIfExists('evaluations');

        // 4. Create new notes table for CC1, CC2, CC3
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_eleve')->constrained('eleves')->cascadeOnDelete();
            $table->foreignId('matiere_id')->constrained('matieres')->cascadeOnDelete();
            $table->decimal('cc1', 4, 2)->nullable();
            $table->decimal('cc2', 4, 2)->nullable();
            $table->decimal('cc3', 4, 2)->nullable();
            $table->timestamps();
            
            // Un élève n'a qu'une seule ligne de notes par matière
            $table->unique(['id_eleve', 'matiere_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
        
        Schema::table('enseignants', function (Blueprint $table) {
            $table->dropForeign(['matiere_id']);
            $table->dropColumn('matiere_id');
        });

        Schema::table('matieres', function (Blueprint $table) {
            $table->dropColumn('coefficient');
        });
    }
};
