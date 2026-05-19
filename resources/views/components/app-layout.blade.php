<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="MCI Business Management System">

        <title>{{ config('app.name', 'MCI Business') }} - Management System</title>

        <!-- Modern Sans Font (Inter/Figtree) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#F8F9FB] text-[#1B1B18] selection:bg-blue-100 selection:text-blue-700">
        <!-- Animated Background Decoration -->
        <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden">
            <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-blue-100/30 blur-[120px] rounded-full animate-pulse"></div>
            <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-indigo-100/20 blur-[100px] rounded-full animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="min-h-screen flex flex-col">
            <div class="sticky top-0 z-40">
                @include('layouts.navigation')
            </div>

            <div class="max-w-7xl mx-auto w-full px-6 sm:px-8 lg:px-10 py-4">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                        <span class="text-xl flex-shrink-0">⚠️</span>
                        <div class="flex-1">
                            <h3 class="font-semibold text-red-800 text-sm mb-1">Validation Errors</h3>
                            <ul class="text-red-700 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button onclick="this.parentElement.style.display='none'" class="text-red-500 hover:text-red-700 flex-shrink-0">✕</button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3 animate-in slide-in-from-top">
                        <span class="text-xl">✓</span>
                        <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                        <button onclick="this.parentElement.style.display='none'" class="text-green-500 hover:text-green-700 ml-auto">✕</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 animate-in slide-in-from-top">
                        <span class="text-xl">✗</span>
                        <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
                        <button onclick="this.parentElement.style.display='none'" class="text-red-500 hover:text-red-700 ml-auto">✕</button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg flex items-center gap-3 animate-in slide-in-from-top">
                        <span class="text-xl">⚡</span>
                        <p class="text-yellow-800 text-sm font-medium">{{ session('warning') }}</p>
                        <button onclick="this.parentElement.style.display='none'" class="text-yellow-500 hover:text-yellow-700 ml-auto">✕</button>
                    </div>
                @endif
            </div>

            @isset($header)
                <header class="bg-white/70 backdrop-blur-md border-b border-gray-200/50">
                    <div class="max-w-7xl mx-auto py-8 px-6 sm:px-8 lg:px-10">
                        <div class="flex items-center justify-between gap-4 flex-wrap">
                            <div class="space-y-1 flex-1">
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                                    {{ $header }}
                                </h2>
                                <p class="text-xs font-medium text-blue-600 uppercase tracking-[0.2em]">MCI Management System</p>
                            </div>
                            @isset($actions)
                                <div class="flex items-center gap-3 flex-wrap justify-end">
                                    {{ $actions }}
                                </div>
                            @endisset
                        </div>
                    </div>
                </header>
            @endisset

            <main class="flex-1 max-w-7xl mx-auto w-full py-10 px-6 sm:px-8 lg:px-10">
                <div class="transition-all duration-500 ease-in-out">
                    {{ $slot }}
                </div>
            </main>

            <footer class="mt-auto max-w-7xl mx-auto w-full px-6 py-8 flex flex-col md:flex-row justify-between items-center text-[10px] uppercase tracking-widest text-gray-500 font-bold border-t border-gray-200/50 gap-4">
                <div class="flex items-center gap-4 flex-wrap justify-center md:justify-start">
                    <span class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        MCI Cloud Secure
                    </span>
                    <span class="text-gray-400">•</span>
                    <span>v1.0.5</span>
                </div>
                <div class="text-center md:text-right">&copy; {{ date('Y') }} MCI Group. All rights reserved.</div>
            </footer>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const notifications = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"], [class*="bg-yellow-50"]');
                notifications.forEach(notification => {
                    if (notification.querySelector('button[onclick*="display"]')) {
                        setTimeout(() => {
                            notification.style.transition = 'opacity 0.3s ease-out';
                            notification.style.opacity = '0';
                            setTimeout(() => notification.style.display = 'none', 300);
                        }, 5000);
                    }
                });
            });
        </script>
    </body>
</html>
