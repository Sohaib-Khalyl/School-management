<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion des Classes') }}
            </h2>
            <a href="{{ route('classes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Ajouter une Classe
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if($message = Session::get('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ $message }}
                </div>
            @endif

            @if($message = Session::get('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $message }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($classes->count())
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">Élèves</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">Crénaux</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classes as $classe)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            <strong>{{ $classe->nom }}</strong>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                                {{ $classe->eleves_count }}
                                            </span>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                                {{ $classe->emplois_du_temps_count }}
                                            </span>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <a href="{{ route('classes.edit', $classe->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm mr-2">
                                                Modifier
                                            </a>
                                            <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm" onclick="return confirm('Êtes-vous sûr?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500 text-center py-4">Aucune classe trouvée. <a href="{{ route('classes.create') }}" class="text-blue-500 hover:text-blue-700">Ajouter une classe</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
