<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-teacher')
    </x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Saisie des notes</h1>
        <p class="text-slate-500 text-sm mt-1">Sélectionnez une classe pour saisir les notes de Contrôle Continu (Matière: <span class="font-bold text-blue-600">{{ $enseignant->matiere->nom ?? 'Non assignée' }}</span>).</p>
    </div>

    @if(!$enseignant || !$enseignant->matiere_id)
        <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-xl text-sm">
            Vous n'êtes assigné à aucune matière. Contactez l'administrateur.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($classes as $classe)
            <a href="{{ route('enseignant.grades', $classe->id) }}" class="bg-white rounded-2xl border border-slate-200 p-5 flex flex-col gap-3 hover:border-blue-300 hover:shadow-md transition-all group">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                        <span class="material-symbols-outlined text-blue-600 group-hover:text-white" style="font-variation-settings: 'FILL' 1;">meeting_room</span>
                    </div>
                    <span class="material-symbols-outlined text-slate-300 group-hover:text-blue-500 transition-colors">arrow_forward</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">{{ $classe->nom }}</h3>
                    <p class="text-sm text-slate-500">{{ $classe->eleves_count }} élève{{ $classe->eleves_count > 1 ? 's' : '' }}</p>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</x-school-layout>
