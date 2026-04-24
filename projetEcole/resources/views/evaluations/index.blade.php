<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Évaluations') }}
            </h2>
            <a href="{{ route('evaluations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Ajouter une Évaluation
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($evaluations->count())
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Matière</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Type</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($evaluations as $evaluation)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $evaluation->id }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $evaluation->matiere->nom ?? 'N/A' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $evaluation->type }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <a href="{{ route('evaluations.edit', $evaluation->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm mr-2">
                                                Modifier
                                            </a>
                                            <form action="{{ route('evaluations.destroy', $evaluation->id) }}" method="POST" style="display:inline;">
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
                        <p class="text-gray-500 text-center py-4">Aucune évaluation trouvée. <a href="{{ route('evaluations.create') }}" class="text-blue-500 hover:text-blue-700">Ajouter une évaluation</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
