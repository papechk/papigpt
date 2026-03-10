<x-guest-layout>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1" style="font-family: 'Syne', sans-serif;">Mot de passe oublié</h2>
    <p class="text-sm text-gray-500 mb-6">Entrez votre e-mail pour recevoir un lien de réinitialisation.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 text-sm px-4 py-3 focus:border-[#BEFF00] focus:ring-[#BEFF00] transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <button type="submit"
                class="w-full flex justify-center py-3 px-4 rounded-xl text-sm font-semibold text-[#0C0C0C] transition"
                style="background-color: #BEFF00;"
                onmouseover="this.style.backgroundColor='#a8e000'"
                onmouseout="this.style.backgroundColor='#BEFF00'">
            Envoyer le lien
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        <a href="{{ route('login') }}" class="font-medium text-[#BEFF00] hover:underline">Retour à la connexion</a>
    </p>
</x-guest-layout>
