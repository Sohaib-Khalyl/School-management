<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Matières') }}
            </h2>
            <a href="{{ route('matieres.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Ajouter une Matière
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($matieres->count())
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matieres as $matiere)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $matiere->id }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $matiere->nom }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <a href="{{ route('matieres.edit', $matiere->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm mr-2">
                                                Modifier
                                            </a>
                                            <form action="{{ route('matieres.destroy', $matiere->id) }}" method="POST" style="display:inline;">
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
                        <p class="text-gray-500 text-center py-4">Aucune matière trouvée. <a href="{{ route('matieres.create') }}" class="text-blue-500 hover:text-blue-700">Ajouter une matière</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
