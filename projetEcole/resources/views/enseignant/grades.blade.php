<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-teacher')
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('enseignant.classes') }}" class="text-slate-400 hover:text-blue-600 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                </a>
                <h1 class="text-2xl font-bold text-slate-900">Saisie des notes - {{ $classe->nom }}</h1>
            </div>
            <p class="text-slate-500 text-sm">Matière : <span class="font-bold">{{ $enseignant->matiere->nom }}</span> (Coeff: {{ $enseignant->matiere->coefficient }})</p>
        </div>
    </div>

    <form method="POST" action="{{ route('enseignant.grades.store', $classe->id) }}">
        @csrf
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase">Élève</th>
                            <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase text-center w-32">Contrôle 1</th>
                            <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase text-center w-32">Contrôle 2</th>
                            <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase text-center w-32">Contrôle 3</th>
                            <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase text-center w-32 bg-slate-100">Moyenne</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($classe->eleves as $eleve)
                        @php
                            $note = $notes->get($eleve->id);
                            $cc1 = $note->cc1 ?? '';
                            $cc2 = $note->cc2 ?? '';
                            $cc3 = $note->cc3 ?? '';
                            
                            $moyenne = null;
                            $count = 0;
                            $sum = 0;
                            if($cc1 !== '') { $sum += $cc1; $count++; }
                            if($cc2 !== '') { $sum += $cc2; $count++; }
                            if($cc3 !== '') { $sum += $cc3; $count++; }
                            if($count > 0) $moyenne = round($sum / $count, 2);
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-4 py-3">
                                <span class="font-semibold text-slate-900">{{ $eleve->nom }} {{ $eleve->prenom }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" step="0.25" min="0" max="20" 
                                       name="notes[{{ $eleve->id }}][cc1]" 
                                       value="{{ $cc1 }}"
                                       class="w-full text-center border-slate-200 rounded-lg text-sm bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 px-2 py-1.5"
                                       placeholder="—">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" step="0.25" min="0" max="20" 
                                       name="notes[{{ $eleve->id }}][cc2]" 
                                       value="{{ $cc2 }}"
                                       class="w-full text-center border-slate-200 rounded-lg text-sm bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 px-2 py-1.5"
                                       placeholder="—">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" step="0.25" min="0" max="20" 
                                       name="notes[{{ $eleve->id }}][cc3]" 
                                       value="{{ $cc3 }}"
                                       class="w-full text-center border-slate-200 rounded-lg text-sm bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 px-2 py-1.5"
                                       placeholder="—">
                            </td>
                            <td class="px-4 py-3 text-center bg-slate-50/50 group-hover:bg-slate-100/50 font-bold {{ $moyenne >= 10 ? 'text-emerald-600' : ($moyenne !== null ? 'text-red-500' : 'text-slate-400') }}">
                                {{ $moyenne !== null ? $moyenne : '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">Aucun élève dans cette classe.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($classe->eleves->count() > 0)
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end">
                <button type="submit" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-colors">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Enregistrer les notes
                </button>
            </div>
            @endif
        </div>
    </form>
</x-school-layout>
