@extends('layouts.tailadmin')

@section('title', 'Modifier le template')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('templates.index') }}" class="flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-white/[0.08] text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/[0.04] transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h2 class="text-2xl font-bold font-display dark:text-white">Modifier : {{ $template->name }}</h2>
    </div>

    <form method="POST" action="{{ route('templates.update', $template) }}" class="space-y-6">
        @csrf @method('PUT')

        <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du template</label>
                <input type="text" name="name" value="{{ old('name', $template->name) }}" required
                       class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                <select name="type" required class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm">
                    <option value="letter" {{ old('type', $template->type) === 'letter' ? 'selected' : '' }}>Lettre</option>
                    <option value="invoice_proforma" {{ old('type', $template->type) === 'invoice_proforma' ? 'selected' : '' }}>Facture Proforma</option>
                    <option value="invoice_final" {{ old('type', $template->type) === 'invoice_final' ? 'selected' : '' }}>Facture Définitive</option>
                    <option value="contrat" {{ old('type', $template->type) === 'contrat' ? 'selected' : '' }}>Contrat</option>
                    <option value="note_officielle" {{ old('type', $template->type) === 'note_officielle' ? 'selected' : '' }}>Note Officielle</option>
                    <option value="page_garde" {{ old('type', $template->type) === 'page_garde' ? 'selected' : '' }}>Page de Garde</option>
                </select>
                @error('type') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catégorie (optionnel)</label>
                <input type="text" name="category" value="{{ old('category', $template->category) }}"
                       class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                       placeholder="Ex: autorisation_tournage, demande_financement">
                @error('category') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contenu</label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Utilisez <code class="text-brand">{nom_variable}</code> pour insérer des variables dynamiques.</p>
                <textarea name="content" rows="12" required
                          class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm font-mono">{{ old('content', $template->content) }}</textarea>
                @error('content') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Variables (JSON, optionnel)</label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Définissez les variables sous forme JSON.</p>
                <textarea name="variables" rows="5"
                          class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm font-mono">{{ old('variables', $template->variables ? json_encode($template->variables, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                @error('variables') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('templates.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-white/[0.1] text-sm font-medium dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">Annuler</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand text-[#0C0C0C] text-sm font-semibold hover:bg-brand-hover transition">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
