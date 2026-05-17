<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-200/50 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="flex justify-between h-20"> <!-- Increased height for a more premium feel -->
            <div class="flex items-center">
                <!-- Modern MCI Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-blue-500/20 transition-all duration-300">
                            <span class="text-white font-black text-sm tracking-tighter italic">MCI</span>
                        </div>
                        <div class="hidden lg:block">
                            <p class="text-sm font-bold text-gray-900 leading-none">Management</p>
                            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1">Command Center</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex items-center">
                    {{-- ADMIN NAVIGATION --}}
                    @role('Admin')

                        <x-nav-link :href="route('admin.dashboard')"
                            :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link :href="route('employee.register')"
                            :active="request()->routeIs('employee.register')">
                            Employee Registration
                        </x-nav-link>

                    @endrole
                    {{-- OPERATION NAVIGATION --}}
                    @role('Operations')

                        <x-nav-link :href="route('operation.dashboard')"
                            :active="request()->routeIs('operation.dashboard')">
                            Dashboard
                        </x-nav-link>
                    @endrole

                    <!-- User Access Registration -->
                    @role('User')
                        <x-nav-link :href="route('employee.register')"
                            :active="request()->routeIs('employee.register')" 
                            class="relative px-3 py-2 text-sm font-medium transition-colors duration-200 border-none! text-gray-500 hover:text-gray-900 group">
                            {{ __('Employee Account Registration') }}
                        </x-nav-link>
                    @endrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="64"> <!-- Increased width for profile info -->
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-1 py-1 border border-transparent text-sm leading-4 font-medium rounded-2xl text-gray-500 hover:bg-gray-50 transition ease-in-out duration-150 focus:outline-none">
                                <!-- User Avatar Placeholder -->
                                <div class="w-10 h-10 bg-gray-900 rounded-xl flex items-center justify-center text-white font-bold text-xs shadow-sm">
                                    {{ substr(Auth::user()->name, 0, 2) }}
                                </div>
                                
                                <div class="ms-3 text-left hidden md:block mr-2">
                                    <div class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono uppercase tracking-tighter">{{ optional(Auth::user()->position)->name }}</div>
                                </div>

                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Account</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')" class="mt-1 flex items-center gap-2">
                                <span>👤</span> {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-red-600 flex items-center gap-2">
                                    <span>🚪</span> {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl border-none!">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 border-t border-gray-100">
            <div class="px-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-900 rounded-xl flex items-center justify-center text-white font-bold text-xs">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div>
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-xl border-none!">
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="rounded-xl border-none! text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>