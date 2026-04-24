<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un Créneaux à l\'Emploi du Temps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('timetable.store') }}" method="POST">
                        @csrf

                        <!-- Classe -->
                        <div class="mb-6">
                            <label for="classe_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Classe <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="classe_id"
                                name="classe_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('classe_id') border-red-500 @enderror"
                            >
                                <option value="">-- Sélectionnez une classe --</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom }} ({{ $classe->eleves->count() }} élève{{ $classe->eleves->count() !== 1 ? 's' : '' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('classe_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jour -->
                        <div class="mb-6">
                            <label for="jour" class="block text-gray-700 text-sm font-bold mb-2">
                                Jour <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="jour"
                                name="jour"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jour') border-red-500 @enderror"
                            >
                                <option value="">-- Sélectionnez un jour --</option>
                                @foreach(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'] as $jour)
                                    <option value="{{ $jour }}" {{ old('jour') === $jour ? 'selected' : '' }}>
                                        {{ ucfirst($jour) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jour')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Heure Début -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="heure_debut" class="block text-gray-700 text-sm font-bold mb-2">
                                    Heure Début <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="time"
                                    id="heure_debut"
                                    name="heure_debut"
                                    value="{{ old('heure_debut') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('heure_debut') border-red-500 @enderror"
                                >
                                @error('heure_debut')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Heure Fin -->
                            <div>
                                <label for="heure_fin" class="block text-gray-700 text-sm font-bold mb-2">
                                    Heure Fin <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="time"
                                    id="heure_fin"
                                    name="heure_fin"
                                    value="{{ old('heure_fin') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('heure_fin') border-red-500 @enderror"
                                >
                                @error('heure_fin')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Matière -->
                        <div class="mb-6">
                            <label for="matiere_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Matière <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="matiere_id"
                                name="matiere_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('matiere_id') border-red-500 @enderror"
                            >
                                <option value="">-- Sélectionnez une matière --</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matiere_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Enseignant -->
                        <div class="mb-6">
                            <label for="enseignant_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Enseignant <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="enseignant_id"
                                name="enseignant_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('enseignant_id') border-red-500 @enderror"
                            >
                                <option value="">-- Sélectionnez un enseignant --</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}" {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->prenom }} {{ $enseignant->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('enseignant_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Salle -->
                        <div class="mb-6">
                            <label for="salle" class="block text-gray-700 text-sm font-bold mb-2">
                                Salle
                            </label>
                            <input
                                type="text"
                                id="salle"
                                name="salle"
                                value="{{ old('salle') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('salle') border-red-500 @enderror"
                                placeholder="Ex: 101, Labo, Salle Informatique"
                            >
                            @error('salle')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4">
                            <button
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Ajouter le Créneaux
                            </button>
                            <a
                                href="{{ route('timetable.index') }}"
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
