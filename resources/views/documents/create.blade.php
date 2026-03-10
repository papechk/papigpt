@extends('layouts.tailadmin')

@section('title', 'Créer un document')

@section('content')
<div class="space-y-6" x-data="documentForm()">
    <div class="flex items-center gap-3">
        <a href="{{ route('documents.index') }}" class="flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-white/[0.08] text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/[0.04] transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold font-display text-gray-900 dark:text-white">
                @if($type === 'letter') Créer une lettre
                @elseif($type === 'invoice_proforma') Créer une facture proforma
                @elseif($type === 'invoice_final') Créer une facture définitive
                @elseif($type === 'contrat') Créer un contrat
                @elseif($type === 'note_officielle') Créer une note officielle
                @elseif($type === 'page_garde') Créer une page de garde
                @endif
            </h2>
            @if($type === 'letter')
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5" x-show="step === 1">Choisissez un modèle pour commencer</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5" x-show="step === 2" x-cloak>Remplissez les informations de la lettre</p>
            @else
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5" x-show="step === 1">Choisissez un modèle pour commencer</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5" x-show="step === 2" x-cloak>Remplissez les informations du document</p>
            @endif
        </div>
    </div>

    <!-- Stepper visuel -->
    <div class="flex items-center gap-3 px-1">
        <div class="flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold transition-colors"
                  :class="step === 1 ? 'bg-brand text-[#0C0C0C]' : 'bg-brand/20 text-brand'">1</span>
            <span class="text-sm font-medium transition-colors" :class="step === 1 ? 'dark:text-white text-gray-900' : 'text-gray-400'">Modèle & Design</span>
        </div>
        <div class="flex-1 h-px bg-gray-200 dark:bg-white/[0.08]"></div>
        <div class="flex items-center gap-2">
            <span class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold transition-colors"
                  :class="step === 2 ? 'bg-brand text-[#0C0C0C]' : 'bg-gray-200 dark:bg-white/[0.08] text-gray-400'">2</span>
            <span class="text-sm font-medium transition-colors" :class="step === 2 ? 'dark:text-white text-gray-900' : 'text-gray-400'">Informations</span>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         LETTER TYPE — VISUAL GALLERY (mamcv-style)
         ═══════════════════════════════════════════════════════════════ --}}
    @if($type === 'letter' && $templates->isNotEmpty())

    {{-- ÉTAPE 1 : Galerie visuelle des templates --}}
    <div x-show="step === 1">
        {{-- Filtre par catégorie --}}
        <div class="flex flex-wrap gap-2 mb-6">
            <button type="button" @click="filterCategory = ''"
                    :class="filterCategory === '' ? 'bg-brand text-[#0C0C0C] font-semibold' : 'bg-white dark:bg-[#161616] text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-white/[0.08]'"
                    class="px-3.5 py-1.5 rounded-full text-xs transition hover:shadow-sm">
                Tous
            </button>
            @php
                $categories = $templates->pluck('category')->filter()->unique()->sort();
                $catLabels = [
                    'autorisation_tournage' => 'Autorisation',
                    'demande_financement' => 'Financement',
                    'demande_partenariat' => 'Partenariat',
                    'collaboration_artistique' => 'Collaboration',
                    'intention_projet' => 'Intention',
                    'invitation_evenement' => 'Invitation',
                    'remerciement' => 'Remerciement',
                    'recommandation' => 'Recommandation',
                    'notification_officielle' => 'Notification',
                ];
            @endphp
            @foreach($categories as $cat)
            <button type="button" @click="filterCategory = '{{ $cat }}'"
                    :class="filterCategory === '{{ $cat }}' ? 'bg-brand text-[#0C0C0C] font-semibold' : 'bg-white dark:bg-[#161616] text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-white/[0.08]'"
                    class="px-3.5 py-1.5 rounded-full text-xs transition hover:shadow-sm">
                {{ $catLabels[$cat] ?? ucfirst(str_replace('_', ' ', $cat)) }}
            </button>
            @endforeach
        </div>

        {{-- Option rédaction libre --}}
        <div class="mb-4">
            <button type="button" @click="selectTemplate('', '', 'classique'); step = 2; window.scrollTo({ top: 0, behavior: 'smooth' })"
                    class="w-full flex items-center gap-3 p-4 rounded-2xl border-2 border-dashed border-gray-300 dark:border-white/[0.1] text-gray-500 dark:text-gray-400 hover:border-brand hover:text-brand dark:hover:border-brand dark:hover:text-brand transition group">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 dark:bg-white/[0.04] group-hover:bg-brand/10 transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
                <div class="text-left">
                    <p class="text-sm font-medium">Rédaction libre</p>
                    <p class="text-xs opacity-70">Rédigez votre lettre sans modèle prédéfini</p>
                </div>
            </button>
        </div>

        {{-- Grille des templates --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            @foreach($templates as $tpl)
            @php
                $catColors = [
                    'autorisation_tournage' => '#3B82F6',
                    'demande_financement' => '#10B981',
                    'demande_partenariat' => '#8B5CF6',
                    'collaboration_artistique' => '#F59E0B',
                    'intention_projet' => '#EC4899',
                    'invitation_evenement' => '#06B6D4',
                    'remerciement' => '#F97316',
                    'recommandation' => '#6366F1',
                    'notification_officielle' => '#EF4444',
                ];
                $accent = $catColors[$tpl->category] ?? '#C8A415';
                $designLabels = ['classique' => 'Classique', 'moderne' => 'Moderne', 'elegant' => 'Élégant', 'corporate' => 'Corporate'];
                $tplDesign = $tpl->design ?? 'classique';
                $designColors = ['classique' => '#C8A415', 'moderne' => '#3f3861', 'elegant' => '#b08657', 'corporate' => '#1a2744'];
                $catSvgs = [
                    'autorisation_tournage' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>',
                    'demande_financement' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>',
                    'demande_partenariat' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>',
                    'collaboration_artistique' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42"/></svg>',
                    'intention_projet' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>',
                    'invitation_evenement' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>',
                    'remerciement' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>',
                    'recommandation' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>',
                    'notification_officielle' => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38a.75.75 0 0 1-1.021-.27l-.112-.194a8.966 8.966 0 0 1-1.084-4.21m2.352 0c1.873.228 3.766.228 5.64 0M10.34 6.66a51.258 51.258 0 0 1 5.64 0m0 0c.688.06 1.386.09 2.09.09h.75a4.5 4.5 0 0 1 0 9h-.75c-.704 0-1.402.03-2.09.09"/></svg>',
                ];
                $iconSvg = $catSvgs[$tpl->category] ?? '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>';
            @endphp
            <div x-show="!filterCategory || filterCategory === '{{ $tpl->category }}'"
                 @click="selectTemplate({{ $tpl->id }}, '{{ $tpl->category }}', '{{ $tplDesign }}')"
                 :class="selectedTemplateId == {{ $tpl->id }} ? 'ring-2 ring-brand shadow-lg scale-[1.02]' : 'hover:shadow-md hover:scale-[1.01]'"
                 class="group cursor-pointer rounded-2xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] overflow-hidden transition-all duration-200">

                {{-- Mini aperçu A4 --}}
                <div class="relative aspect-[210/297] bg-white overflow-hidden">

                    @if($tplDesign === 'moderne')
                    {{-- MODERNE: sidebar gauche + barre bas --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1.5" style="background: {{ $designColors['moderne'] }}"></div>
                    <div class="absolute left-0 bottom-0 right-0 h-1" style="background: {{ $designColors['moderne'] }}"></div>
                    <div class="pt-4 pb-2 px-4 pl-5">
                        <div class="flex items-center gap-1.5">
                            <div class="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                                <svg class="w-2.5 h-2.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                            </div>
                            <div>
                                <div class="text-[4.5px] font-bold text-gray-700 tracking-wider uppercase">SST</div>
                                <div class="text-[3px] text-gray-400">Production</div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 pl-5 pt-1 space-y-1.5">
                        <div class="flex justify-end"><div class="h-1 w-10 rounded-full bg-gray-200"></div></div>
                        <div class="space-y-0.5 mt-1 p-1 rounded" style="background: {{ $designColors['moderne'] }}10; border-left: 2px solid {{ $designColors['moderne'] }}">
                            <div class="h-1 w-12 rounded-full" style="background: {{ $designColors['moderne'] }}60"></div>
                            <div class="h-0.5 w-10 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-8 rounded-full bg-gray-200"></div>
                        </div>
                        <div class="mt-1"><div class="h-1 w-14 rounded-full" style="background: {{ $designColors['moderne'] }}30"></div></div>
                        <div class="space-y-0.5 mt-1">
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-11/12 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-9/12 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-0"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-10/12 rounded-full bg-gray-200"></div>
                        </div>
                        <div class="mt-3 flex justify-end">
                            <div class="space-y-0.5">
                                <div class="h-0.5 w-8 rounded-full bg-gray-300"></div>
                                <div class="h-1 w-12 rounded-full" style="background: {{ $designColors['moderne'] }}50"></div>
                            </div>
                        </div>
                    </div>

                    @elseif($tplDesign === 'elegant')
                    {{-- ELEGANT: double lignes haut, lignes bas --}}
                    <div class="absolute top-0 left-0 right-0 h-1" style="background: {{ $designColors['elegant'] }}"></div>
                    <div class="absolute top-1.5 left-0 right-0 h-px" style="background: {{ $designColors['elegant'] }}80"></div>
                    <div class="absolute bottom-0 left-0 right-0 h-0.5" style="background: {{ $designColors['elegant'] }}"></div>
                    <div class="pt-5 pb-2 px-4 text-center">
                        <div class="w-5 h-5 mx-auto mb-0.5 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="text-[5px] font-bold text-gray-700 tracking-wider uppercase">SINIING SOHOMA TILO</div>
                        <div class="text-[3px] text-gray-400 italic">Production Audiovisuelle</div>
                        <div class="mx-auto mt-1 h-px w-6" style="background: {{ $designColors['elegant'] }}60"></div>
                    </div>
                    <div class="px-4 pt-1 space-y-1.5">
                        <div class="flex justify-end"><div class="h-1 w-10 rounded-full bg-gray-200"></div></div>
                        <div class="space-y-0.5 mt-1">
                            <div class="h-1 w-12 rounded-full" style="background: {{ $designColors['elegant'] }}50"></div>
                            <div class="h-0.5 w-10 rounded-full bg-gray-200"></div>
                        </div>
                        <div class="mt-1 p-1 rounded" style="background: {{ $designColors['elegant'] }}10; border: 0.5px solid {{ $designColors['elegant'] }}30">
                            <div class="h-1 w-14 rounded-full" style="background: {{ $designColors['elegant'] }}40"></div>
                        </div>
                        <div class="space-y-0.5 mt-1">
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-11/12 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-9/12 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-0"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-10/12 rounded-full bg-gray-200"></div>
                        </div>
                        <div class="mt-3 flex justify-center">
                            <div class="space-y-0.5 text-center">
                                <div class="mx-auto h-px w-8" style="background: {{ $designColors['elegant'] }}40"></div>
                                <div class="h-1 w-12 mx-auto rounded-full" style="background: {{ $designColors['elegant'] }}50"></div>
                                <div class="h-0.5 w-8 mx-auto rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                    </div>

                    @elseif($tplDesign === 'corporate')
                    {{-- CORPORATE: bannière sombre en haut + accent or --}}
                    <div class="absolute top-0 left-0 right-0 h-10 flex items-center justify-center" style="background: {{ $designColors['corporate'] }}">
                        <div class="text-center">
                            <div class="w-4 h-4 mx-auto rounded-full bg-white/20 flex items-center justify-center mb-0.5">
                                <svg class="w-2 h-2 text-white/60" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                            </div>
                            <div class="text-[4px] font-bold text-white/90 tracking-widest uppercase">SST</div>
                        </div>
                    </div>
                    <div class="absolute top-10 left-0 right-0 h-0.5" style="background: #C8A415"></div>
                    <div class="absolute bottom-0 left-0 right-0 h-0.5" style="background: {{ $designColors['corporate'] }}"></div>
                    <div class="px-4 pt-14 space-y-1.5">
                        <div class="flex justify-between">
                            <div class="space-y-0.5">
                                <div class="h-1 w-12 rounded-full" style="background: {{ $designColors['corporate'] }}50"></div>
                                <div class="h-0.5 w-10 rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-8 rounded-full bg-gray-200"></div>
                            </div>
                            <div class="space-y-0.5 text-right">
                                <div class="h-0.5 w-6 rounded-full bg-gray-300 ml-auto"></div>
                                <div class="h-0.5 w-10 rounded-full bg-gray-200 ml-auto"></div>
                            </div>
                        </div>
                        <div class="mt-1 p-1 rounded" style="border-left: 2px solid {{ $designColors['corporate'] }}; background: #f0f3f8">
                            <div class="h-1 w-14 rounded-full" style="background: {{ $designColors['corporate'] }}40"></div>
                        </div>
                        <div class="space-y-0.5 mt-1">
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-11/12 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-9/12 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-0"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                        </div>
                        <div class="mt-3 flex justify-end">
                            <div class="space-y-0.5">
                                <div class="h-1 w-12 rounded-full" style="background: {{ $designColors['corporate'] }}50"></div>
                                <div class="h-0.5 w-8 rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-10 rounded-full bg-gray-300"></div>
                            </div>
                        </div>
                    </div>

                    @else
                    {{-- CLASSIQUE: header centré + ligne or --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1.5" style="background: {{ $accent }}"></div>
                    <div class="pt-4 pb-2 px-4 text-center border-b" style="border-color: #C8A41540">
                        <div class="w-6 h-6 mx-auto mb-1 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="text-[5px] font-bold text-gray-700 tracking-wider uppercase">SINIING SOHOMA TILO</div>
                        <div class="text-[3.5px] text-gray-400">Production Audiovisuelle</div>
                    </div>
                    <div class="px-4 pt-3 space-y-1.5">
                        <div class="flex justify-end"><div class="h-1 w-10 rounded-full bg-gray-200"></div></div>
                        <div class="space-y-0.5 mt-2">
                            <div class="h-1 w-14 rounded-full" style="background: {{ $accent }}60"></div>
                            <div class="h-0.5 w-10 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-12 rounded-full bg-gray-200"></div>
                        </div>
                        <div class="mt-1.5"><div class="h-1 w-16 rounded-full" style="background: #C8A41540"></div></div>
                        <div class="space-y-0.5 mt-2">
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-11/12 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-9/12 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-0 rounded-full"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-10/12 rounded-full bg-gray-200"></div>
                        </div>
                        <div class="mt-3 flex justify-end">
                            <div class="space-y-0.5">
                                <div class="h-0.5 w-8 rounded-full bg-gray-300"></div>
                                <div class="h-1 w-12 rounded-full" style="background: {{ $accent }}50"></div>
                                <div class="h-0.5 w-10 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-3 border-t flex items-center justify-center" style="border-color: #C8A41540">
                        <div class="h-0.5 w-20 rounded-full bg-gray-200"></div>
                    </div>
                    @endif

                    {{-- Badge sélectionné --}}
                    <div x-show="selectedTemplateId == {{ $tpl->id }}" x-cloak
                         class="absolute top-2 right-2 w-5 h-5 rounded-full bg-brand flex items-center justify-center shadow-sm">
                        <svg class="w-3 h-3 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>

                {{-- Infos template --}}
                <div class="p-3">
                    <div class="flex items-start gap-2">
                        <span class="flex-shrink-0 text-gray-500 dark:text-gray-400" style="color: {{ $accent }}">{!! $iconSvg !!}</span>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-gray-900 dark:text-white leading-tight truncate">{{ $tpl->name }}</p>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <p class="text-[10px] text-gray-400 dark:text-gray-500">{{ $catLabels[$tpl->category] ?? ucfirst(str_replace('_', ' ', $tpl->category)) }}</p>
                                <span class="text-[9px] px-1.5 py-0.5 rounded-full font-medium" style="background: {{ $designColors[$tplDesign] ?? '#C8A415' }}15; color: {{ $designColors[$tplDesign] ?? '#C8A415' }}">{{ $designLabels[$tplDesign] ?? 'Classique' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Bouton continuer --}}
        <div class="flex justify-end mt-6" x-show="selectedTemplateId" x-cloak>
            <button type="button" @click="goToStep2()"
                    class="px-6 py-2.5 rounded-xl bg-brand text-[#0C0C0C] text-sm font-semibold hover:bg-brand-hover transition flex items-center gap-2">
                Continuer
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    {{-- ÉTAPE 2 : Formulaire de remplissage --}}
    <div x-show="step === 2" x-cloak>
        <form method="POST" action="{{ route('documents.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="template_id" :value="selectedTemplateId">
            <input type="hidden" name="design" :value="selectedDesign">

            {{-- Rappel template sélectionné + bouton retour --}}
            <div class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616]">
                <button type="button" @click="step = 1"
                        class="flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 dark:border-white/[0.08] text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/[0.04] transition flex-shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate" x-text="selectedTemplateName || 'Rédaction libre'"></p>
                    <p class="text-xs text-gray-400" x-show="templateCategory" x-text="templateCategory"></p>
                </div>
                <button type="button" @click="step = 1" class="ml-auto text-xs text-brand hover:underline flex-shrink-0">Changer</button>
            </div>

            {{-- Sélecteur de design PDF --}}
            <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 space-y-4">
                <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42"/></svg>
                    Design du PDF
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Choisissez l'apparence visuelle de votre lettre.</p>

                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                    {{-- Simple --}}
                    <button type="button" @click="selectedDesign = 'simple'"
                            :class="selectedDesign === 'simple' ? 'ring-2 ring-brand border-brand' : 'border-gray-200 dark:border-white/[0.08] hover:border-gray-300'"
                            class="relative rounded-xl border bg-white dark:bg-[#0C0C0C] overflow-hidden transition-all p-0">
                        <div class="aspect-[210/160] relative overflow-hidden">
                            <div class="pt-4 px-3 text-center">
                                <div class="w-4 h-4 mx-auto rounded-full bg-gray-200"></div>
                                <div class="text-[4px] font-bold text-gray-500 mt-1">SST</div>
                            </div>
                            <div class="px-3 pt-3 space-y-0.5">
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-3/4 rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200 mt-1"></div>
                                <div class="h-0.5 w-2/3 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-center border-t border-gray-100 dark:border-white/[0.06]">
                            <span class="text-[10px] font-semibold" :class="selectedDesign === 'simple' ? 'text-brand' : 'text-gray-600 dark:text-gray-400'">Simple</span>
                        </div>
                        <div x-show="selectedDesign === 'simple'" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-brand flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>

                    {{-- Classique --}}
                    <button type="button" @click="selectedDesign = 'classique'"
                            :class="selectedDesign === 'classique' ? 'ring-2 ring-brand border-brand' : 'border-gray-200 dark:border-white/[0.08] hover:border-gray-300'"
                            class="relative rounded-xl border bg-white dark:bg-[#0C0C0C] overflow-hidden transition-all p-0">
                        <div class="aspect-[210/160] relative overflow-hidden">
                            <div class="pt-2 pb-1 px-3 text-center border-b" style="border-color: #C8A41540">
                                <div class="w-3 h-3 mx-auto rounded-full bg-gray-200"></div>
                                <div class="text-[4px] font-bold text-gray-600 mt-0.5">SST</div>
                            </div>
                            <div class="px-3 pt-1.5 space-y-0.5">
                                <div class="h-0.5 w-8 rounded-full bg-gray-200 ml-auto"></div>
                                <div class="h-0.5 w-6 rounded-full" style="background: #C8A41560"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200 mt-1"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-3/4 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-center border-t border-gray-100 dark:border-white/[0.06]">
                            <span class="text-[10px] font-semibold" :class="selectedDesign === 'classique' ? 'text-brand' : 'text-gray-600 dark:text-gray-400'">Classique</span>
                        </div>
                        <div x-show="selectedDesign === 'classique'" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-brand flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>

                    {{-- Moderne --}}
                    <button type="button" @click="selectedDesign = 'moderne'"
                            :class="selectedDesign === 'moderne' ? 'ring-2 ring-brand border-brand' : 'border-gray-200 dark:border-white/[0.08] hover:border-gray-300'"
                            class="relative rounded-xl border bg-white dark:bg-[#0C0C0C] overflow-hidden transition-all p-0">
                        <div class="aspect-[210/160] relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1" style="background: #3f3861"></div>
                            <div class="absolute left-0 bottom-0 right-0 h-0.5" style="background: #3f3861"></div>
                            <div class="pt-2 pl-3 pr-2 flex items-center gap-1">
                                <div class="w-3 h-3 rounded-full bg-gray-200 flex-shrink-0"></div>
                                <div class="text-[4px] font-bold text-gray-600">SST</div>
                            </div>
                            <div class="px-3 pl-3.5 pt-1.5 space-y-0.5">
                                <div class="p-0.5 rounded" style="background: #3f386110; border-left: 1px solid #3f3861">
                                    <div class="h-0.5 w-6 rounded-full" style="background: #3f386160"></div>
                                </div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200 mt-1"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-3/4 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-center border-t border-gray-100 dark:border-white/[0.06]">
                            <span class="text-[10px] font-semibold" :class="selectedDesign === 'moderne' ? 'text-brand' : 'text-gray-600 dark:text-gray-400'">Moderne</span>
                        </div>
                        <div x-show="selectedDesign === 'moderne'" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-brand flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>

                    {{-- Élégant --}}
                    <button type="button" @click="selectedDesign = 'elegant'"
                            :class="selectedDesign === 'elegant' ? 'ring-2 ring-brand border-brand' : 'border-gray-200 dark:border-white/[0.08] hover:border-gray-300'"
                            class="relative rounded-xl border bg-white dark:bg-[#0C0C0C] overflow-hidden transition-all p-0">
                        <div class="aspect-[210/160] relative overflow-hidden">
                            <div class="absolute top-0 left-0 right-0 h-0.5" style="background: #b08657"></div>
                            <div class="absolute top-1 left-0 right-0 h-px" style="background: #b0865780"></div>
                            <div class="absolute bottom-0 left-0 right-0 h-px" style="background: #b08657"></div>
                            <div class="pt-3 px-3 text-center">
                                <div class="w-3 h-3 mx-auto rounded-full bg-gray-200"></div>
                                <div class="text-[4px] font-bold text-gray-600 mt-0.5">SST</div>
                                <div class="text-[3px] text-gray-400 italic">Production</div>
                            </div>
                            <div class="px-3 pt-1 space-y-0.5">
                                <div class="p-0.5 rounded" style="background: #b0865710; border: 0.5px solid #b0865730">
                                    <div class="h-0.5 w-8 rounded-full" style="background: #b0865740"></div>
                                </div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200 mt-0.5"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-3/4 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-center border-t border-gray-100 dark:border-white/[0.06]">
                            <span class="text-[10px] font-semibold" :class="selectedDesign === 'elegant' ? 'text-brand' : 'text-gray-600 dark:text-gray-400'">Élégant</span>
                        </div>
                        <div x-show="selectedDesign === 'elegant'" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-brand flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>

                    {{-- Corporate --}}
                    <button type="button" @click="selectedDesign = 'corporate'"
                            :class="selectedDesign === 'corporate' ? 'ring-2 ring-brand border-brand' : 'border-gray-200 dark:border-white/[0.08] hover:border-gray-300'"
                            class="relative rounded-xl border bg-white dark:bg-[#0C0C0C] overflow-hidden transition-all p-0">
                        <div class="aspect-[210/160] relative overflow-hidden">
                            <div class="h-6 flex items-center justify-center" style="background: #1a2744">
                                <div class="w-2.5 h-2.5 rounded-full bg-white/20"></div>
                            </div>
                            <div class="h-px" style="background: #C8A415"></div>
                            <div class="px-3 pt-1.5 space-y-0.5">
                                <div class="flex justify-between">
                                    <div class="h-0.5 w-5 rounded-full" style="background: #1a274450"></div>
                                    <div class="h-0.5 w-4 rounded-full bg-gray-200"></div>
                                </div>
                                <div class="p-0.5 rounded" style="border-left: 1px solid #1a2744; background: #f0f3f8">
                                    <div class="h-0.5 w-8 rounded-full" style="background: #1a274440"></div>
                                </div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200 mt-0.5"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-3/4 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-center border-t border-gray-100 dark:border-white/[0.06]">
                            <span class="text-[10px] font-semibold" :class="selectedDesign === 'corporate' ? 'text-brand' : 'text-gray-600 dark:text-gray-400'">Corporate</span>
                        </div>
                        <div x-show="selectedDesign === 'corporate'" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-brand flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>
                </div>
            </div>

            {{-- Variables dynamiques du template --}}
            <div x-show="templateVariables.length > 0" x-cloak
                 class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 space-y-4">
                <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16"/></svg>
                    Contenu de la lettre
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Remplissez les champs ci-dessous. Ils seront automatiquement insérés dans la lettre.</p>

                <template x-for="(variable, idx) in templateVariables" :key="variable.key">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <span x-text="variable.label"></span>
                            <span x-show="variable.required" class="text-red-500 ml-0.5">*</span>
                        </label>
                        <template x-if="variable.type === 'textarea'">
                            <textarea :name="'variables[' + variable.key + ']'"
                                      x-model="variableValues[variable.key]"
                                      :required="variable.required"
                                      rows="3"
                                      class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                                      :placeholder="variable.placeholder || ''"></textarea>
                        </template>
                        <template x-if="variable.type !== 'textarea'">
                            <input type="text"
                                   :name="'variables[' + variable.key + ']'"
                                   x-model="variableValues[variable.key]"
                                   :required="variable.required"
                                   class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                                   :placeholder="variable.placeholder || ''">
                        </template>
                    </div>
                </template>
            </div>

            {{-- Informations destinataire --}}
            <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 space-y-4">
                <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Destinataire
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Civilité <span class="text-red-500">*</span></label>
                        <select name="civilite" required
                                class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm">
                            <option value="">-- Choisir --</option>
                            <option value="Madame" {{ old('civilite') === 'Madame' ? 'selected' : '' }}>Madame</option>
                            <option value="Monsieur" {{ old('civilite') === 'Monsieur' ? 'selected' : '' }}>Monsieur</option>
                        </select>
                        @error('civilite') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nom du destinataire <span class="text-red-500">*</span></label>
                        <input type="text" name="client_name" value="{{ old('client_name') }}" required
                               class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                               placeholder="Nom complet">
                        @error('client_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre et service <span class="text-gray-400 text-xs font-normal">(optionnel)</span></label>
                    <input type="text" name="titre_destinataire" value="{{ old('titre_destinataire') }}"
                           class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                           placeholder="Ex: Directeur du Service Culturel">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse <span class="text-gray-400 text-xs font-normal">(optionnel)</span></label>
                        <input type="text" name="client_address" value="{{ old('client_address') }}"
                               class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                               placeholder="Adresse du destinataire">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Coordonnées <span class="text-gray-400 text-xs font-normal">(optionnel)</span></label>
                        <input type="text" name="telephone_destinataire" value="{{ old('telephone_destinataire') }}"
                               class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                               placeholder="Téléphone ou email">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Objet <span class="text-red-500">*</span></label>
                    <input type="text" name="objet" value="{{ old('objet') }}" required
                           class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                           placeholder="Objet de la lettre">
                    @error('objet') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Contenu libre (si pas de template avec variables) --}}
            <div x-show="!hasTemplateVariables"
                 class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 space-y-4">
                <h3 class="font-semibold text-gray-900 dark:text-white">Contenu de la lettre</h3>
                <textarea name="content" rows="10" :required="!hasTemplateVariables"
                          class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                          placeholder="Madame, Monsieur,&#10;&#10;Nous avons l'honneur de...">{{ old('content') }}</textarea>
                @error('content') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" @click="step = 1" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-white/[0.1] text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">Retour</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand text-[#0C0C0C] text-sm font-semibold hover:bg-brand-hover transition">
                    Créer la lettre
                </button>
            </div>
        </form>
    </div>

    @else
    {{-- ═══════════════════════════════════════════════════════════════
         NON-LETTER TYPES — Mêmes fonctionnalités que lettre
         Step 1: Galerie templates | Step 2: Design + Formulaire
         ═══════════════════════════════════════════════════════════════ --}}

    {{-- ÉTAPE 1 : Galerie visuelle des templates --}}
    <div x-show="step === 1">
        @if($templates->isNotEmpty())
        @php
            $typeSvgs = [
                'invoice_proforma' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185Z"/></svg>',
                'invoice_final' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></svg>',
                'contrat' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>',
                'note_officielle' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5"/></svg>',
                'page_garde' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-2.625 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0 1 18 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0 1 18 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 0 1 6 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 12 6 12.504 6 13.125"/></svg>',
            ];
            $typeIcon = $typeSvgs[$type] ?? $typeSvgs['contrat'];
            $previewColors = [
                'simple' => '#999999',
                'classique' => '#C8A415',
                'moderne' => '#3f3861',
                'elegant' => '#b08657',
                'corporate' => '#1a2744',
            ];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            @foreach($templates as $tpl)
            @php $tplColor = $previewColors[$tpl->design ?? 'classique'] ?? '#C8A415'; @endphp
            <div @click="selectTemplate({{ $tpl->id }}, '', '{{ $tpl->design ?? 'classique' }}')"
                 :class="selectedTemplateId == {{ $tpl->id }} ? 'ring-2 ring-brand shadow-lg scale-[1.02]' : 'hover:shadow-md hover:scale-[1.01]'"
                 class="group cursor-pointer rounded-2xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] overflow-hidden transition-all duration-200">

                {{-- Mini aperçu A4 --}}
                <div class="relative aspect-[210/297] bg-white overflow-hidden">
                    {{-- Header SST --}}
                    <div class="absolute top-0 left-0 right-0 h-8 border-b-2" style="border-color: {{ $tplColor }}">
                        <div class="flex items-center justify-center h-full gap-1">
                            <div class="w-4 h-4 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                                <svg class="w-2 h-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                            </div>
                            <div class="text-[4px] font-bold text-gray-600 tracking-wider">SST</div>
                        </div>
                    </div>

                    @if(in_array($type, ['invoice_proforma', 'invoice_final']))
                    {{-- Invoice preview: title + table --}}
                    <div class="px-3 pt-10 space-y-1.5">
                        <div class="h-1.5 w-14 rounded-full mx-auto" style="background: {{ $tplColor }}60"></div>
                        <div class="h-0.5 w-10 rounded-full bg-gray-200 ml-auto"></div>
                        <div class="mt-1.5 rounded overflow-hidden">
                            <div class="h-2 w-full" style="background: {{ $tplColor }}"></div>
                            <div class="h-1 w-full bg-gray-100 border-b border-gray-200"></div>
                            <div class="h-1 w-full bg-gray-50 border-b border-gray-200"></div>
                            <div class="h-1 w-full bg-gray-100 border-b border-gray-200"></div>
                            <div class="h-1 w-full bg-gray-50"></div>
                        </div>
                        <div class="flex justify-end mt-1">
                            <div class="h-2 w-12 rounded" style="background: {{ $tplColor }}20; border: 0.5px solid {{ $tplColor }}40"></div>
                        </div>
                    </div>
                    @elseif($type === 'contrat')
                    {{-- Contract preview: title + articles --}}
                    <div class="px-3 pt-10 space-y-1">
                        <div class="h-1.5 w-16 rounded-full mx-auto" style="background: {{ $tplColor }}60"></div>
                        <div class="mt-2 space-y-1.5">
                            <div class="h-1 w-10 rounded-full" style="background: {{ $tplColor }}40"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-11/12 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-0 mt-0.5"></div>
                            <div class="h-1 w-8 rounded-full" style="background: {{ $tplColor }}40"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-10/12 rounded-full bg-gray-200"></div>
                        </div>
                    </div>
                    @elseif($type === 'note_officielle')
                    {{-- Note preview: ref + text --}}
                    <div class="px-3 pt-10 space-y-1">
                        <div class="h-1.5 w-14 rounded-full mx-auto" style="background: {{ $tplColor }}60"></div>
                        <div class="h-0.5 w-10 rounded-full bg-gray-200"></div>
                        <div class="h-1 w-12 rounded-full" style="background: {{ $tplColor }}30"></div>
                        <div class="mt-1 space-y-0.5">
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-11/12 rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                            <div class="h-0.5 w-9/12 rounded-full bg-gray-200"></div>
                        </div>
                    </div>
                    @elseif($type === 'page_garde')
                    {{-- Page de garde preview: centered title --}}
                    <div class="flex flex-col items-center justify-center h-full px-4">
                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mb-2">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="w-12 h-px mx-auto" style="background: {{ $tplColor }}"></div>
                        <div class="h-2 w-16 rounded-full mt-2" style="background: {{ $tplColor }}30"></div>
                        <div class="w-12 h-px mx-auto mt-2" style="background: {{ $tplColor }}"></div>
                        <div class="h-1 w-10 rounded-full mt-2 bg-gray-200"></div>
                    </div>
                    @endif

                    {{-- Footer SST --}}
                    <div class="absolute bottom-0 left-0 right-0 h-3 border-t" style="border-color: {{ $tplColor }}80">
                        <div class="flex justify-center items-center h-full">
                            <div class="h-0.5 w-8 rounded-full bg-gray-200"></div>
                        </div>
                    </div>

                    {{-- Badge sélectionné --}}
                    <div x-show="selectedTemplateId == {{ $tpl->id }}"
                         class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full bg-brand flex items-center justify-center shadow-sm">
                        <svg class="w-3 h-3 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>

                {{-- Nom du template --}}
                <div class="px-3 py-2.5 border-t border-gray-100 dark:border-white/[0.06]">
                    <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate">{{ $tpl->name }}</p>
                </div>
            </div>
            @endforeach

            {{-- Option rédaction libre --}}
            <div @click="selectTemplate('', '', 'classique')"
                 :class="selectedTemplateId === '' ? 'ring-2 ring-brand shadow-lg scale-[1.02]' : 'hover:shadow-md hover:scale-[1.01]'"
                 class="group cursor-pointer rounded-2xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] overflow-hidden transition-all duration-200">
                <div class="relative aspect-[210/297] bg-gray-50 dark:bg-[#0C0C0C] flex flex-col items-center justify-center">
                    <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-white/[0.08] flex items-center justify-center mb-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                    </div>
                    <div class="text-[10px] font-semibold text-gray-500 dark:text-gray-400">Rédaction libre</div>
                    <div class="text-[8px] text-gray-400 mt-0.5">Sans modèle</div>
                    <div x-show="selectedTemplateId === ''"
                         class="absolute top-1.5 right-1.5 w-5 h-5 rounded-full bg-brand flex items-center justify-center shadow-sm">
                        <svg class="w-3 h-3 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <div class="px-3 py-2.5 border-t border-gray-100 dark:border-white/[0.06]">
                    <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate">Rédaction libre</p>
                </div>
            </div>
        </div>

        {{-- Bouton continuer --}}
        <div class="flex justify-end mt-6">
            <button type="button" @click="goToStep2()"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-brand text-[#0C0C0C] text-sm font-semibold hover:bg-brand-hover transition">
                Continuer
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </button>
        </div>
        @else
        {{-- Pas de templates — passer directement à l'étape 2 --}}
        <script>document.addEventListener('alpine:init', () => { setTimeout(() => { document.querySelector('[x-data]').__x.$data.step = 2; }, 50); });</script>
        @endif
    </div>

    {{-- ÉTAPE 2 : Formulaire avec sélecteur design --}}
    <div x-show="step === 2" x-cloak>
        <form method="POST" action="{{ route('documents.store') }}" class="space-y-6" @if(in_array($type, ['invoice_proforma', 'invoice_final'])) x-data="invoiceForm()" @endif>
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="template_id" :value="selectedTemplateId">
            <input type="hidden" name="design" :value="selectedDesign">

            @if($templates->isNotEmpty())
            {{-- Rappel template sélectionné + bouton retour --}}
            <div class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616]">
                <button type="button" @click="step = 1"
                        class="flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 dark:border-white/[0.08] text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/[0.04] transition flex-shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate" x-text="selectedTemplateName || 'Rédaction libre'"></p>
                </div>
                <button type="button" @click="step = 1" class="ml-auto text-xs text-brand hover:underline flex-shrink-0">Changer</button>
            </div>
            @endif

            {{-- Sélecteur de design PDF --}}
            <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 space-y-4">
                <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42"/></svg>
                    Design du PDF
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Choisissez l'apparence visuelle de votre document.</p>

                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                    {{-- Simple --}}
                    <button type="button" @click="selectedDesign = 'simple'"
                            :class="selectedDesign === 'simple' ? 'ring-2 ring-brand border-brand' : 'border-gray-200 dark:border-white/[0.08] hover:border-gray-300'"
                            class="relative rounded-xl border bg-white dark:bg-[#0C0C0C] overflow-hidden transition-all p-0">
                        <div class="aspect-[210/160] relative overflow-hidden">
                            <div class="pt-4 px-3 text-center">
                                <div class="w-4 h-4 mx-auto rounded-full bg-gray-200"></div>
                                <div class="text-[4px] font-bold text-gray-500 mt-1">SST</div>
                            </div>
                            <div class="px-3 pt-3 space-y-0.5">
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-3/4 rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200 mt-1"></div>
                                <div class="h-0.5 w-2/3 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-center border-t border-gray-100 dark:border-white/[0.06]">
                            <span class="text-[10px] font-semibold" :class="selectedDesign === 'simple' ? 'text-brand' : 'text-gray-600 dark:text-gray-400'">Simple</span>
                        </div>
                        <div x-show="selectedDesign === 'simple'" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-brand flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>

                    {{-- Classique --}}
                    <button type="button" @click="selectedDesign = 'classique'"
                            :class="selectedDesign === 'classique' ? 'ring-2 ring-brand border-brand' : 'border-gray-200 dark:border-white/[0.08] hover:border-gray-300'"
                            class="relative rounded-xl border bg-white dark:bg-[#0C0C0C] overflow-hidden transition-all p-0">
                        <div class="aspect-[210/160] relative overflow-hidden">
                            <div class="pt-2 pb-1 px-3 text-center border-b" style="border-color: #C8A41540">
                                <div class="w-3 h-3 mx-auto rounded-full bg-gray-200"></div>
                                <div class="text-[4px] font-bold text-gray-600 mt-0.5">SST</div>
                            </div>
                            <div class="px-3 pt-1.5 space-y-0.5">
                                <div class="h-0.5 w-8 rounded-full bg-gray-200 ml-auto"></div>
                                <div class="h-0.5 w-6 rounded-full" style="background: #C8A41560"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200 mt-1"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-3/4 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-center border-t border-gray-100 dark:border-white/[0.06]">
                            <span class="text-[10px] font-semibold" :class="selectedDesign === 'classique' ? 'text-brand' : 'text-gray-600 dark:text-gray-400'">Classique</span>
                        </div>
                        <div x-show="selectedDesign === 'classique'" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-brand flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>

                    {{-- Moderne --}}
                    <button type="button" @click="selectedDesign = 'moderne'"
                            :class="selectedDesign === 'moderne' ? 'ring-2 ring-brand border-brand' : 'border-gray-200 dark:border-white/[0.08] hover:border-gray-300'"
                            class="relative rounded-xl border bg-white dark:bg-[#0C0C0C] overflow-hidden transition-all p-0">
                        <div class="aspect-[210/160] relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1" style="background: #3f3861"></div>
                            <div class="absolute left-0 bottom-0 right-0 h-0.5" style="background: #3f3861"></div>
                            <div class="pt-2 pl-3 pr-2 flex items-center gap-1">
                                <div class="w-3 h-3 rounded-full bg-gray-200 flex-shrink-0"></div>
                                <div class="text-[4px] font-bold text-gray-600">SST</div>
                            </div>
                            <div class="px-3 pl-3.5 pt-1.5 space-y-0.5">
                                <div class="p-0.5 rounded" style="background: #3f386110; border-left: 1px solid #3f3861">
                                    <div class="h-0.5 w-6 rounded-full" style="background: #3f386160"></div>
                                </div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200 mt-1"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-3/4 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-center border-t border-gray-100 dark:border-white/[0.06]">
                            <span class="text-[10px] font-semibold" :class="selectedDesign === 'moderne' ? 'text-brand' : 'text-gray-600 dark:text-gray-400'">Moderne</span>
                        </div>
                        <div x-show="selectedDesign === 'moderne'" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-brand flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>

                    {{-- Élégant --}}
                    <button type="button" @click="selectedDesign = 'elegant'"
                            :class="selectedDesign === 'elegant' ? 'ring-2 ring-brand border-brand' : 'border-gray-200 dark:border-white/[0.08] hover:border-gray-300'"
                            class="relative rounded-xl border bg-white dark:bg-[#0C0C0C] overflow-hidden transition-all p-0">
                        <div class="aspect-[210/160] relative overflow-hidden">
                            <div class="absolute top-0 left-0 right-0 h-0.5" style="background: #b08657"></div>
                            <div class="absolute top-1 left-0 right-0 h-px" style="background: #b0865780"></div>
                            <div class="absolute bottom-0 left-0 right-0 h-px" style="background: #b08657"></div>
                            <div class="pt-3 px-3 text-center">
                                <div class="w-3 h-3 mx-auto rounded-full bg-gray-200"></div>
                                <div class="text-[4px] font-bold text-gray-600 mt-0.5">SST</div>
                                <div class="text-[3px] text-gray-400 italic">Production</div>
                            </div>
                            <div class="px-3 pt-1 space-y-0.5">
                                <div class="p-0.5 rounded" style="background: #b0865710; border: 0.5px solid #b0865730">
                                    <div class="h-0.5 w-8 rounded-full" style="background: #b0865740"></div>
                                </div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200 mt-0.5"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-3/4 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-center border-t border-gray-100 dark:border-white/[0.06]">
                            <span class="text-[10px] font-semibold" :class="selectedDesign === 'elegant' ? 'text-brand' : 'text-gray-600 dark:text-gray-400'">Élégant</span>
                        </div>
                        <div x-show="selectedDesign === 'elegant'" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-brand flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>

                    {{-- Corporate --}}
                    <button type="button" @click="selectedDesign = 'corporate'"
                            :class="selectedDesign === 'corporate' ? 'ring-2 ring-brand border-brand' : 'border-gray-200 dark:border-white/[0.08] hover:border-gray-300'"
                            class="relative rounded-xl border bg-white dark:bg-[#0C0C0C] overflow-hidden transition-all p-0">
                        <div class="aspect-[210/160] relative overflow-hidden">
                            <div class="h-6 flex items-center justify-center" style="background: #1a2744">
                                <div class="w-2.5 h-2.5 rounded-full bg-white/20"></div>
                            </div>
                            <div class="h-px" style="background: #C8A415"></div>
                            <div class="px-3 pt-1.5 space-y-0.5">
                                <div class="flex justify-between">
                                    <div class="h-0.5 w-5 rounded-full" style="background: #1a274450"></div>
                                    <div class="h-0.5 w-4 rounded-full bg-gray-200"></div>
                                </div>
                                <div class="p-0.5 rounded" style="border-left: 1px solid #1a2744; background: #f0f3f8">
                                    <div class="h-0.5 w-8 rounded-full" style="background: #1a274440"></div>
                                </div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200 mt-0.5"></div>
                                <div class="h-0.5 w-full rounded-full bg-gray-200"></div>
                                <div class="h-0.5 w-3/4 rounded-full bg-gray-200"></div>
                            </div>
                        </div>
                        <div class="px-2 py-1.5 text-center border-t border-gray-100 dark:border-white/[0.06]">
                            <span class="text-[10px] font-semibold" :class="selectedDesign === 'corporate' ? 'text-brand' : 'text-gray-600 dark:text-gray-400'">Corporate</span>
                        </div>
                        <div x-show="selectedDesign === 'corporate'" class="absolute top-1 right-1 w-4 h-4 rounded-full bg-brand flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 text-[#0C0C0C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </button>
                </div>
            </div>

            {{-- ═══ Informations client / document ═══ --}}
            @if(!in_array($type, ['page_garde']))
            <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 space-y-4">
                <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Informations
                </h3>

                @if(in_array($type, ['invoice_proforma', 'invoice_final', 'contrat']))
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ $type === 'contrat' ? 'Nom de la partie contractante' : 'Nom du client' }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}" required
                           class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                           placeholder="Nom du client">
                    @error('client_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                @endif

                @if(in_array($type, ['invoice_proforma', 'invoice_final']))
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Adresse du client <span class="text-red-500">*</span></label>
                    <textarea name="client_address" rows="2" required
                              class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                              placeholder="Adresse complète">{{ old('client_address') }}</textarea>
                    @error('client_address') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                @endif

                @if($type === 'note_officielle')
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Référence <span class="text-gray-400 text-xs font-normal">(optionnel)</span></label>
                    <input type="text" name="reference" value="{{ old('reference') }}"
                           class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                           placeholder="N° de référence">
                    @error('reference') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                @endif

                @if(in_array($type, ['contrat', 'note_officielle']))
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Objet <span class="text-red-500">*</span></label>
                    <input type="text" name="objet" value="{{ old('objet') }}" required
                           class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                           placeholder="{{ $type === 'contrat' ? 'Objet du contrat' : 'Objet de la note' }}">
                    @error('objet') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                @endif

                @if($type === 'contrat')
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Durée <span class="text-gray-400 text-xs font-normal">(optionnel)</span></label>
                    <input type="text" name="duree" value="{{ old('duree') }}"
                           class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                           placeholder="Ex: 6 mois, 1 an...">
                    @error('duree') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
                @endif
            </div>
            @endif

            {{-- ═══ Contenu libre ═══ --}}
            @if(in_array($type, ['contrat', 'note_officielle', 'page_garde']))
            <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6 space-y-4">
                <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16"/></svg>
                    @if($type === 'contrat') Conditions du contrat
                    @elseif($type === 'note_officielle') Contenu de la note
                    @elseif($type === 'page_garde') Titre du film / Contenu
                    @endif
                </h3>
                <textarea name="content" rows="{{ $type === 'page_garde' ? 4 : 10 }}" required
                          class="w-full rounded-xl border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                          placeholder="@if($type === 'contrat')Conditions financières, clauses...@elseif($type === 'note_officielle')Contenu de la note officielle...@elseif($type === 'page_garde')« …ET SI DEMAIN… »@endif">{{ old('content') }}</textarea>
                @error('content') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            @endif

            @if(in_array($type, ['invoice_proforma', 'invoice_final']))
            {{-- ═══ Lignes facture ═══ --}}
            <div class="rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z"/></svg>
                        Produits / Services
                    </h3>
                    <button type="button" @click="addItem()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand text-[#0C0C0C] text-xs font-semibold hover:bg-brand-hover transition">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Ajouter ligne
                    </button>
                </div>

                @error('items') <p class="mb-3 text-sm text-red-500">{{ $message }}</p> @enderror

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="pb-2 pr-3">Désignation</th>
                                <th class="pb-2 pr-3 w-24">Quantité</th>
                                <th class="pb-2 pr-3 w-32">Prix unitaire</th>
                                <th class="pb-2 pr-3 w-32">Total</th>
                                <th class="pb-2 w-10"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr class="border-t border-gray-100 dark:border-white/[0.06]">
                                    <td class="py-2 pr-3">
                                        <input type="text" :name="'items['+index+'][designation]'" x-model="item.designation" required
                                               class="w-full rounded-lg border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm"
                                               placeholder="Description">
                                    </td>
                                    <td class="py-2 pr-3">
                                        <input type="number" :name="'items['+index+'][quantity]'" x-model.number="item.quantity" min="1" required
                                               class="w-full rounded-lg border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm text-center">
                                    </td>
                                    <td class="py-2 pr-3">
                                        <input type="number" :name="'items['+index+'][price]'" x-model.number="item.price" min="0" required
                                               class="w-full rounded-lg border-gray-300 dark:border-white/[0.1] dark:bg-[#0C0C0C] dark:text-white focus:border-brand focus:ring-brand text-sm text-right"
                                               placeholder="0">
                                    </td>
                                    <td class="py-2 pr-3 text-sm font-medium dark:text-white text-right" x-text="formatPrice(item.quantity * item.price)"></td>
                                    <td class="py-2">
                                        <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                                class="flex items-center justify-center w-8 h-8 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-gray-200 dark:border-white/[0.1]">
                                <td colspan="3" class="py-3 text-right font-semibold dark:text-white text-sm">TOTAL :</td>
                                <td class="py-3 text-right font-bold text-brand text-lg" x-text="formatPrice(grandTotal())"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif

            <div class="flex justify-end gap-3">
                @if($templates->isNotEmpty())
                <button type="button" @click="step = 1" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-white/[0.1] text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">Retour</button>
                @else
                <a href="{{ route('documents.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-white/[0.1] text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/[0.04] transition">Annuler</a>
                @endif
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand text-[#0C0C0C] text-sm font-semibold hover:bg-brand-hover transition">
                    Créer le document
                </button>
            </div>
        </form>
    </div>
    @endif
</div>

@push('scripts')
<script>
function documentForm() {
    return {
        // Step flow (letter only)
        step: 1,
        filterCategory: '',

        // Template data
        selectedTemplateId: '',
        selectedTemplateName: '',
        selectedDesign: 'classique',
        templateVariables: [],
        templateCategory: '',
        variableValues: {},
        hasTemplateVariables: false,

        // Templates JSON for lookup
        templates: @json($templates ?? []),

        selectTemplate(id, category, design) {
            this.selectedTemplateId = id;
            const tpl = this.templates.find(t => t.id == id);
            this.selectedTemplateName = tpl ? tpl.name : '';
            this.templateCategory = category;
            this.selectedDesign = design || 'classique';
        },

        async goToStep2() {
            if (this.selectedTemplateId) {
                try {
                    const response = await fetch(`/templates/${this.selectedTemplateId}/variables`);
                    const data = await response.json();
                    this.templateVariables = data.variables || [];
                    this.templateCategory = data.category || '';
                    this.selectedDesign = data.design || 'classique';
                    this.hasTemplateVariables = this.templateVariables.length > 0;
                    this.variableValues = {};
                    this.templateVariables.forEach(v => {
                        this.variableValues[v.key] = '';
                    });
                } catch (e) {
                    console.error('Erreur chargement variables:', e);
                    this.templateVariables = [];
                    this.hasTemplateVariables = false;
                }
            }
            this.step = 2;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}

function invoiceForm() {
    return {
        items: [{ designation: '', quantity: 1, price: 0 }],
        addItem() { this.items.push({ designation: '', quantity: 1, price: 0 }); },
        removeItem(index) { this.items.splice(index, 1); },
        grandTotal() { return this.items.reduce((sum, item) => sum + (item.quantity * item.price), 0); },
        formatPrice(val) { return new Intl.NumberFormat('fr-FR').format(val) + ' FCFA'; }
    }
}
</script>
@endpush
@endsection
