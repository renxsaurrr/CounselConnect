@extends('CounselConnect.layouts.admin')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="flex items-start justify-between mb-6 gap-4">
        <div class="min-w-0">
            <h2 class="text-2xl font-bold text-gray-900">Manage Community</h2>
            <p class="text-sm text-gray-400 mt-1">Directory of students, faculty counselors, and system administrators.</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           class="shrink-0 flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-blue-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            <span class="hidden sm:inline">Add User</span>
            <span class="sm:hidden">Add</span>
        </a>
    </div>

    {{-- ── Flash Message ── --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3 rounded-xl">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Stats Cards: 2 col mobile → 4 col sm+ ── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Total Users</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Active</p>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['active']) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Counselors</p>
            <p class="text-3xl font-bold text-green-600">{{ number_format($stats['counselors']) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Students</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['students']) }}</p>
        </div>
    </div>

    {{-- ── Table Card ── --}}
    <div class="bg-white rounded-2xl border border-gray-100">

        {{-- Tabs + Search + Sort --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between px-4 sm:px-6 pt-5 pb-4 border-b border-gray-50 gap-3">

            {{-- Role Tabs: scrollable on mobile --}}
            <div class="flex items-center gap-1 overflow-x-auto pb-1 lg:pb-0 shrink-0">
                @foreach(['all' => 'All Users', 'student' => 'Students', 'counselor' => 'Counselors', 'admin' => 'Admins'] as $value => $label)
                    @php $active = request('role', 'all') === $value; @endphp
                    <a href="{{ route('admin.users.index', array_merge(request()->except(['role', 'page']), ['role' => $value === 'all' ? null : $value, 'search' => request('search'), 'sort' => request('sort')])) }}"
                       class="whitespace-nowrap px-3.5 py-1.5 rounded-lg text-sm font-medium transition-colors
                              {{ $active ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Search + Sort row --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">

                {{-- Search Bar --}}
                <form method="GET" action="{{ route('admin.users.index') }}" id="search-form" class="flex items-center gap-2">
                    @if(request('role'))
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    <div class="relative flex-1 sm:flex-none">
                        <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            name="search"
                            id="search-input"
                            value="{{ request('search') }}"
                            placeholder="Search name or email…"
                            autocomplete="off"
                            class="w-full sm:w-56 pl-9 pr-9 py-1.5 text-sm rounded-xl border border-gray-200 bg-gray-50 text-gray-800
                                   placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   transition"
                        >
                        @if(request('search'))
                            <a href="{{ route('admin.users.index', array_merge(request()->except(['search', 'page']), [])) }}"
                               class="absolute inset-y-0 right-2.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                               title="Clear search">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                    <button type="submit"
                            class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors cursor-pointer shrink-0">
                        Search
                    </button>
                </form>

                {{-- Sort Dropdown --}}
                <form method="GET" action="{{ route('admin.users.index') }}" id="sort-form">
                    @if(request('role'))
                        <input type="hidden" name="role" value="{{ request('role') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M6 12h12M9 17h6"/>
                        </svg>
                        <span class="text-gray-400 font-medium">Sort by:</span>
                        <select
                            name="sort"
                            onchange="document.getElementById('sort-form').submit()"
                            class="text-xs font-medium text-gray-600 bg-transparent border-0 outline-none cursor-pointer focus:ring-0 pr-1 -ml-1"
                        >
                            <option value="newest"    {{ request('sort', 'newest') === 'newest'    ? 'selected' : '' }}>Newest</option>
                            <option value="oldest"    {{ request('sort') === 'oldest'    ? 'selected' : '' }}>Oldest</option>
                            <option value="name_asc"  {{ request('sort') === 'name_asc'  ? 'selected' : '' }}>Name A→Z</option>
                            <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name Z→A</option>
                        </select>
                    </div>
                </form>

            </div>
        </div>

        {{-- Active search indicator --}}
        @if(request('search'))
            <div class="px-4 sm:px-6 py-2.5 bg-blue-50 border-b border-blue-100 flex items-center justify-between">
                <p class="text-xs text-blue-700">
                    Showing results for <span class="font-semibold">"{{ request('search') }}"</span>
                    &mdash; {{ number_format($users->total()) }} {{ Str::plural('user', $users->total()) }} found
                </p>
                <a href="{{ route('admin.users.index', request()->except(['search', 'page'])) }}"
                   class="text-xs text-blue-600 hover:underline font-medium">Clear search</a>
            </div>
        @endif

        {{-- ═══════════════════════════════════════════
             MOBILE: Card list  (visible below md)
             ═══════════════════════════════════════════ --}}
        <div class="md:hidden divide-y divide-gray-50">
            @forelse($users as $user)
                @php
                    $pic = match($user->role) {
                        'student'   => $user->studentProfile?->profile_picture,
                        'counselor' => $user->counselorProfile?->profile_picture,
                        'admin'     => $user->adminProfile?->profile_picture,
                        default     => null,
                    };
                    $avatarStyle = match($user->role) {
                        'counselor' => 'bg-green-100 text-green-700',
                        'admin'     => 'bg-purple-100 text-purple-700',
                        default     => 'bg-blue-100 text-blue-700',
                    };
                    $roleStyle = match($user->role) {
                        'student'   => 'bg-blue-50 text-blue-600',
                        'counselor' => 'bg-green-50 text-green-600',
                        'admin'     => 'bg-purple-50 text-purple-600',
                        default     => 'bg-gray-50 text-gray-500',
                    };
                @endphp
                <div class="px-4 py-4 {{ $user->is_active ? '' : 'opacity-60' }}">

                    {{-- Top row: avatar + name/email + role badge --}}
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold shrink-0 overflow-hidden {{ $avatarStyle }}">
                            @if($pic)
                                <img src="{{ asset('storage/' . $pic) }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                            @else
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                        <span class="inline-flex shrink-0 px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide {{ $roleStyle }}">
                            {{ $user->role }}
                        </span>
                    </div>

                    {{-- Bottom row: status + date + actions --}}
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            {{-- Status --}}
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                                <span class="text-xs {{ $user->is_active ? 'text-gray-600' : 'text-gray-400' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            {{-- Date --}}
                            <span class="text-xs text-gray-400">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>

                        {{-- Actions --}}
                        @if($user->is_active)
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="p-2 rounded-lg text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-colors" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="p-2 rounded-lg text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                    </svg>
                                </a>
                                <form id="deactivate-form-{{ $user->id }}" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="openDeactivateModal('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                                            class="p-2 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors cursor-pointer" title="Deactivate">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs text-gray-300 italic">Deactivated</span>
                        @endif
                    </div>

                </div>
            @empty
                <div class="px-6 py-16 text-center">
                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                    @if(request('search'))
                        <p class="text-sm text-gray-400">No users match <span class="font-medium text-gray-500">"{{ request('search') }}"</span>.</p>
                        <a href="{{ route('admin.users.index', request()->except(['search', 'page'])) }}"
                           class="inline-block mt-3 text-xs text-blue-600 hover:underline font-medium">Clear search →</a>
                    @else
                        <p class="text-sm text-gray-400">No users found.</p>
                        <a href="{{ route('admin.users.create') }}" class="inline-block mt-3 text-xs text-blue-600 hover:underline font-medium">
                            Add the first user →
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- ═══════════════════════════════════════════
             DESKTOP: Full table  (visible from md up)
             ═══════════════════════════════════════════ --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full min-w-[640px]">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 sm:px-6 py-3">Name & Email</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Role</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Status</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Date Created</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/60 transition-colors {{ $user->is_active ? '' : 'opacity-60' }}">

                            {{-- Name & Email --}}
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @php
                                        $pic = match($user->role) {
                                            'student'   => $user->studentProfile?->profile_picture,
                                            'counselor' => $user->counselorProfile?->profile_picture,
                                            'admin'     => $user->adminProfile?->profile_picture,
                                            default     => null,
                                        };
                                        $avatarStyle = match($user->role) {
                                            'counselor' => 'bg-green-100 text-green-700',
                                            'admin'     => 'bg-purple-100 text-purple-700',
                                            default     => 'bg-blue-100 text-blue-700',
                                        };
                                    @endphp
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold shrink-0 overflow-hidden {{ $avatarStyle }}">
                                        @if($pic)
                                            <img src="{{ asset('storage/' . $pic) }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                                        @else
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Role Badge --}}
                            <td class="px-4 py-4">
                                @php
                                    $roleStyle = match($user->role) {
                                        'student'   => 'bg-blue-50 text-blue-600',
                                        'counselor' => 'bg-green-50 text-green-600',
                                        'admin'     => 'bg-purple-50 text-purple-600',
                                        default     => 'bg-gray-50 text-gray-500',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide {{ $roleStyle }}">
                                    {{ $user->role }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                                    <span class="text-sm {{ $user->is_active ? 'text-gray-700' : 'text-gray-400' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Date --}}
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-4">
                                @if($user->is_active)
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                           class="p-1.5 rounded-lg text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-colors" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="p-1.5 rounded-lg text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                            </svg>
                                        </a>
                                        <form id="deactivate-form-{{ $user->id }}" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                            @csrf @method('DELETE')
                                            <button type="button"
                                                    onclick="openDeactivateModal('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                                                    class="p-1.5 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors cursor-pointer" title="Deactivate">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-300 italic">Deactivated</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                </svg>
                                @if(request('search'))
                                    <p class="text-sm text-gray-400">No users match <span class="font-medium text-gray-500">"{{ request('search') }}"</span>.</p>
                                    <a href="{{ route('admin.users.index', request()->except(['search', 'page'])) }}"
                                       class="inline-block mt-3 text-xs text-blue-600 hover:underline font-medium">
                                        Clear search →
                                    </a>
                                @else
                                    <p class="text-sm text-gray-400">No users found.</p>
                                    <a href="{{ route('admin.users.create') }}" class="inline-block mt-3 text-xs text-blue-600 hover:underline font-medium">
                                        Add the first user →
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-gray-400">
                    Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ number_format($users->total()) }} users
                </p>
                <div class="flex items-center gap-1">
                    @if($users->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </a>
                    @endif
                    @foreach($users->getUrlRange(max(1, $users->currentPage()-2), min($users->lastPage(), $users->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-sm font-medium transition-colors
                                  {{ $page === $users->currentPage() ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </a>
                    @else
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif

    </div>

{{-- ── Deactivate Confirmation Modal ── --}}
<div id="modal-deactivate"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     onclick="if(event.target===this) closeDeactivateModal()">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 z-10">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mx-auto mb-4">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
        </div>
        <h3 class="text-base font-semibold text-gray-900 text-center">Deactivate Account?</h3>
        <p class="text-sm text-gray-500 text-center mt-1.5">
            You're about to deactivate <span id="modal-deactivate-name" class="font-semibold text-gray-700"></span>.
            This will revoke their access to the portal.
        </p>
        <div class="flex gap-3 mt-6">
            <button type="button"
                    onclick="closeDeactivateModal()"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                Cancel
            </button>
            <button type="button"
                    id="modal-deactivate-confirm"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition-colors cursor-pointer">
                Yes, Deactivate
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let _deactivateFormId = null;

    function openDeactivateModal(userId, userName) {
        _deactivateFormId = 'deactivate-form-' + userId;
        document.getElementById('modal-deactivate-name').textContent = userName;
        document.getElementById('modal-deactivate').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeactivateModal() {
        document.getElementById('modal-deactivate').classList.add('hidden');
        document.body.style.overflow = '';
        _deactivateFormId = null;
    }

    document.getElementById('modal-deactivate-confirm').addEventListener('click', () => {
        if (_deactivateFormId) {
            document.getElementById(_deactivateFormId).submit();
        }
    });

    document.getElementById('search-input').addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            this.value = '';
            document.getElementById('search-form').submit();
        }
    });
</script>
@endpush

@endsection