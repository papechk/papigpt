<x-guest-layout>
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1" style="font-family: 'Syne', sans-serif;">Vérification e-mail</h2>
    <p class="text-sm text-gray-500 mb-6">Merci de votre inscription ! Vérifiez votre adresse e-mail en cliquant sur le lien que nous vous avons envoyé.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-xl bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 px-4 py-3 text-sm text-green-700 dark:text-green-400">
            Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
        </div>
    @endif

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    class="py-3 px-5 rounded-xl text-sm font-semibold text-[#0C0C0C] transition"
                    style="background-color: #BEFF00;"
                    onmouseover="this.style.backgroundColor='#a8e000'"
                    onmouseout="this.style.backgroundColor='#BEFF00'">
                Renvoyer le lien
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 dark:text-gray-400 hover:text-[#BEFF00] transition">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>
