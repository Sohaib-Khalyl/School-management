<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier la Classe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('classes.update', $classe->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">
                                Nom de la Classe <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                value="{{ old('nom', $classe->nom) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nom') border-red-500 @enderror"
                                placeholder="Ex: 1A, 2B, 3C"
                            >
                            @error('nom')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Additional Info -->
                        <div class="mb-6 p-4 bg-gray-100 rounded">
                            <p class="text-sm text-gray-700">
                                <strong>Nombre d'élèves:</strong> {{ $classe->eleves()->count() }}
                            </p>
                            <p class="text-sm text-gray-700">
                                <strong>Crénaux définis:</strong> {{ $classe->emploisDuTemps()->count() }}
                            </p>
                        </div>

                        <div class="flex gap-4">
                            <button
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Mettre à Jour
                            </button>
                            <a
                                href="{{ route('classes.index') }}"
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
