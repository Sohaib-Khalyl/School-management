<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter une Évaluation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('evaluations.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="id_matiere" class="block text-gray-700 text-sm font-bold mb-2">
                                Matière <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="id_matiere"
                                name="id_matiere"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('id_matiere') border-red-500 @enderror"
                            >
                                <option value="">Sélectionnez une matière</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" {{ old('id_matiere') == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_matiere')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">
                                Type <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="type"
                                name="type"
                                value="{{ old('type') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror"
                                placeholder="ex: Examen, Contrôle, Quiz"
                            >
                            @error('type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Ajouter
                            </button>
                            <a
                                href="{{ route('evaluations.index') }}"
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
