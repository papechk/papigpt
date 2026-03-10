@extends('layouts.tailadmin')

@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <!-- Titre -->
    <div>
        <h2 class="text-2xl font-bold font-display dark:text-white">Bienvenue, {{ Auth::user()->name }} !</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Gérez vos documents administratifs facilement.</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-4">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-subtle">
                    <svg class="h-5 w-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xl font-bold dark:text-white">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500">Total documents</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-4">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-500/10">
                    <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xl font-bold dark:text-white">{{ $stats['letters'] }}</p>
                    <p class="text-xs text-gray-500">Lettres</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-4">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-500/10">
                    <svg class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xl font-bold dark:text-white">{{ $stats['proforma'] + $stats['invoices'] }}</p>
                    <p class="text-xs text-gray-500">Factures</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Derniers documents -->
    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616]">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-white/[0.06]">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold dark:text-white">Derniers documents</h3>
                <a href="{{ route('documents.index') }}" class="text-sm text-brand hover:underline">Voir tout</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            @if($recentDocuments->isEmpty())
                <div class="p-8 text-center text-gray-500">
                    <svg class="h-12 w-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p>Aucun document pour le moment.</p>
                    <p class="text-sm mt-1">Commencez par créer votre premier document !</p>
                </div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3">Document</th>
                            <th class="px-6 py-3 hidden sm:table-cell">Date</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/[0.06]">
                        @foreach($recentDocuments as $doc)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                            <td class="px-6 py-3">
                                <x-type-badge :type="$doc->type">{{ $doc->getTypeLabel() }}</x-type-badge>
                            </td>
                            <td class="px-6 py-3 text-sm dark:text-gray-300">
                                {{ $doc->objet ?: ($doc->client_name ?? '-') }}
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-500 hidden sm:table-cell">{{ $doc->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-3 text-right">
                                <a href="{{ route('documents.show', $doc) }}" class="text-sm text-brand hover:underline">Voir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
