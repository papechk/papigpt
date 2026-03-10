<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2.5 bg-[#BEFF00] border border-transparent rounded-xl font-semibold text-xs text-[#0C0C0C] uppercase tracking-widest hover:bg-[#a8e000] focus:bg-[#a8e000] active:bg-[#93c700] focus:outline-none focus:ring-2 focus:ring-[#BEFF00] focus:ring-offset-2 dark:focus:ring-offset-[#161616] transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
