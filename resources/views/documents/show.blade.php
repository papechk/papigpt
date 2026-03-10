@extends('layouts.tailadmin')

@section('title', $document->getTypeLabel() . ' #' . $document->id)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('documents.index') }}" class="flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-white/[0.08] text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/[0.04] transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold font-display dark:text-white">{{ $document->getTypeLabel() }} #{{ $document->id }}</h2>
                <p class="text-sm text-gray-500">Créé le {{ $document->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('documents.download', [$document, 'pdf']) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                PDF
            </a>
            <a href="{{ route('documents.download', [$document, 'word']) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-500 text-white text-sm font-semibold hover:bg-indigo-600 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Word
            </a>
            @if(in_array($document->type, ['invoice_proforma', 'invoice_final']))
            <a href="{{ route('documents.download', [$document, 'excel']) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 text-white text-sm font-semibold hover:bg-emerald-600 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                Excel
            </a>
            @endif
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Type</p>
                <x-type-badge :type="$document->type">{{ $document->getTypeLabel() }}</x-type-badge>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">{{ $document->type === 'letter' ? 'Destinataire' : 'Client / Partie' }}</p>
                <p class="font-medium dark:text-white">{{ $document->civilite ? $document->civilite . ' ' : '' }}{{ $document->client_name ?? '-' }}</p>
            </div>
            @if($document->client_address)
            <div class="md:col-span-2">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Adresse</p>
                <p class="dark:text-gray-300">{{ $document->client_address }}</p>
            </div>
            @endif
            @if($document->objet)
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Objet</p>
                <p class="dark:text-gray-300">{{ $document->objet }}</p>
            </div>
            @endif
            @if($document->reference)
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Référence</p>
                <p class="dark:text-gray-300">{{ $document->reference }}</p>
            </div>
            @endif
            @if($document->duree)
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Durée</p>
                <p class="dark:text-gray-300">{{ $document->duree }}</p>
            </div>
            @endif
            @if($document->template)
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Template</p>
                <p class="dark:text-gray-300">{{ $document->template->name }}</p>
            </div>
            @endif
            @if($document->type === 'letter' && $document->design)
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Design PDF</p>
                <p class="dark:text-gray-300">{{ ucfirst($document->design) }}</p>
            </div>
            @endif
        </div>
    </div>

    @if(in_array($document->type, ['letter', 'contrat', 'note_officielle', 'page_garde']))
    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6">
        <h3 class="font-semibold dark:text-white mb-3">Contenu</h3>
        <div class="prose dark:prose-invert max-w-none text-sm">
            {!! nl2br(e($document->content)) !!}
        </div>
    </div>
    @elseif(in_array($document->type, ['invoice_proforma', 'invoice_final']))
    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616]">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-white/[0.06]">
            <h3 class="font-semibold dark:text-white">Détail des lignes</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100 dark:border-white/[0.06]">
                        <th class="px-6 py-3">Désignation</th>
                        <th class="px-6 py-3 text-center">Quantité</th>
                        <th class="px-6 py-3 text-right">Prix unitaire</th>
                        <th class="px-6 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/[0.06]">
                    @foreach($document->invoiceItems as $item)
                    <tr>
                        <td class="px-6 py-3 text-sm dark:text-gray-300">{{ $item->designation }}</td>
                        <td class="px-6 py-3 text-sm text-center dark:text-gray-300">{{ $item->quantity }}</td>
                        <td class="px-6 py-3 text-sm text-right dark:text-gray-300">{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-3 text-sm text-right font-medium dark:text-white">{{ number_format($item->total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-200 dark:border-white/[0.1]">
                        <td colspan="3" class="px-6 py-4 text-right font-semibold dark:text-white">TOTAL :</td>
                        <td class="px-6 py-4 text-right text-lg font-bold text-brand">{{ number_format($document->total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
