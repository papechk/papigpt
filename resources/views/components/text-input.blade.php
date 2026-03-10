@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-[#BEFF00] dark:focus:border-[#BEFF00] focus:ring-[#BEFF00] dark:focus:ring-[#BEFF00] rounded-xl shadow-sm']) }}>
