<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CounselConnect') — Counselor Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- ── Mobile Backdrop ── --}}
        <div id="mobile-backdrop" class="lg:hidden hidden fixed inset-0 z-20 bg-gray-900/40 backdrop-blur-sm"
             onclick="closeMobileMenu()"></div>

        {{-- ── Sidebar ── --}}
        <aside id="sidebar"
               class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-100 flex flex-col shrink-0
                      -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">

            {{-- Brand --}}
            <div class="px-6 py-5 border-b border-gray-100">
                <span class="text-blue-600 font-bold text-lg tracking-tight">CounselConnect</span>
                <p class="text-xs text-gray-400 mt-0.5">Counselor Portal</p>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">

                <a href="{{ route('counselor.dashboard') }}"
                   onclick="closeMobileMenu()"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('counselor.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m-4 0h4"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('counselor.appointments.index') }}"
                   onclick="closeMobileMenu()"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('counselor.appointments.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Appointments
                </a>

                <a href="{{ route('counselor.sessions.index') }}"
                   onclick="closeMobileMenu()"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('counselor.sessions.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Sessions
                </a>

                <a href="{{ route('counselor.referrals.index') }}"
                   onclick="closeMobileMenu()"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('counselor.referrals.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    Referrals
                </a>

                <a href="{{ route('counselor.students.index') }}"
                   onclick="closeMobileMenu()"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('counselor.students.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Students
                </a>

                <a href="{{ route('counselor.schedule.index') }}"
                   onclick="closeMobileMenu()"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('counselor.schedule.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Schedule
                </a>

                <a href="{{ route('counselor.profile.edit') }}"
                   onclick="closeMobileMenu()"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                          {{ request()->routeIs('counselor.profile.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>

            </nav>

            {{-- Logout --}}
            <div class="px-4 py-4 border-t border-gray-100">
                <button type="button"
                        onclick="openLogoutModal()"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-red-50 
                        hover:text-red-500 transition-colors cursor-pointer">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </div>

            {{-- Hidden logout form --}}
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>

        </aside>

        {{-- ── Main Content ── --}}
        <div class="flex-1 flex flex-col overflow-hidden min-w-0">

            {{-- Top bar --}}
            <header class="bg-white border-b border-gray-100 px-4 sm:px-8 py-4 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    {{-- Hamburger (mobile only) --}}
                    <button id="mobile-menu-btn"
                            class="lg:hidden p-2 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-base sm:text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    {{-- Avatar --}}
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400">
                                {{ Auth::user()->counselorProfile?->specialization ?? 'Counselor' }}
                            </p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                            @if(Auth::user()->counselorProfile?->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->counselorProfile->profile_picture) }}"
                                     alt="{{ Auth::user()->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto px-4 sm:px-6 lg:px-8 py-5 lg:py-6">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- ── Logout Confirmation Modal ── --}}
    <div id="logout-modal"
         class="fixed inset-0 z-50 flex items-center justify-center hidden"
         aria-modal="true" role="dialog">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeLogoutModal()"></div>
        {{-- Panel --}}
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 p-6 flex flex-col items-center gap-4">
            {{-- Icon --}}
            <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>
            {{-- Text --}}
            <div class="text-center">
                <h2 class="text-base font-semibold text-gray-900">Log out of CounselConnect?</h2>
                <p class="text-sm text-gray-500 mt-1">You'll need to sign in again to access your account.</p>
            </div>
            {{-- Actions --}}
            <div class="flex gap-3 w-full mt-1">
                <button type="button"
                        onclick="closeLogoutModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium border border-gray-200 text-gray-600 hover:bg-gray-100 cursor-pointer
                         transition-colors">
                    Cancel
                </button>
                <button type="button"
                        onclick="document.getElementById('logout-form').submit()"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium bg-red-500 text-white hover:bg-red-600 cursor-pointer transition-colors">
                    Yes, log out
                </button>
            </div>
        </div>
    </div>

    <script>
        const sidebar  = document.getElementById('sidebar');
        const backdrop = document.getElementById('mobile-backdrop');

        document.getElementById('mobile-menu-btn').addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });

        function closeMobileMenu() {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        function openLogoutModal() {
            document.getElementById('logout-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        function closeLogoutModal() {
            document.getElementById('logout-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeLogoutModal();
        });
    </script>

    @stack('scripts')

</body>
</html>