<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('notes.update', $note->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-6">
                            <label for="id_eleve" class="block text-gray-700 text-sm font-bold mb-2">
                                Élève <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="id_eleve"
                                name="id_eleve"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('id_eleve') border-red-500 @enderror"
                            >
                                <option value="">Sélectionnez un élève</option>
                                @foreach($eleves as $eleve)
                                    <option value="{{ $eleve->id }}" {{ old('id_eleve', $note->id_eleve) == $eleve->id ? 'selected' : '' }}>
                                        {{ $eleve->nom }} {{ $eleve->prenom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_eleve')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="id_evaluation" class="block text-gray-700 text-sm font-bold mb-2">
                                Évaluation <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="id_evaluation"
                                name="id_evaluation"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('id_evaluation') border-red-500 @enderror"
                            >
                                <option value="">Sélectionnez une évaluation</option>
                                @foreach($evaluations as $evaluation)
                                    <option value="{{ $evaluation->id }}" {{ old('id_evaluation', $note->id_evaluation) == $evaluation->id ? 'selected' : '' }}>
                                        {{ $evaluation->matiere->nom ?? 'N/A' }} - {{ $evaluation->type }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_evaluation')
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
                                href="{{ route('notes.index') }}"
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
