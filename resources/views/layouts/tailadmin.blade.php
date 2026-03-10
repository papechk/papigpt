<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | {{ config('app.name', 'PapiGPT') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        :root {
            --brand: #BEFF00;
            --brand-hover: #a8e000;
            --dark: #0C0C0C;
            --dark-card: #161616;
            --dark-border: #222222;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }
        .bg-brand { background-color: var(--brand) !important; }
        .text-brand { color: var(--brand) !important; }
        .border-brand { border-color: var(--brand) !important; }
        .bg-brand-subtle { background-color: rgba(190, 255, 0, 0.08) !important; }
        .hover\:bg-brand-hover:hover { background-color: var(--brand-hover) !important; }
        .ring-brand { --tw-ring-color: var(--brand) !important; }
        [x-cloak] { display: none !important; }

        /* Sidebar — Light */
        #sidebar {
            background-color: #ffffff;
            border-color: #e5e7eb;
        }
        /* Sidebar — Dark */
        .dark #sidebar {
            background-color: var(--dark);
            border-color: var(--dark-border);
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.875rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .menu-item-active {
            background-color: var(--brand);
            color: var(--dark) !important;
            font-weight: 600;
        }
        /* Inactive items — Light */
        .menu-item-inactive {
            color: #4B5563;
        }
        .menu-item-inactive:hover {
            background-color: #f3f4f6;
            color: #111827;
        }
        /* Inactive items — Dark */
        .dark .menu-item-inactive {
            color: #9CA3AF;
        }
        .dark .menu-item-inactive:hover {
            background-color: rgba(255, 255, 255, 0.06);
            color: #fff;
        }

        /* Sidebar logo text */
        .sidebar-logo-text { color: #111827; }
        .dark .sidebar-logo-text { color: #ffffff; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
        .dark ::-webkit-scrollbar-thumb { background: #333; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>

    <script>
        (function() {
            const saved = localStorage.getItem('theme');
            // Par défaut: mode clair (sauf si 'dark' explicitement sauvegardé)
            if (saved === 'dark') document.documentElement.classList.add('dark');
        })();
    </script>
</head>
<body class="bg-gray-50 dark:bg-[#0C0C0C] text-gray-900 dark:text-gray-100"
      x-data
      x-init="
        Alpine.store('sidebar', {
            isExpanded: window.innerWidth >= 1280,
            isHovered: false,
            isMobileOpen: false,
            get isOpen() { return this.isExpanded || this.isHovered || this.isMobileOpen; },
            toggleExpanded() { this.isExpanded = !this.isExpanded; },
            toggleMobileOpen() { this.isMobileOpen = !this.isMobileOpen; },
            setHovered(val) { if (!this.isExpanded && window.innerWidth >= 1280) this.isHovered = val; }
        });
        Alpine.store('theme', {
            // Par défaut: mode clair (sauf si 'dark' explicitement sauvegardé)
            mode: localStorage.getItem('theme') || 'light',
            toggle() {
                this.mode = this.mode === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', this.mode);
                document.documentElement.classList.toggle('dark', this.mode === 'dark');
            }
        });
      ">

    <div class="flex min-h-screen">

        <!-- ═══════ SIDEBAR ═══════ -->
        <aside id="sidebar"
            class="fixed left-0 top-0 flex flex-col h-screen px-5 transition-all duration-300 ease-in-out z-[99999] border-r border-gray-200 dark:border-white/[0.06]"
            :class="{
                'w-[280px]': $store.sidebar.isOpen,
                'w-[80px]': !$store.sidebar.isOpen,
                'translate-x-0': $store.sidebar.isMobileOpen,
                '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
            }"
            @mouseenter="$store.sidebar.setHovered(true)"
            @mouseleave="$store.sidebar.setHovered(false)">

            <!-- Logo -->
            <div class="pt-7 pb-6 flex"
                :class="!$store.sidebar.isOpen ? 'xl:justify-center' : 'justify-start'">
                <a href="/" class="flex items-center gap-2.5">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand">
                        <svg class="h-5 w-5 text-[#0C0C0C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </span>
                    <span x-show="$store.sidebar.isOpen" class="text-lg font-bold sidebar-logo-text font-display tracking-tight">PapiGPT</span>
                </a>
            </div>

            <!-- Nav Menu -->
            <nav class="flex flex-col overflow-y-auto flex-1 pb-4">
                <div class="flex flex-col gap-5">
                    <!-- Main -->
                    <div>
                        <h2 class="mb-3 text-[0.65rem] uppercase tracking-[0.2em] flex text-gray-500"
                            :class="!$store.sidebar.isOpen ? 'lg:justify-center' : 'justify-start'">
                            <span x-show="$store.sidebar.isOpen">Menu</span>
                            <svg x-show="!$store.sidebar.isOpen" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="6" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="18" cy="12" r="1.5"/>
                            </svg>
                        </h2>
                        <ul class="flex flex-col gap-1">
                            <li>
                                <a href="{{ route('dashboard') }}"
                                   class="menu-item {{ request()->routeIs('dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                   :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span x-show="$store.sidebar.isOpen">Tableau de bord</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('documents.index') }}"
                                   class="menu-item {{ request()->routeIs('documents.index') || request()->routeIs('documents.show') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                   :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span x-show="$store.sidebar.isOpen">Documents</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Nouveau document (dropdown) -->
                    <div x-data="{ openNew: false }" class="relative">
                        <ul class="flex flex-col gap-1">
                            <li>
                                <button @click="openNew = !openNew"
                                   class="menu-item menu-item-inactive w-full text-left {{ request()->routeIs('documents.create') ? 'menu-item-active' : '' }}"
                                   :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <span x-show="$store.sidebar.isOpen" class="flex-1 flex items-center justify-between">
                                        Nouveau
                                        <svg class="h-4 w-4 transition-transform" :class="openNew ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </span>
                                </button>
                            </li>
                        </ul>
                        <div x-show="openNew && $store.sidebar.isOpen" x-collapse class="ml-5 mt-1 flex flex-col gap-0.5 border-l border-gray-200 dark:border-white/[0.08] pl-3">
                            <a href="{{ route('documents.create', ['type' => 'letter']) }}" class="text-sm py-1.5 px-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300 {{ request('type') === 'letter' ? 'text-brand font-semibold' : 'text-gray-600' }}">Lettre</a>
                            <a href="{{ route('documents.create', ['type' => 'invoice_proforma']) }}" class="text-sm py-1.5 px-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300 {{ request('type') === 'invoice_proforma' ? 'text-brand font-semibold' : 'text-gray-600' }}">Facture Proforma</a>
                            <a href="{{ route('documents.create', ['type' => 'invoice_final']) }}" class="text-sm py-1.5 px-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300 {{ request('type') === 'invoice_final' ? 'text-brand font-semibold' : 'text-gray-600' }}">Facture Définitive</a>
                            <a href="{{ route('documents.create', ['type' => 'contrat']) }}" class="text-sm py-1.5 px-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300 {{ request('type') === 'contrat' ? 'text-brand font-semibold' : 'text-gray-600' }}">Contrat</a>
                            <a href="{{ route('documents.create', ['type' => 'note_officielle']) }}" class="text-sm py-1.5 px-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300 {{ request('type') === 'note_officielle' ? 'text-brand font-semibold' : 'text-gray-600' }}">Note Officielle</a>
                            <a href="{{ route('documents.create', ['type' => 'page_garde']) }}" class="text-sm py-1.5 px-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/[0.04] dark:text-gray-300 {{ request('type') === 'page_garde' ? 'text-brand font-semibold' : 'text-gray-600' }}">Page de Garde</a>
                        </div>
                    </div>

                    <!-- Plus -->
                    <div>
                        <h2 class="mb-3 text-[0.65rem] uppercase tracking-[0.2em] flex text-gray-500"
                            :class="!$store.sidebar.isOpen ? 'lg:justify-center' : 'justify-start'">
                            <span x-show="$store.sidebar.isOpen">Plus</span>
                            <svg x-show="!$store.sidebar.isOpen" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="6" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="18" cy="12" r="1.5"/>
                            </svg>
                        </h2>
                        <ul class="flex flex-col gap-1">
                            <li>
                                <a href="{{ route('templates.index') }}"
                                   class="menu-item {{ request()->routeIs('templates.*') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                   :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                                    </svg>
                                    <span x-show="$store.sidebar.isOpen">Templates</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                   class="menu-item {{ request()->routeIs('profile.edit') ? 'menu-item-active' : 'menu-item-inactive' }}"
                                   :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span x-show="$store.sidebar.isOpen">Mon profil</span>
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                       class="menu-item menu-item-inactive w-full text-left"
                                       :class="!$store.sidebar.isOpen ? 'xl:justify-center' : ''">
                                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span x-show="$store.sidebar.isOpen">Déconnexion</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Sidebar Mobile Backdrop -->
        <div x-show="$store.sidebar.isMobileOpen"
             @click="$store.sidebar.isMobileOpen = false"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[99998] xl:hidden"
             x-transition.opacity></div>

        <!-- ═══════ CONTENT AREA ═══════ -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden transition-all duration-300"
             :class="{
                'xl:ml-[280px]': $store.sidebar.isOpen,
                'xl:ml-[80px]': !$store.sidebar.isOpen
             }">

            <!-- Header -->
            <header class="sticky top-0 w-full z-[9999] border-b border-gray-200 dark:border-white/[0.06] bg-white/80 dark:bg-[#0C0C0C]/80 backdrop-blur-xl">
                <div class="flex items-center justify-between px-4 py-3 xl:px-6 lg:py-4">
                    <div class="flex items-center gap-3">
                        <!-- Desktop Toggle -->
                        <button @click="$store.sidebar.toggleExpanded()"
                                class="hidden xl:flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-white/[0.08] text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/[0.04] transition">
                            <svg width="16" height="12" viewBox="0 0 16 12" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.583 1C0.583 0.586 0.919 0.25 1.333 0.25H14.667C15.081 0.25 15.417 0.586 15.417 1C15.417 1.414 15.081 1.75 14.667 1.75H1.333C0.919 1.75 0.583 1.414 0.583 1ZM0.583 11C0.583 10.586 0.919 10.25 1.333 10.25H14.667C15.081 10.25 15.417 10.586 15.417 11C15.417 11.414 15.081 11.75 14.667 11.75H1.333C0.919 11.75 0.583 11.414 0.583 11ZM1.333 5.25C0.919 5.25 0.583 5.586 0.583 6C0.583 6.414 0.919 6.75 1.333 6.75H8C8.414 6.75 8.75 6.414 8.75 6C8.75 5.586 8.414 5.25 8 5.25H1.333Z" fill="currentColor"/>
                            </svg>
                        </button>

                        <!-- Mobile Toggle -->
                        <button @click="$store.sidebar.toggleMobileOpen()"
                                class="flex xl:hidden items-center justify-center w-10 h-10 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/[0.04]">
                            <svg x-show="!$store.sidebar.isMobileOpen" width="16" height="12" viewBox="0 0 16 12" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.583 1C0.583 0.586 0.919 0.25 1.333 0.25H14.667C15.081 0.25 15.417 0.586 15.417 1C15.417 1.414 15.081 1.75 14.667 1.75H1.333C0.919 1.75 0.583 1.414 0.583 1ZM0.583 11C0.583 10.586 0.919 10.25 1.333 10.25H14.667C15.081 10.25 15.417 10.586 15.417 11C15.417 11.414 15.081 11.75 14.667 11.75H1.333C0.919 11.75 0.583 11.414 0.583 11ZM1.333 5.25C0.919 5.25 0.583 5.586 0.583 6C0.583 6.414 0.919 6.75 1.333 6.75H8C8.414 6.75 8.75 6.414 8.75 6C8.75 5.586 8.414 5.25 8 5.25H1.333Z" fill="currentColor"/>
                            </svg>
                            <svg x-show="$store.sidebar.isMobileOpen" width="20" height="20" viewBox="0 0 24 24" fill="none" style="display:none;">
                                <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>

                        <!-- Mobile Logo -->
                        <a href="/" class="xl:hidden flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand">
                                <svg class="h-4 w-4 text-[#0C0C0C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </span>
                            <span class="text-base font-bold text-gray-900 dark:text-white font-display">PapiGPT</span>
                        </a>

                        <!-- Page Title -->
                        <h1 class="hidden xl:block text-lg font-semibold text-gray-900 dark:text-white font-display">@yield('title', 'Dashboard')</h1>
                    </div>

                    <!-- Right Actions -->
                    <div class="flex items-center gap-3">
                        <!-- Theme Toggle -->
                        <button @click="$store.theme.toggle()"
                                class="flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-white/[0.08] text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/[0.04] transition">
                            <svg class="hidden dark:block w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <svg class="dark:hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>

                        <!-- User Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2.5 text-sm">
                                <span class="hidden lg:block text-right">
                                    <span class="block font-medium dark:text-white">{{ Auth::user()->name }}</span>
                                    <span class="block text-xs text-gray-500">{{ Auth::user()->email }}</span>
                                </span>
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand text-[#0C0C0C] font-bold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </span>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute right-0 mt-3 w-56 rounded-2xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] shadow-xl z-[99999]"
                                 x-cloak>
                                <div class="p-3 space-y-1 border-b border-gray-100 dark:border-white/[0.06]">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/[0.04]">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Mon Profil
                                    </a>
                                </div>
                                <div class="p-3">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="mx-auto w-full max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                @if(session('success'))
                    <div class="mb-4 rounded-xl bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 px-4 py-3 text-sm text-green-700 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 px-4 py-3 text-sm text-red-700 dark:text-red-400">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Portail pour les modales (en dehors du conteneur overflow) --}}
    @stack('modals')

    @stack('scripts')
</body>
</html>
