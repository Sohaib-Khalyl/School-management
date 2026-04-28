<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-admin')
    </x-slot>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Tableau de bord</h1>
        <p class="text-slate-500 text-sm mt-1">Vue d'ensemble de l'établissement</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-5 flex flex-col gap-3">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600" style="font-variation-settings: 'FILL' 1;">group</span>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900">{{ $stats['eleves'] }}</p>
                <p class="text-sm text-slate-500 font-medium">Élèves</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 flex flex-col gap-3">
            <div class="w-10 h-10 bg-violet-50 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-violet-600" style="font-variation-settings: 'FILL' 1;">record_voice_over</span>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900">{{ $stats['enseignants'] }}</p>
                <p class="text-sm text-slate-500 font-medium">Enseignants</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 flex flex-col gap-3">
            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-600" style="font-variation-settings: 'FILL' 1;">school</span>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900">{{ $stats['classes'] }}</p>
                <p class="text-sm text-slate-500 font-medium">Classes</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 flex flex-col gap-3">
            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-orange-500" style="font-variation-settings: 'FILL' 1;">menu_book</span>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900">{{ $stats['matieres'] }}</p>
                <p class="text-sm text-slate-500 font-medium">Matières</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Classes --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="text-base font-bold text-slate-900 mb-4">Répartition par classe</h2>
            @if($classes->isEmpty())
                <p class="text-slate-400 text-sm">Aucune classe enregistrée.</p>
            @else
                <div class="space-y-2">
                    @foreach($classes as $classe)
                    <div class="flex items-center justify-between px-4 py-3 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-400 text-[20px]">meeting_room</span>
                            <span class="font-medium text-slate-800 text-sm">{{ $classe->nom }}</span>
                        </div>
                        <span class="text-sm text-slate-500">{{ $classe->eleves_count }} élève{{ $classe->eleves_count > 1 ? 's' : '' }}</span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Recent Users --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-slate-900">Derniers utilisateurs</h2>
                <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 font-medium hover:underline">Voir tout</a>
            </div>
            @if($recentUsers->isEmpty())
                <p class="text-slate-400 text-sm">Aucun utilisateur.</p>
            @else
                <div class="space-y-3">
                    @foreach($recentUsers as $user)
                    <div class="flex items-center gap-3">
                        <img class="w-8 h-8 rounded-full border border-slate-100"
                             src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF"
                             alt="{{ $user->name }}">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                        </div>
                        <span class="text-[11px] px-2 py-1 rounded-full font-semibold
                            {{ $user->role === 'admin' ? 'bg-blue-50 text-blue-700' :
                               ($user->role === 'enseignant' ? 'bg-violet-50 text-violet-700' : 'bg-orange-50 text-orange-600') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-school-layout>
