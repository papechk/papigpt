<x-guest-layout>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1" style="font-family: 'Syne', sans-serif;">Créer un compte</h2>
    <p class="text-sm text-gray-500 mb-6">Rejoignez PapiGPT pour gérer vos documents.</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nom complet</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 text-sm px-4 py-3 focus:border-[#BEFF00] focus:ring-[#BEFF00] transition">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 text-sm px-4 py-3 focus:border-[#BEFF00] focus:ring-[#BEFF00] transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 text-sm px-4 py-3 focus:border-[#BEFF00] focus:ring-[#BEFF00] transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 text-sm px-4 py-3 focus:border-[#BEFF00] focus:ring-[#BEFF00] transition">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <button type="submit"
                class="w-full flex justify-center py-3 px-4 rounded-xl text-sm font-semibold text-[#0C0C0C] transition"
                style="background-color: #BEFF00;"
                onmouseover="this.style.backgroundColor='#a8e000'"
                onmouseout="this.style.backgroundColor='#BEFF00'">
            Créer mon compte
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Déjà inscrit ?
        <a href="{{ route('login') }}" class="font-medium text-[#BEFF00] hover:underline">Se connecter</a>
    </p>
</x-guest-layout>
