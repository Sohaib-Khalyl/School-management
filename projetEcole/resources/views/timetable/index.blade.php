<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Emploi du Temps') }}
            </h2>
            <a href="{{ route('timetable.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Ajouter un Créneaux
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

            <!-- Filter by Class -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <form method="GET" action="{{ route('timetable.index') }}" class="flex gap-4 items-center">
                    <div class="flex-1">
                        <label for="classe_id" class="block text-gray-700 text-sm font-bold mb-2">
                            Filtrer par Classe:
                        </label>
                        <select name="classe_id" id="classe_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Toutes les classes --</option>
                            @foreach($allClasses as $id => $nom)
                                <option value="{{ $id }}" {{ $selectedClasseId == $id ? 'selected' : '' }}>
                                    {{ $nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2 pt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Filtrer
                        </button>
                        <a href="{{ route('timetable.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            <!-- Timetable Display -->
            @if(count($classes) > 0)
                @foreach($classes as $classe)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Classe: {{ $classe->nom }}</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                <strong>Nombre d'élèves:</strong> {{ $classe->eleves->count() }}
                            </p>

                            @if($classe->emploisDuTemps->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse border border-gray-300">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="border border-gray-300 px-4 py-2 text-left font-bold">Jour</th>
                                                <th class="border border-gray-300 px-4 py-2 text-left font-bold">Heure</th>
                                                <th class="border border-gray-300 px-4 py-2 text-left font-bold">Matière</th>
                                                <th class="border border-gray-300 px-4 py-2 text-left font-bold">Enseignant</th>
                                                <th class="border border-gray-300 px-4 py-2 text-left font-bold">Salle</th>
                                                <th class="border border-gray-300 px-4 py-2 text-center font-bold">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $jours_order = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
                                                $jour_names = [
                                                    'lundi' => 'Lundi',
                                                    'mardi' => 'Mardi',
                                                    'mercredi' => 'Mercredi',
                                                    'jeudi' => 'Jeudi',
                                                    'vendredi' => 'Vendredi',
                                                    'samedi' => 'Samedi'
                                                ];
                                            @endphp

                                            @foreach($jours_order as $jour)
                                                @php
                                                    $entries = $classe->emploisDuTemps->filter(function($e) use ($jour) {
                                                        return $e->jour === $jour;
                                                    })->sortBy('heure_debut');
                                                @endphp
                                                @foreach($entries as $entry)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="border border-gray-300 px-4 py-2">
                                                            {{ $jour_names[$jour] }}
                                                        </td>
                                                        <td class="border border-gray-300 px-4 py-2 text-sm">
                                                            {{ $entry->heure_debut }} - {{ $entry->heure_fin }}
                                                        </td>
                                                        <td class="border border-gray-300 px-4 py-2">
                                                            {{ $entry->matiere->nom ?? 'N/A' }}
                                                        </td>
                                                        <td class="border border-gray-300 px-4 py-2">
                                                            {{ $entry->enseignant->prenom ?? '' }} {{ $entry->enseignant->nom ?? '' }}
                                                        </td>
                                                        <td class="border border-gray-300 px-4 py-2">
                                                            {{ $entry->salle ?? '-' }}
                                                        </td>
                                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                                            <a href="{{ route('timetable.edit', $entry->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm mr-2">
                                                                Modifier
                                                            </a>
                                                            <form action="{{ route('timetable.destroy', $entry->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm" onclick="return confirm('Êtes-vous sûr?')">
                                                                    Supprimer
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-4">
                                    Aucun créneaux défini pour cette classe.
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p class="text-gray-500 text-center py-4">
                            Aucune classe trouvée.
                            <a href="{{ route('classes.create') }}" class="text-blue-500 hover:text-blue-700">Créer une classe</a>
