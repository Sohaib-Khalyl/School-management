<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-admin')
    </x-slot>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Classes</h1>
            <p class="text-slate-500 text-sm mt-1">Gérer les classes de l'établissement</p>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-medium text-sm transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Nouvelle classe
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nom de la classe</th>
                        <th class="px-6 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nombre d'élèves</th>
                        <th class="px-6 py-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($classes as $classe)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-900">{{ $classe->nom }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $classe->eleves_count }} élève{{ $classe->eleves_count > 1 ? 's' : '' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" onclick="openAddStudentModal({{ $classe->id }}, '{{ addslashes($classe->nom) }}')" 
                                        class="p-1.5 text-slate-400 hover:text-green-600 rounded-lg hover:bg-green-50 transition-colors" title="Ajouter un élève">
                                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                                </button>
                                <button onclick="openEditModal({{ $classe->id }}, '{{ addslashes($classe->nom) }}')" 
                                        class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-colors" title="Modifier la classe">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <form method="POST" action="{{ route('admin.classes.destroy', $classe->id) }}"
                                      onsubmit="return confirm('Supprimer cette classe ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 rounded-lg hover:bg-red-50 transition-colors"
                                            @if($classe->eleves_count > 0) title="Impossible de supprimer une classe contenant des élèves" disabled @endif>
                                        <span class="material-symbols-outlined text-[20px] {{ $classe->eleves_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-slate-400 text-sm">
                            Aucune classe n'a été créée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Create / Edit Modal --}}
    <div id="classe-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" onclick="closeModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 id="modal-title" class="text-lg font-bold text-slate-900">Nouvelle classe</h2>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="classe-form" method="POST" action="{{ route('admin.classes.store') }}" class="p-6 space-y-4">
                @csrf
                <div id="method-container"></div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Nom de la classe</label>
                    <input type="text" name="nom" id="classe-nom" required class="w-full border-slate-200 rounded-xl text-sm bg-slate-50 focus:border-blue-500 focus:ring-blue-500" placeholder="ex: 6ème A">
                </div>
                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                    Enregistrer
                </button>
            </form>
        </div>
    </div>

    {{-- Add Student Modal --}}
    <div id="add-student-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" onclick="closeAddStudentModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 id="add-student-modal-title" class="text-lg font-bold text-slate-900">Ajouter un élève</h2>
                <button type="button" onclick="closeAddStudentModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="add-student-form" method="POST" action="" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Élève</label>
                    <select name="eleve_id" required class="w-full border-slate-200 rounded-xl text-sm bg-slate-50 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Sélectionner un élève</option>
                        @foreach($eleves as $eleve)
                            <option value="{{ $eleve->id }}">{{ $eleve->nom }} {{ $eleve->prenom }} {{ $eleve->classe_id ? '(' . $eleve->classe->nom . ')' : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                    Ajouter
                </button>
            </form>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('modal-title').innerText = 'Nouvelle classe';
            document.getElementById('classe-form').action = "{{ route('admin.classes.store') }}";
            document.getElementById('method-container').innerHTML = '';
            document.getElementById('classe-nom').value = '';
            document.getElementById('classe-modal').classList.remove('hidden');
        }

        function openEditModal(id, nom) {
            document.getElementById('modal-title').innerText = 'Modifier la classe';
            document.getElementById('classe-form').action = `/admin/classes/${id}`;
            document.getElementById('method-container').innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('classe-nom').value = nom;
            document.getElementById('classe-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('classe-modal').classList.add('hidden');
        }

        function openAddStudentModal(id, nom) {
            document.getElementById('add-student-modal-title').innerText = 'Ajouter un élève à ' + nom;
            document.getElementById('add-student-form').action = `/admin/classes/${id}/students`;
            document.getElementById('add-student-modal').classList.remove('hidden');
        }

        function closeAddStudentModal() {
            document.getElementById('add-student-modal').classList.add('hidden');
        }
    </script>
</x-school-layout>
