<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">
            @if($role === 'admin') Espace Administration
            @elseif($role === 'enseignant') Espace Enseignant
            @elseif($role === 'eleve') Espace Élève
            @else Connexion
            @endif
        </h2>
        <p class="text-gray-500 text-sm mt-1">Connectez-vous à votre compte</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="role" value="{{ $role }}">

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                   placeholder="votre@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
            <input id="password" type="password" name="password" required
                   class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">Se souvenir de moi</label>
        </div>

        <button type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
            Se connecter
        </button>

        <p class="text-center">
            <a href="/" class="text-sm text-gray-500 hover:text-blue-600">← Retour à l'accueil</a>
        </p>
    </form>
</x-guest-layout>
