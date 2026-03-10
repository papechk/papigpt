<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white font-display">
            Informations du profil
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Mettez à jour vos informations personnelles et votre adresse e-mail.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom complet</label>
            <input id="name" name="name" type="text" class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-[#BEFF00] focus:ring-[#BEFF00] text-sm" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse e-mail</label>
            <input id="email" name="email" type="email" class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-[#BEFF00] focus:ring-[#BEFF00] text-sm" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-700 dark:text-gray-300">
                        Votre adresse e-mail n'est pas vérifiée.
                        <button form="send-verification" class="underline text-sm text-[#BEFF00] hover:text-[#a8e000] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#BEFF00] dark:focus:ring-offset-[#161616]">
                            Cliquez ici pour renvoyer l'e-mail de vérification.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            Un nouveau lien de vérification a été envoyé.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#BEFF00] text-[#0C0C0C] text-sm font-semibold hover:bg-[#a8e000] transition">Enregistrer</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-500 dark:text-gray-400">Enregistré.</p>
            @endif
        </div>
    </form>
</section>
