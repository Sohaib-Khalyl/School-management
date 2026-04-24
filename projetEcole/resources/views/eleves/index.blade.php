<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Élèves') }}
            </h2>
            <a href="{{ route('eleves.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Ajouter un Élève
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($eleves->count())
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Nom</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Prénom</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Classe</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Date de Naissance</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eleves as $eleve)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $eleve->id }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $eleve->nom }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $eleve->prenom }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $eleve->email }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if($eleve->classe)
                                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                                    {{ $eleve->classe->nom }}
                                                </span>
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">{{ \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <a href="{{ route('eleves.edit', $eleve->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm mr-2">
                                                Modifier
                                            </a>
                                            <form action="{{ route('eleves.destroy', $eleve->id) }}" method="POST" style="display:inline;">
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
                        <p class="text-gray-500 text-center py-4">Aucun élève trouvé. <a href="{{ route('eleves.create') }}" class="text-blue-500 hover:text-blue-700">Ajouter un élève</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
