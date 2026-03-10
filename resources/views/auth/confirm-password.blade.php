<x-guest-layout>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1" style="font-family: 'Syne', sans-serif;">Confirmation requise</h2>
    <p class="text-sm text-gray-500 mb-6">Veuillez confirmer votre mot de passe avant de continuer.</p>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] bg-white dark:bg-[#0C0C0C] text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 text-sm px-4 py-3 focus:border-[#BEFF00] focus:ring-[#BEFF00] transition">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <button type="submit"
                class="w-full flex justify-center py-3 px-4 rounded-xl text-sm font-semibold text-[#0C0C0C] transition"
                style="background-color: #BEFF00;"
                onmouseover="this.style.backgroundColor='#a8e000'"
                onmouseout="this.style.backgroundColor='#BEFF00'">
            Confirmer
        </button>
    </form>
</x-guest-layout>
