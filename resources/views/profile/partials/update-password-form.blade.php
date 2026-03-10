<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white font-display">
            Modifier le mot de passe
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Utilisez un mot de passe long et aléatoire pour sécuriser votre compte.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mot de passe actuel</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-[#BEFF00] focus:ring-[#BEFF00] text-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nouveau mot de passe</label>
            <input id="update_password_password" name="password" type="password" class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-[#BEFF00] focus:ring-[#BEFF00] text-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmer le mot de passe</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-[#BEFF00] focus:ring-[#BEFF00] text-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#BEFF00] text-[#0C0C0C] text-sm font-semibold hover:bg-[#a8e000] transition">Enregistrer</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-500 dark:text-gray-400">Enregistré.</p>
            @endif
        </div>
    </form>
</section>
