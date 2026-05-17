<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MCI Business') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased selection:bg-blue-100 selection:text-blue-700">
        <!-- Modern Background with Animated Blobs -->
        <div class="fixed inset-0 z-[-1] bg-[#FDFDFC] overflow-hidden">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-blue-100/50 blur-[120px] rounded-full animate-pulse"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-indigo-100/50 blur-[120px] rounded-full animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Modern MCI Logo Wrapper -->
            <div class="mb-8 transition-transform duration-500 hover:scale-105">
                <a href="/" class="flex flex-col items-center gap-3 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-xl ring-4 ring-blue-50 group-hover:shadow-blue-200/50 transition-all">
                        <span class="text-white font-black text-xl tracking-tighter italic">MCI</span>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-400 group-hover:text-blue-600 transition-colors">Business OS</span>
                </a>
            </div>

            <!-- Glassmorphic Card Container -->
            <div class="w-full sm:max-w-[440px] mt-2 px-8 py-10 bg-white/80 backdrop-blur-xl border border-white shadow-[0_20px_50px_rgba(0,0,0,0.04)] overflow-hidden sm:rounded-[2.5rem]">
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

            <!-- Minimalist Footer Links -->
            <div class="mt-8 flex gap-6 text-[10px] uppercase tracking-widest font-bold text-gray-400">
                <a href="#" class="hover:text-blue-600 transition">Privacy</a>
                <span>•</span>
                <a href="#" class="hover:text-blue-600 transition">Help Center</a>
                <span>•</span>
                <a href="#" class="hover:text-blue-600 transition">MCI Status</a>
            </div>
        </div>
    </body>
</html>