<x-guest-layout>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1" style="font-family: 'Syne', sans-serif;">Nouveau mot de passe</h2>
    <p class="text-sm text-gray-500 mb-6">Choisissez un nouveau mot de passe sécurisé.</p>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 text-sm px-4 py-3 focus:border-[#BEFF00] focus:ring-[#BEFF00] transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nouveau mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 text-sm px-4 py-3 focus:border-[#BEFF00] focus:ring-[#BEFF00] transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

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
            Réinitialiser le mot de passe
        </button>
    </form>
</x-guest-layout>
