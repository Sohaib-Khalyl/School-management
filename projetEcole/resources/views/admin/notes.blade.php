<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-admin')
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Notes et Bulletins</h1>
        <p class="text-slate-500 text-sm mt-1">Consultez les notes des élèves par classe.</p>
    </div>

    {{-- Selection Area --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Select Class -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-slate-400 mb-3 uppercase tracking-widest">1. Sélectionner une Classe</h3>
            <form action="{{ route('admin.notes') }}" method="GET">
                <select name="classe_id" onchange="this.form.submit()" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                    <option value="">-- Choisir une classe --</option>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ ($selectedClasse->id ?? null) == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Select Student -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 {{ !$selectedClasse ? 'opacity-50 pointer-events-none' : '' }}">
            <h3 class="text-xs font-bold text-slate-400 mb-3 uppercase tracking-widest">2. Sélectionner un Élève</h3>
            @if($selectedClasse)
            <form action="{{ route('admin.notes') }}" method="GET">
                <input type="hidden" name="classe_id" value="{{ $selectedClasse->id }}">
                <select name="eleve_id" onchange="this.form.submit()" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                    <option value="">-- Choisir un élève --</option>
                    @foreach($eleves as $eleve)
                        <option value="{{ $eleve->id }}" {{ ($selectedEleve->id ?? null) == $eleve->id ? 'selected' : '' }}>
                            {{ $eleve->nom }} {{ $eleve->prenom }}
                        </option>
                    @endforeach
                </select>
            </form>
            @else
                <div class="text-sm text-slate-400 font-medium p-2.5 bg-slate-50 rounded-xl border border-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">info</span>
                    Veuillez d'abord sélectionner une classe.
                </div>
            @endif
        </div>
    </div>

    {{-- Grades Area --}}
    @if($selectedEleve)
    <form action="{{ route('admin.notes.store', $selectedEleve->id) }}" method="POST" class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        @csrf
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Bulletin de {{ $selectedEleve->prenom }} {{ $selectedEleve->nom }}</h2>
                <p class="text-xs font-medium text-slate-500 mt-1">Classe: {{ $selectedClasse->nom }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.notes') }}" class="text-sm font-bold text-slate-600 hover:text-slate-800 bg-white border border-slate-200 px-4 py-2 rounded-xl transition-colors">
                    Annuler
                </a>
                <button type="submit" class="text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl transition-colors shadow-sm" style="background-color: #2563eb;">
                    Enregistrer les modifications
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-white border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest w-1/4">Matière</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">CC 1</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">CC 2</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">CC 3</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-center">Moyenne</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $totalPoints = 0;
                        $totalCoefs = 0;
                    @endphp
                    @forelse($matieres as $matiere)
                        @php
                            $note = $notes->get($matiere->id);
                            $cc1 = $note->cc1 ?? null;
                            $cc2 = $note->cc2 ?? null;
                            $cc3 = $note->cc3 ?? null;
                            $count = 0;
                            $sum = 0;
                            if($cc1 !== null) { $sum += (float)$cc1; $count++; }
                            if($cc2 !== null) { $sum += (float)$cc2; $count++; }
                            if($cc3 !== null) { $sum += (float)$cc3; $count++; }
                            
                            $moyenne = '—';
                            if ($count > 0) {
                                $avg = $sum / $count;
                                $moyenne = number_format($avg, 2);
                                $totalPoints += $avg * $matiere->coefficient;
                                $totalCoefs += $matiere->coefficient;
                            }
                        @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-slate-900">{{ $matiere->nom }}</span>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">Coef. {{ $matiere->coefficient }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <input type="number" step="0.01" min="0" max="20" name="notes[{{ $matiere->id }}][cc1]" value="{{ $cc1 }}" class="w-20 text-center bg-white border border-slate-200 rounded-lg text-sm font-bold focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" placeholder="—">
                        </td>
                        <td class="px-6 py-4 text-center">
                            <input type="number" step="0.01" min="0" max="20" name="notes[{{ $matiere->id }}][cc2]" value="{{ $cc2 }}" class="w-20 text-center bg-white border border-slate-200 rounded-lg text-sm font-bold focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" placeholder="—">
                        </td>
                        <td class="px-6 py-4 text-center">
                            <input type="number" step="0.01" min="0" max="20" name="notes[{{ $matiere->id }}][cc3]" value="{{ $cc3 }}" class="w-20 text-center bg-white border border-slate-200 rounded-lg text-sm font-bold focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" placeholder="—">
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-black {{ $moyenne !== '—' && $moyenne >= 10 ? 'text-emerald-600' : ($moyenne !== '—' ? 'text-red-600' : 'text-slate-400') }}">
                                {{ $moyenne }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="material-symbols-outlined text-3xl text-slate-300">menu_book</span>
                            </div>
                            <p class="text-sm font-bold text-slate-500">Aucune matière n'est configurée dans le système.</p>
                        </td>
                    </tr>
                    @endforelse
                    
                    @if($totalCoefs > 0)
                        @php
                            $moyenneGenerale = $totalPoints / $totalCoefs;
                        @endphp
                        <tr class="bg-slate-50/80 border-t-2 border-slate-200">
                            <td colspan="4" class="px-6 py-5 text-right text-sm font-black text-slate-900 uppercase tracking-widest">
                                Moyenne Générale
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-base font-black {{ $moyenneGenerale >= 10 ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ number_format($moyenneGenerale, 2) }} / 20
                                </span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </form>
    @elseif($selectedClasse && !$selectedEleve)
        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl text-slate-300">person_search</span>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Sélectionnez un élève</h3>
            <p class="text-sm font-medium text-slate-500 mt-1">Choisissez un élève de la classe {{ $selectedClasse->nom }} pour éditer son bulletin.</p>
        </div>
    @else
        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl text-slate-300">school</span>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Gérer les Notes</h3>
            <p class="text-sm font-medium text-slate-500 mt-1">Sélectionnez une classe puis un élève pour afficher et éditer son bulletin de notes complet.</p>
        </div>
    @endif

</x-school-layout>
