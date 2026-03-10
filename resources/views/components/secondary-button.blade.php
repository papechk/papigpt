<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2.5 bg-white dark:bg-[#161616] border border-gray-300 dark:border-white/[0.1] rounded-xl font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-white/[0.04] focus:outline-none focus:ring-2 focus:ring-[#BEFF00] focus:ring-offset-2 dark:focus:ring-offset-[#161616] disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
