<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PapiGPT') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --brand: #BEFF00;
                --brand-hover: #a8e000;
            }
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .font-display { font-family: 'Syne', sans-serif; }
        </style>

        <script>
            (function() {
                const saved = localStorage.getItem('theme');
                if (saved === 'dark') document.documentElement.classList.add('dark');
            })();
        </script>
    </head>
    <body class="antialiased bg-gray-50 dark:bg-[#0C0C0C] text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 mb-8">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl" style="background-color: #BEFF00;">
                    <svg class="h-6 w-6 text-[#0C0C0C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white" style="font-family: 'Syne', sans-serif; letter-spacing: -0.02em;">PapiGPT</span>
            </a>

            {{-- Card --}}
            <div class="w-full sm:max-w-md rounded-2xl border border-gray-200 dark:border-white/[0.06] bg-white dark:bg-[#161616] p-8 shadow-xl dark:shadow-2xl transition-colors duration-300">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <p class="mt-6 text-xs text-gray-400 dark:text-gray-600">&copy; {{ date('Y') }} PapiGPT &mdash; SINIING SOHOMA TILO SARL</p>
        </div>
    </body>
</html>
