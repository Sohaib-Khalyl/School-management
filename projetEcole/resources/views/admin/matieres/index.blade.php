<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-admin')
    </x-slot>

    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Gestion des Matières</h1>
            <p class="text-slate-500 text-sm mt-1">Gérez les matières et leurs coefficients.</p>
        </div>
        <button onclick="document.getElementById('addMatiereModal').classList.remove('hidden')" class="px-4 py-2 text-sm font-semibold transition-all flex items-center gap-2" style="background-color: #4f46e5; color: white; border-radius: 0.75rem;">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Nouvelle Matière
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Matière</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Coefficient</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($matieres as $matiere)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-indigo-600 text-[18px]">book</span>
                                </div>
                                <span class="text-sm font-bold text-slate-900">{{ $matiere->nom }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold">x{{ $matiere->coefficient }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="editMatiere({{ json_encode($matiere) }})" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <form action="{{ route('admin.matieres.destroy', $matiere->id) }}" method="POST" onsubmit="return confirm('Supprimer cette matière ?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-slate-400 text-sm">Aucune matière trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addMatiereModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 transition-opacity" style="background-color: rgba(0,0,0,0.6);" onclick="document.getElementById('addMatiereModal').classList.add('hidden')"></div>
        <div class="relative bg-white shadow-2xl w-full max-w-md transform transition-all" style="border-radius: 16px; overflow: hidden; border: 1px solid #e5e7eb;">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50" style="padding: 1.5rem;">
                <h3 class="font-bold text-slate-900">Nouvelle Matière</h3>
                <button onclick="document.getElementById('addMatiereModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form action="{{ route('admin.matieres.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nom de la matière</label>
                        <input type="text" name="nom" required class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Mathématiques">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Coefficient</label>
                        <input type="number" name="coefficient" required min="1" value="1" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="button" onclick="document.getElementById('addMatiereModal').classList.add('hidden')" class="flex-1 px-4 py-2 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-all">Annuler</button>
                    <button type="submit" class="flex-1 px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition-all">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editMatiereModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 transition-opacity" style="background-color: rgba(0,0,0,0.6);" onclick="document.getElementById('editMatiereModal').classList.add('hidden')"></div>
        <div class="relative bg-white shadow-2xl w-full max-w-md transform transition-all" style="border-radius: 16px; overflow: hidden; border: 1px solid #e5e7eb;">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50" style="padding: 1.5rem;">
                <h3 class="font-bold text-slate-900">Modifier Matière</h3>
                <button onclick="document.getElementById('editMatiereModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="editForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nom de la matière</label>
                        <input type="text" id="edit_nom" name="nom" required class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Coefficient</label>
                        <input type="number" id="edit_coefficient" name="coefficient" required min="1" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <div class="mt-6 flex gap-3">
                    <button type="button" onclick="document.getElementById('editMatiereModal').classList.add('hidden')" class="flex-1 px-4 py-2 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-all">Annuler</button>
                    <button type="submit" class="flex-1 px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition-all">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editMatiere(matiere) {
            const modal = document.getElementById('editMatiereModal');
            const form = document.getElementById('editForm');
            form.action = `/admin/matieres/${matiere.id}`;
            document.getElementById('edit_nom').value = matiere.nom;
            document.getElementById('edit_coefficient').value = matiere.coefficient;
            modal.classList.remove('hidden');
        }
    </script>
</x-school-layout>
