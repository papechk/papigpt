@extends('layouts.tailadmin')

@section('title', 'Documents')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold font-display dark:text-white">Documents</h2>
        <div x-data="{ openNew: false }" class="relative">
            <button @click="openNew = !openNew" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand text-[#0C0C0C] text-sm font-semibold hover:bg-brand-hover transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Nouveau document
                <svg class="h-4 w-4 transition-transform" :class="openNew ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="openNew" @click.outside="openNew = false" x-transition class="absolute right-0 mt-2 w-52 rounded-xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#1a1a1a] shadow-lg z-50 py-2">
                <a href="{{ route('documents.create', ['type' => 'letter']) }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300">Lettre</a>
                <a href="{{ route('documents.create', ['type' => 'invoice_proforma']) }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300">Facture Proforma</a>
                <a href="{{ route('documents.create', ['type' => 'invoice_final']) }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300">Facture Définitive</a>
                <a href="{{ route('documents.create', ['type' => 'contrat']) }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300">Contrat</a>
                <a href="{{ route('documents.create', ['type' => 'note_officielle']) }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300">Note Officielle</a>
                <a href="{{ route('documents.create', ['type' => 'page_garde']) }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300">Page de Garde</a>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616]">
        <div class="overflow-x-auto">
            @if($documents->isEmpty())
                <div class="p-8 text-center text-gray-500">
                    <svg class="h-12 w-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p>Aucun document.</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100 dark:border-white/[0.06]">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3">Client</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/[0.06]">
                        @foreach($documents as $doc)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $doc->id }}</td>
                            <td class="px-6 py-3">
                                <x-type-badge :type="$doc->type">{{ $doc->getTypeLabel() }}</x-type-badge>
                            </td>
                            <td class="px-6 py-3 text-sm dark:text-gray-300">{{ $doc->client_name ?? '-' }}</td>
                            <td class="px-6 py-3 text-sm dark:text-gray-300">
                                @if(in_array($doc->type, ['invoice_proforma', 'invoice_final']))
                                    {{ number_format($doc->total, 0, ',', ' ') }} FCFA
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('documents.show', $doc) }}" class="text-sm text-brand hover:underline">Voir</a>
                                    <a href="{{ route('documents.download', [$doc, 'pdf']) }}" class="text-sm text-blue-500 hover:underline">PDF</a>
                                    <a href="{{ route('documents.download', [$doc, 'word']) }}" class="text-sm text-indigo-500 hover:underline">Word</a>
                                    @if(in_array($doc->type, ['invoice_proforma', 'invoice_final']))
                                    <a href="{{ route('documents.download', [$doc, 'excel']) }}" class="text-sm text-emerald-500 hover:underline">Excel</a>
                                    @endif
                                    <form method="POST" action="{{ route('documents.destroy', $doc) }}" class="inline" onsubmit="return confirm('Supprimer ce document ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-sm text-red-500 hover:underline">Suppr.</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4">
                    {{ $documents->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
