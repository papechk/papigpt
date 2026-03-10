<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white font-display">
            Supprimer le compte
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Téléchargez vos données avant de procéder.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Supprimer le compte</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Êtes-vous sûr de vouloir supprimer votre compte ?
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Cette action est irréversible. Entrez votre mot de passe pour confirmer.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Mot de passe</label>
                <input id="password" name="password" type="password" class="w-full sm:w-3/4 rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-[#BEFF00] focus:ring-[#BEFF00] text-sm" placeholder="Mot de passe" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Annuler
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    Supprimer le compte
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
