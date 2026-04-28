<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-admin')
    </x-slot>

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Gestion des Utilisateurs</h1>
        <p class="text-sm font-medium text-slate-500">Gérez les comptes des élèves, enseignants et administrateurs.</p>
    </div>

    {{-- Search, Filters & Actions Row --}}
    <div class="mb-8 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm overflow-x-auto">
        <form action="{{ route('admin.users') }}" method="GET" class="flex items-center gap-4 min-w-[750px] w-full">
            {{-- Search - Left (Wide) --}}
            <div class="relative flex-1 group">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Rechercher un utilisateur par nom ou email..." 
                       class="w-full px-4 py-2.5 bg-slate-50 border-slate-200 rounded-xl text-sm font-medium focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
            </div>

            {{-- Role Filter - Middle --}}
            <div class="w-48 shrink-0">
                <select name="role" onchange="this.form.submit()" 
                        class="w-full py-2.5 bg-slate-50 border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all cursor-pointer">
                    <option value="">Tous les rôles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrateurs</option>
                    <option value="enseignant" {{ request('role') === 'enseignant' ? 'selected' : '' }}>Enseignants</option>
                    <option value="eleve" {{ request('role') === 'eleve' ? 'selected' : '' }}>Élèves</option>
                </select>
            </div>

            @if(request('search') || request('role'))
                <a href="{{ route('admin.users') }}" class="text-xs font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest px-2 transition-colors shrink-0">
                    Reset
                </a>
            @endif

            {{-- Add User Button - Right --}}
            <button type="button" onclick="document.getElementById('create-modal').classList.remove('hidden')"
                    class="shrink-0 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-200 active:scale-95 whitespace-nowrap">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                Ajouter un utilisateur
            </button>
        </form>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Utilisateur</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Rôle</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center hidden sm:table-cell">Membre depuis</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full {{ $user->role === 'admin' ? 'bg-slate-100 text-slate-600' : ($user->role === 'enseignant' ? 'bg-indigo-50 text-indigo-600' : 'bg-blue-50 text-blue-600') }} flex items-center justify-center text-sm font-bold flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-900 truncate leading-tight">{{ $user->name }}</p>
                                    <p class="text-[12px] font-medium text-slate-500 truncate mt-0.5">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wider
                                {{ $user->role === 'admin' ? 'bg-slate-100 text-slate-700' :
                                   ($user->role === 'enseignant' ? 'bg-indigo-50 text-indigo-700' : 'bg-orange-50 text-orange-700') }}">
                                {{ $user->role === 'admin' ? 'Admin' : ($user->role === 'enseignant' ? 'Enseignant' : 'Élève') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-500 text-center hidden sm:table-cell">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}', {{ $user->role === 'eleve' ? ($user->eleve?->classe_id ?? 'null') : ($user->enseignant?->matiere_id ?? 'null') }})" 
                                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                                @else
                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest px-3">Moi</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <span class="material-symbols-outlined text-3xl text-slate-300">person_search</span>
                                </div>
                                <p class="text-sm font-bold text-slate-500">Aucun utilisateur trouvé</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    {{-- Create User Modal --}}
    <div id="create-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 transition-opacity" style="background-color: rgba(0,0,0,0.6);" onclick="document.getElementById('create-modal').classList.add('hidden')"></div>
        <div class="relative bg-white shadow-2xl w-full max-w-md transform transition-all" style="border-radius: 16px; overflow: hidden; border: 1px solid #e5e7eb;">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50" style="padding: 1.5rem 2rem;">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Nouveau Utilisateur</h2>
                    <p class="text-xs font-medium text-slate-500 mt-0.5">Remplissez les informations ci-dessous.</p>
                </div>
                <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="w-10 h-10 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-200 hover:text-slate-600 transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}" class="p-8 space-y-5">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Prénom</label>
                        <input type="text" name="prenom" required class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500" placeholder="Jean">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Nom</label>
                        <input type="text" name="nom" required class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500" placeholder="Dupont">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Nom d'affichage</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500" placeholder="Jean Dupont">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Adresse Email</label>
                    <input type="email" name="email" required class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500" placeholder="jean.dupont@ecole.com">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Mot de passe</label>
                    <input type="password" name="password" required minlength="6" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500" placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Rôle Système</label>
                    <select name="role" id="role-select" required class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500"
                            onchange="
                                document.getElementById('eleve-fields').classList.toggle('hidden', this.value !== 'eleve');
                                document.getElementById('enseignant-fields').classList.toggle('hidden', this.value !== 'enseignant');
                            ">
                        <option value="admin">Administrateur</option>
                        <option value="enseignant">Enseignant</option>
                        <option value="eleve">Élève</option>
                    </select>
                </div>
                
                <div id="enseignant-fields" class="hidden">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Spécialité / Matière</label>
                    <select name="matiere_id" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
                        <option value="">-- Sélectionner --</option>
                        @foreach(\App\Models\Matiere::all() as $matiere)
                            <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="eleve-fields" class="hidden space-y-5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Date de naissance</label>
                        <input type="date" name="date_naissance" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Classe Assignée</label>
                        <select name="classe_id" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
                            <option value="">-- Sélectionner --</option>
                            @foreach(\App\Models\Classe::all() as $classe)
                                <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl transition-all shadow-xl shadow-blue-200 mt-2 active:scale-95">
                    Créer le compte
                </button>
            </form>
        </div>
    </div>

    {{-- Edit User Modal --}}
    <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 transition-opacity" style="background-color: rgba(0,0,0,0.6);" onclick="document.getElementById('edit-modal').classList.add('hidden')"></div>
        <div class="relative bg-white shadow-2xl w-full max-w-md transform transition-all" style="border-radius: 16px; overflow: hidden; border: 1px solid #e5e7eb;">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50" style="padding: 1.5rem 2rem;">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Modifier Profil</h2>
                    <p class="text-xs font-medium text-slate-500 mt-0.5">Mettre à jour les informations.</p>
                </div>
                <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')" class="w-10 h-10 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-200 hover:text-slate-600 transition-all">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="edit-form" method="POST" action="" class="p-8 space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Nom complet</label>
                    <input type="text" name="name" id="edit-name" required class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Adresse Email</label>
                    <input type="email" name="email" id="edit-email" required class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Changer mot de passe (optionnel)</label>
                    <input type="password" name="password" minlength="6" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500" placeholder="Laisser vide pour garder l'actuel">
                </div>
                
                <div id="edit-enseignant-fields" class="hidden">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Spécialité / Matière</label>
                    <select name="matiere_id" id="edit-matiere-id" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
                        <option value="">-- Sélectionner --</option>
                        @foreach(\App\Models\Matiere::all() as $matiere)
                            <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div id="edit-eleve-fields" class="hidden">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-1.5 ml-1">Classe Assignée</label>
                    <select name="classe_id" id="edit-classe-id" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
                        <option value="">-- Sélectionner --</option>
                        @foreach(\App\Models\Classe::all() as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl transition-all shadow-xl shadow-blue-200 mt-2 active:scale-95" style="background-color: #2563eb;">
                    Mettre à jour
                </button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, email, role, extraId) {
            const form = document.getElementById('edit-form');
            form.action = `/admin/users/${id}`;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            
            document.getElementById('edit-eleve-fields').classList.toggle('hidden', role !== 'eleve');
            document.getElementById('edit-enseignant-fields').classList.toggle('hidden', role !== 'enseignant');
            
            if (role === 'eleve') {
                document.getElementById('edit-classe-id').value = extraId || "";
            } else if (role === 'enseignant') {
                document.getElementById('edit-matiere-id').value = extraId || "";
            }
            
            document.getElementById('edit-modal').classList.remove('hidden');
        }
    </script>
</x-school-layout>
