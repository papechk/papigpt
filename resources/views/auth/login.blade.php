<x-guest-layout>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1" style="font-family: 'Syne', sans-serif;">Connexion</h2>
    <p class="text-sm text-gray-500 mb-6">Accédez à votre espace de gestion documentaire.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 text-sm px-4 py-3 focus:border-[#BEFF00] focus:ring-[#BEFF00] transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 text-sm px-4 py-3 focus:border-[#BEFF00] focus:ring-[#BEFF00] transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-gray-300 dark:border-white/[0.2] bg-white dark:bg-[#0C0C0C] text-[#BEFF00] focus:ring-[#BEFF00] focus:ring-offset-white dark:focus:ring-offset-[#161616]">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-gray-500 dark:text-gray-400 hover:text-[#BEFF00] transition" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <button type="submit"
                class="w-full flex justify-center py-3 px-4 rounded-xl text-sm font-semibold text-[#0C0C0C] transition"
                style="background-color: #BEFF00;"
                onmouseover="this.style.backgroundColor='#a8e000'"
                onmouseout="this.style.backgroundColor='#BEFF00'">
            Se connecter
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="font-medium text-[#BEFF00] hover:underline">Créer un compte</a>
    </p>
</x-guest-layout>
