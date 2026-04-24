<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier Élève') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('eleves.update', $eleve->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-6">
                            <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                value="{{ old('nom', $eleve->nom) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nom') border-red-500 @enderror"
                                placeholder="Entrez le nom"
                            >
                            @error('nom')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="prenom" class="block text-gray-700 text-sm font-bold mb-2">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="prenom"
                                name="prenom"
                                value="{{ old('prenom', $eleve->prenom) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('prenom') border-red-500 @enderror"
                                placeholder="Entrez le prénom"
                            >
                            @error('prenom')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="date_naissance" class="block text-gray-700 text-sm font-bold mb-2">
                                Date de Naissance <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="date"
                                id="date_naissance"
                                name="date_naissance"
                                value="{{ old('date_naissance', $eleve->date_naissance) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('date_naissance') border-red-500 @enderror"
                            >
                            @error('date_naissance')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $eleve->email) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                                placeholder="exemple@email.com"
                            >
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="classe_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Classe
                            </label>
                            <select
                                id="classe_id"
                                name="classe_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('classe_id') border-red-500 @enderror"
                            >
                                <option value="">-- Sélectionnez une classe --</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ old('classe_id', $eleve->classe_id) == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classe_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Mettre à jour
                            </button>
                            <a
                                href="{{ route('eleves.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
