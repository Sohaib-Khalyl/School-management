<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GestionEcole</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased min-h-screen flex flex-col items-center justify-center p-6">
    <div class="max-w-md w-full text-center space-y-8">
        <div>
            <h1 class="text-3xl font-bold text-blue-600">GestionEcole</h1>
            <p class="text-gray-500 mt-1">Plateforme de gestion scolaire</p>
        </div>

        <div class="space-y-3">
            <a href="{{ route('login.role', 'admin') }}"
               class="flex items-center gap-3 w-full bg-white p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all text-left">
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                    <span class="material-symbols-outlined">admin_panel_settings</span>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">Espace Admin</p>
                    <p class="text-xs text-gray-500">Gérer l'établissement</p>
                </div>
                <span class="material-symbols-outlined text-gray-300">chevron_right</span>
            </a>

            <a href="{{ route('login.role', 'enseignant') }}"
               class="flex items-center gap-3 w-full bg-white p-4 rounded-xl border border-gray-200 hover:border-purple-300 hover:shadow-md transition-all text-left">
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">Espace Enseignant</p>
                    <p class="text-xs text-gray-500">Notes et évaluations</p>
                </div>
                <span class="material-symbols-outlined text-gray-300">chevron_right</span>
            </a>

            <a href="{{ route('login.role', 'eleve') }}"
               class="flex items-center gap-3 w-full bg-white p-4 rounded-xl border border-gray-200 hover:border-orange-300 hover:shadow-md transition-all text-left">
                <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center text-orange-600">
                    <span class="material-symbols-outlined">person</span>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">Espace Élève</p>
                    <p class="text-xs text-gray-500">Consulter mes notes</p>
                </div>
                <span class="material-symbols-outlined text-gray-300">chevron_right</span>
            </a>
        </div>

        <p class="text-gray-400 text-xs">© {{ date('Y') }} GestionEcole</p>
    </div>
</body>
</html>
