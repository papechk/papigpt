@props(['type'])
@php
$classes = match($type) {
    'letter' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',
    'invoice_proforma' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400',
    'invoice_final' => 'bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400',
    'contrat' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400',
    'note_officielle' => 'bg-teal-100 text-teal-700 dark:bg-teal-500/10 dark:text-teal-400',
    'page_garde' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400',
    default => 'bg-gray-100 text-gray-700 dark:bg-gray-500/10 dark:text-gray-400',
};
@endphp
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ $slot }}
</span>
