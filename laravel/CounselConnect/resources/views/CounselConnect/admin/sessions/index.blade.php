@extends('CounselConnect.layouts.admin')

@section('title', 'Session Records')
@section('page-title', 'Sessions')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Session Records</h2>
            <p class="text-sm text-gray-400 mt-1">Track and monitor all counseling sessions system-wide.</p>
        </div>
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

    {{-- ── Main Card ── --}}
    <div class="bg-white rounded-2xl border border-gray-100">

        {{-- Tabs + Search Row — stacks on mobile --}}
        <div class="px-4 sm:px-6 pt-5 pb-0 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            {{-- Date Filter Tabs — scrollable on mobile --}}
            <div class="flex items-center gap-1 overflow-x-auto pb-px flex-nowrap -mb-px">
                @php
                    $tabs = [
                        ''      => 'All Sessions',
                        'today' => 'Today',
                        'week'  => 'This Week',
                        'month' => 'This Month',
                    ];
                    $active = request('filter', '');
                @endphp
                @foreach($tabs as $value => $label)
                    <a href="{{ route('admin.sessions.index', array_merge(request()->except(['filter','page']), $value ? ['filter' => $value] : [])) }}"
                       class="shrink-0 px-3 sm:px-4 py-2.5 text-xs sm:text-sm font-medium rounded-t-lg border-b-2 transition-colors whitespace-nowrap
                              {{ $active === $value
                                    ? 'border-blue-600 text-blue-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.sessions.index') }}" class="flex items-center gap-2 pb-3">
                @if(request('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
                <div class="relative flex-1 sm:flex-none">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search students..."
                           class="pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 w-full sm:w-52 transition">
                </div>
                <button type="submit"
                        class="shrink-0 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition-colors cursor-pointer">
                    Search
                </button>
            </form>
        </div>

        {{-- ── Desktop Table (md+) ── --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="text-left text-xs font-semibold text-gray-400 px-6 py-3">Student Name</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Counselor Name</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Session Date</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Intervention</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Follow-Up</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-gray-50/60 transition-colors">

                            {{-- Student --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($session->student?->studentProfile?->profile_picture)
                                        <img src="{{ asset('storage/' . $session->student->studentProfile->profile_picture) }}"
                                             alt="{{ $session->student->name }}"
                                             class="w-8 h-8 rounded-full object-cover shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold shrink-0">
                                            {{ strtoupper(substr($session->student?->name ?? 'S', 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $session->student?->name ?? '—' }}</p>
                                        <p class="text-xs text-gray-400">{{ $session->student?->studentProfile?->student_id ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Counselor --}}
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-700">{{ $session->counselor?->name ?? '—' }}</span>
                            </td>

                            {{-- Session Date --}}
                            <td class="px-4 py-4">
                                <p class="text-sm text-gray-700">{{ $session->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $session->created_at->format('g:i A') }}</p>
                            </td>

                            {{-- Intervention --}}
                            <td class="px-4 py-4">
                                @if($session->intervention)
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-50 text-purple-700">
                                        {{ $session->intervention }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>

                            {{-- Follow-Up --}}
                            <td class="px-4 py-4">
                                @if($session->follow_up_needed)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-yellow-50 text-yellow-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Yes
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>No
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-4">
                                <a href="{{ route('admin.sessions.show', $session) }}"
                                   class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                                    View Record
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-sm text-gray-400 font-medium">No session records found</p>
                                    <p class="text-xs text-gray-300">Try adjusting your filters or search query.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Mobile Card List (below md) ── --}}
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($sessions as $session)
                <div class="px-4 py-4">
                    {{-- Top row: avatar + name + follow-up badge --}}
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <div class="flex items-center gap-3 min-w-0">
                            @if($session->student?->studentProfile?->profile_picture)
                                <img src="{{ asset('storage/' . $session->student->studentProfile->profile_picture) }}"
                                     alt="{{ $session->student->name }}"
                                     class="w-9 h-9 rounded-full object-cover shrink-0">
                            @else
                                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($session->student?->name ?? 'S', 0, 2)) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $session->student?->name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $session->student?->studentProfile?->student_id ?? '—' }}</p>
                            </div>
                        </div>
                        @if($session->follow_up_needed)
                            <span class="shrink-0 inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-semibold bg-yellow-50 text-yellow-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Follow-up
                            </span>
                        @endif
                    </div>

                    {{-- Meta --}}
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mb-3 ml-12">
                        <span class="text-xs text-gray-500">{{ $session->counselor?->name ?? '—' }}</span>
                        <span class="text-xs text-gray-400">{{ $session->created_at->format('M d, Y · g:i A') }}</span>
                        @if($session->intervention)
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold bg-purple-50 text-purple-700">
                                {{ $session->intervention }}
                            </span>
                        @endif
                    </div>

                    {{-- Action --}}
                    <div class="ml-12">
                        <a href="{{ route('admin.sessions.show', $session) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            View Record →
                        </a>
                    </div>
                </div>
            @empty
                <div class="px-4 py-12 text-center">
                    <p class="text-sm text-gray-400 font-medium">No session records found</p>
                    <p class="text-xs text-gray-300 mt-1">Try adjusting your filters or search query.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($sessions->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <p class="text-xs text-gray-400">
                    Showing {{ $sessions->firstItem() }}–{{ $sessions->lastItem() }} of {{ number_format($sessions->total()) }} sessions
                </p>
                <div class="flex items-center gap-1 flex-wrap">
                    @if($sessions->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </span>
                    @else
                        <a href="{{ $sessions->previousPageUrl() }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </a>
                    @endif

                    @foreach($sessions->getUrlRange(max(1, $sessions->currentPage()-2), min($sessions->lastPage(), $sessions->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-sm font-medium transition-colors
                                  {{ $page == $sessions->currentPage() ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if($sessions->hasMorePages())
                        <a href="{{ $sessions->nextPageUrl() }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
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

    {{-- ── Stats Cards — 1 col mobile, 3 col desktop ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">

        {{-- Session Velocity --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center mb-3">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>
                </svg>
            </div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Session Velocity</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ $stats['this_week'] }}
                <span class="text-sm font-medium text-blue-600 ml-1">this week</span>
            </p>
            <p class="text-xs text-gray-400 mt-1">Sessions recorded in the current week.</p>
        </div>

        {{-- Follow-Ups Needed --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-8 h-8 rounded-xl bg-yellow-50 flex items-center justify-center mb-3">
                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/>
                </svg>
            </div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Follow-Ups Needed</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ $stats['follow_up'] }}
                <span class="text-sm font-medium text-gray-400 ml-1">pending</span>
            </p>
            <p class="text-xs text-gray-400 mt-1">Sessions flagged as requiring follow-up.</p>
        </div>

        {{-- Total Sessions --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center mb-3">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Total Sessions</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ $stats['total'] }}
                <span class="text-sm font-medium text-gray-400 ml-1">all time</span>
            </p>
            <p class="text-xs text-gray-400 mt-1">All counseling sessions recorded in the system.</p>
        </div>

    </div>

@endsection 