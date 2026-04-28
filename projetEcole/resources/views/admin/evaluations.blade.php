<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-admin')
    </x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Évaluations</h1>
        <p class="text-slate-500 text-sm mt-1">Gérer toutes les évaluations de l'établissement</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Enseignant</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Matière</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Classe</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Type</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($evaluations as $eval)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-sm text-slate-700">
                            {{ $eval->date ? \Carbon\Carbon::parse($eval->date)->format('d/m/Y') : '—' }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm font-medium text-slate-900">{{ $eval->enseignant->prenom ?? '' }} {{ $eval->enseignant->nom ?? '—' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-slate-700">{{ $eval->matiere->nom ?? '—' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-slate-700">{{ $eval->classe->nom ?? '—' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-slate-100 text-slate-600">
                                {{ $eval->type }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.evaluations.destroy', $eval->id) }}" onsubmit="return confirm('Supprimer cette évaluation et toutes ses notes associées ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-500">Aucune évaluation.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($evaluations->hasPages())
        <div class="px-4 py-3 border-t border-slate-100">
            {{ $evaluations->links() }}
        </div>
        @endif
    </div>
</x-school-layout>
