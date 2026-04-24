<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter une Matière') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('matieres.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                value="{{ old('nom') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nom') border-red-500 @enderror"
                                placeholder="Entrez le nom de la matière"
                            >
                            @error('nom')
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
                                href="{{ route('matieres.index') }}"
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
