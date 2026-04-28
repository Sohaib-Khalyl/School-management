<x-school-layout>
    <x-slot name="sidebar">
        @include('layouts.partials.sidebar-student')
    </x-slot>

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Mon Profil</h1>

    <div class="max-w-lg">
        <form method="POST" action="{{ route('eleve.profile.update') }}" class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full border-gray-300 rounded-lg">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full border-gray-300 rounded-lg">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            @if($eleve)
            <div class="pt-4 border-t border-gray-100 space-y-3">
                <h3 class="text-sm font-semibold text-gray-500 uppercase">Informations scolaires</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                    <input type="text" value="{{ $eleve->classe->nom ?? 'Non assigné' }}" disabled
                           class="w-full border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                    <p class="text-xs text-gray-400 mt-1">Contactez l'administration pour changer de classe.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                    <input type="text" value="{{ $eleve->date_naissance ? \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') : '—' }}" disabled
                           class="w-full border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                </div>
            </div>
            @endif

            <div class="pt-2">
                <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium text-sm transition-colors">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</x-school-layout>
