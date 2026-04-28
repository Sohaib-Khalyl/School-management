<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-student')
    </x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Bonjour, {{ Auth::user()->name }} 👋</h1>
        <p class="text-slate-500 text-sm mt-1">
            Classe :
            <span class="font-semibold text-slate-700">{{ $eleve?->classe?->nom ?? 'Non assigné' }}</span>
        </p>
    </div>

    @if(!$eleve)
        <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-xl text-sm">
            Votre profil élève n'est pas encore configuré. Contactez l'administrateur.
        </div>
    @else


        {{-- Notes Table --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h2 class="text-base font-bold text-slate-900">Mes bulletins par matière</h2>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Semestre 1</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Matière</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Premier contrôle</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Deuxième contrôle</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center">Troisième contrôle</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-center bg-indigo-50/50 text-indigo-600">Note Finale</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($notes as $note)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-slate-700 uppercase">{{ $note->matiere->nom }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold {{ $note->cc1 !== null ? 'text-slate-900' : 'text-slate-300' }}">
                                    {{ $note->cc1 !== null ? number_format($note->cc1, 2) : '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold {{ $note->cc2 !== null ? 'text-slate-900' : 'text-slate-300' }}">
                                    {{ $note->cc2 !== null ? number_format($note->cc2, 2) : '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold {{ $note->cc3 !== null ? 'text-slate-900' : 'text-slate-300' }}">
                                    {{ $note->cc3 !== null ? number_format($note->cc3, 2) : '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center bg-indigo-50/20">
                                @if($note->final !== null)
                                    <span class="inline-block px-3 py-1 rounded-lg text-sm font-black bg-indigo-100 text-indigo-700">
                                        {{ number_format($note->final, 2) }}
                                    </span>
                                @else
                                    <span class="text-slate-300 font-bold text-xs">EN ATTENTE</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @if($moyenneGenerale !== null)
                    <tfoot class="bg-slate-900 text-white">
                        <tr>
                            <td class="px-6 py-6 font-black uppercase tracking-wider">Moyenne Générale</td>
                            <td colspan="3"></td>
                            <td class="px-6 py-6 text-center">
                                <span class="text-xl font-black px-4 py-2 bg-white/10 rounded-xl">
                                    {{ number_format($moyenneGenerale, 2) }} / 20
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-2xl border border-slate-200 p-8 flex flex-col items-center justify-center text-center">
            <p class="text-5xl font-black {{ $moyenneGenerale >= 10 ? 'text-emerald-500' : ($moyenneGenerale !== null ? 'text-red-500' : 'text-slate-300') }}">
                {{ $moyenneGenerale !== null ? number_format($moyenneGenerale, 2) . ' / 20' : '—' }}
            </p>
            <p class="text-sm text-slate-500 font-semibold mt-2 uppercase tracking-wide">Moyenne du semestre</p>
            @if($moyenneGenerale === null)
                <p class="text-[10px] text-slate-400 mt-2 italic">Calculée une fois toutes les notes saisies</p>
            @endif
        </div>

        @if($moyenneGenerale === null)
        <div class="mt-6 p-4 bg-slate-50 border border-dashed border-slate-200 rounded-2xl flex items-center gap-4">
            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-slate-400">info</span>
            </div>
            <p class="text-sm text-slate-500 font-medium">
                La <span class="text-slate-700 font-bold">Moyenne Générale</span> sera affichée ici dès que toutes vos notes finales par matière seront disponibles.
            </p>
        </div>
        @endif
    @endif
</x-school-layout>
