@extends('layouts.tailadmin')

@section('title', 'Templates')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold font-display dark:text-white">Templates</h2>
        <a href="{{ route('templates.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand text-[#0C0C0C] text-sm font-semibold hover:bg-brand-hover transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Nouveau template
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($templates as $template)
        <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-5 space-y-3">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $template->name }}</h3>
                    <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            @if($template->type === 'letter') bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400
                            @elseif($template->type === 'invoice_proforma') bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400
                            @elseif($template->type === 'invoice_final') bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400
                            @elseif($template->type === 'contrat') bg-purple-100 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400
                            @elseif($template->type === 'note_officielle') bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400
                            @elseif($template->type === 'page_garde') bg-cyan-100 text-cyan-700 dark:bg-cyan-500/10 dark:text-cyan-400
                            @endif
                        ">
                            {{ $template->type === 'letter' ? 'Lettre' : ($template->type === 'invoice_proforma' ? 'Proforma' : ($template->type === 'invoice_final' ? 'Facture' : ($template->type === 'contrat' ? 'Contrat' : ($template->type === 'note_officielle' ? 'Note' : 'Page de garde')))) }}
                        </span>
                        @if($template->variables && count($template->variables))
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-white/[0.06] dark:text-gray-400">
                            {{ count($template->variables) }} variables
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3">{{ Str::limit($template->content, 120) }}</p>
            <div class="flex items-center gap-2 pt-1">
                <a href="{{ route('templates.edit', $template) }}" class="text-sm text-brand hover:underline">Modifier</a>
                <span class="text-gray-300 dark:text-gray-600">|</span>
                <form method="POST" action="{{ route('templates.destroy', $template) }}" class="inline" onsubmit="return confirm('Supprimer ce template ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-500 hover:underline">Supprimer</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full p-8 text-center text-gray-500 rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616]">
            <p>Aucun template.</p>
            <a href="{{ route('templates.create') }}" class="text-brand hover:underline text-sm mt-1 inline-block">Créer le premier template</a>
        </div>
        @endforelse
    </div>
</div>
@endsection
