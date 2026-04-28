<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-teacher')
    </x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Bonjour, {{ Auth::user()->name }} 👋</h1>
        <p class="text-slate-500 text-sm mt-1">Gérez les notes de vos élèves.</p>
    </div>

    @if(!$enseignant || !$enseignant->matiere_id)
        <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-xl text-sm">
            Votre profil enseignant n'est pas encore configuré avec une matière. Contactez l'administrateur.
        </div>
    @else
        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 flex flex-col gap-3">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-emerald-600" style="font-variation-settings: 'FILL' 1;">school</span>
                </div>
                <div>
                    <p class="text-3xl font-black text-slate-900">{{ $classes->count() }}</p>
                    <p class="text-sm text-slate-500 font-medium">Classes au total</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-5 flex flex-col gap-3">
                <div class="w-10 h-10 bg-violet-50 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-violet-600" style="font-variation-settings: 'FILL' 1;">group</span>
                </div>
                <div>
                    <p class="text-3xl font-black text-slate-900">{{ $classes->sum('eleves_count') }}</p>
                    <p class="text-sm text-slate-500 font-medium">Élèves total</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Saisie des notes</h2>
                <p class="text-sm text-slate-500 mt-1">Vous enseignez la matière : <span class="font-bold text-blue-600">{{ $enseignant->matiere->nom ?? '' }}</span>.</p>
            </div>
            <a href="{{ route('enseignant.classes') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined">edit_note</span>
                Saisir les notes
            </a>
        </div>
    @endif
</x-school-layout>
