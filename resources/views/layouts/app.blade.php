<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
           <style>
            body, .bg-slate-50, .bg-gray-100 { background-color: #0b0b0f !important; }
            .bg-white { background-color: #16161d !important; }

            .text-slate-800, .text-slate-900, .text-gray-800, .text-gray-900 { color: #f1f5f9 !important; }
            .text-slate-500, .text-slate-600, .text-gray-500, .text-gray-600 { color: #94a3b8 !important; }

            .border-slate-100, .border-slate-200, .border-gray-100, .border-gray-200 { border-color: #2a2a35 !important; }

            input, select, textarea {
                background-color: #1e1e28 !important;
                color: #f1f5f9 !important;
                border-color: #2a2a35 !important;
            }
                .bg-slate-100, .bg-gray-50, .bg-slate-200 { background-color: #1a1a22 !important; }
                .bg-slate-50\/50, .bg-slate-50\/70, .bg-gray-50\/50 { background-color: #1a1a22 !important; }                
                thead, thead tr, thead th { background-color: #1a1a22 !important; color: #94a3b8 !important; }               
                tbody tr { background-color: #16161d !important; }
                tbody tr:nth-child(even) { background-color: #1a1a22 !important; }
                tbody tr:hover { background-color: #22222d !important; }
                tbody td { color: #e2e8f0 !important; }
                .divide-y > :not([hidden]) ~ :not([hidden]) { border-color: #2a2a35 !important; }
                tbody tr, tbody td { border-color: #2a2a35 !important; }

                
                aside a[class*="from-violet"],
                aside a[class*="bg-gradient"] {
                    background-image: linear-gradient(135deg, #0ea5e9, #2563eb) !important;
                    box-shadow: 0 4px 14px rgba(14, 165, 233, 0.35) !important;
                    color: #ffffff !important;
                }


                aside nav a:hover { background-color: #1e1e28 !important; }

                .bg-violet-100 { background-color: rgba(14, 165, 233, 0.15) !important; }
                .text-violet-700, .text-violet-600 { color: #38bdf8 !important; }

                .from-violet-500 { --tw-gradient-from: #0ea5e9 !important; }
                .to-blue-400, .to-blue-500 { --tw-gradient-to: #2563eb !important; }
                .text-violet-500 { color: #38bdf8 !important; }

aside button,
aside button.bg-white,
aside button.bg-slate-50 { background-color: transparent !important; }

aside button:hover,
aside button[class*="hover:bg-"]:hover { background-color: #1e1e28 !important; }

.hover\:bg-slate-50:hover, .hover\:bg-slate-100:hover,
.hover\:bg-gray-50:hover, .hover\:bg-gray-100:hover { background-color: #1e1e28 !important; }


.hover\:bg-violet-50:hover, .hover\:bg-violet-100:hover,
.bg-violet-50 { background-color: #1e1e28 !important; }
aside .absolute a, aside .absolute button { color: #e2e8f0 !important; }
aside .absolute a:hover, aside .absolute button:hover { background-color: #22222d !important; }


.ring-violet-100, .ring-violet-200, .ring-violet-50 { --tw-ring-color: #0ea5e9 !important; }
.ring-white { --tw-ring-color: #2a2a35 !important; }

.bg-violet-600, .bg-violet-500 { background-color: #0ea5e9 !important; }
.hover\:bg-violet-700:hover { background-color: #070a0c !important; }

label, .text-slate-700, .text-slate-400, .text-gray-700, .text-gray-400 { color: #cbd5e1 !important; }

</style>
    </head> 
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-50 flex" x-data="{ sidebarOpen: false }">

            @include('layouts.navigation')

            <!-- Mobile overlay -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
                class="fixed inset-0 bg-black/30 z-30 lg:hidden" style="display: none;"></div>

            <!-- Main content area -->
            <div class="flex-1 min-w-0 lg:ml-64">
                <!-- Mobile top bar -->
                <div class="sticky top-0 z-20 bg-white/90 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-4 h-16 lg:hidden">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 to-blue-500 flex items-center justify-center text-white font-bold shadow-md">P</div>
                        <span class="font-extrabold text-lg bg-gradient-to-r from-violet-600 to-blue-500 bg-clip-text text-transparent">Parkir Kabasa</span>
                    </a>
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white border-b border-slate-100">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>