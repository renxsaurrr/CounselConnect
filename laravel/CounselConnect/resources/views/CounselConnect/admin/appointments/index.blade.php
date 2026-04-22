@extends('CounselConnect.layouts.admin')

@section('title', 'Appointments')
@section('page-title', 'Appointments')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="flex items-start justify-between mb-6 gap-4">
        <div class="min-w-0">
            <h2 class="text-2xl font-bold text-gray-900">Appointments</h2>
            <p class="text-sm text-gray-400 mt-1">Manage and monitor student counseling requests across the university network.</p>
        </div>
        <a href="{{ route('admin.appointments.create') }}"
           class="shrink-0 flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-blue-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            <span class="hidden sm:inline">Manual Booking</span>
            <span class="sm:hidden">Book</span>
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

    {{-- ── Main Card ── --}}
    <div class="bg-white rounded-2xl border border-gray-100">

        {{-- Tabs + Search: stacked on mobile, side-by-side on md+ --}}
        <div class="px-4 sm:px-6 pt-5 pb-0 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            {{-- Status Tabs: horizontally scrollable on mobile --}}
            <div class="flex items-center gap-1 overflow-x-auto pb-px">
                @php
                    $tabs = [
                        'all'       => 'All Appointments',
                        'pending'   => 'Pending',
                        'approved'  => 'Approved',
                        'completed' => 'Completed',
                    ];
                    $active = request('status', 'all');
                @endphp
                @foreach($tabs as $value => $label)
                    <a href="{{ route('admin.appointments.index', array_merge(request()->except(['status','page']), ['status' => $value])) }}"
                       class="whitespace-nowrap px-4 py-2.5 text-sm font-medium rounded-t-lg border-b-2 transition-colors -mb-px
                              {{ $active === $value
                                    ? 'border-blue-600 text-blue-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        {{ $label }}
                        @if($value !== 'all')
                            <span class="ml-1.5 text-xs px-1.5 py-0.5 rounded-full
                                {{ $active === $value ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $stats[$value] }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.appointments.index') }}" class="flex items-center gap-2 pb-3 md:pb-3 shrink-0">
                <input type="hidden" name="status" value="{{ $active }}">
                <div class="relative flex-1 md:flex-none">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by student name..."
                           class="w-full md:w-52 pl-9 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                </div>
                <button type="submit"
                        class="shrink-0 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-lg transition-colors">
                    Search
                </button>
            </form>
        </div>

        {{-- ═══════════════════════════════════════════
             MOBILE: Card list  (visible below md)
             ═══════════════════════════════════════════ --}}
        <div class="md:hidden divide-y divide-gray-50">
            @forelse($appointments as $appointment)
                @php
                    $concernStyle = match($appointment->concern_type) {
                        'Mental Health' => 'bg-purple-50 text-purple-700',
                        'Academic'      => 'bg-blue-50 text-blue-700',
                        'Career'        => 'bg-orange-50 text-orange-700',
                        'Personal'      => 'bg-pink-50 text-pink-700',
                        default         => 'bg-gray-100 text-gray-600',
                    };
                    $statusStyle = match($appointment->status) {
                        'pending'   => 'bg-yellow-50 text-yellow-700',
                        'approved'  => 'bg-green-50 text-green-700',
                        'completed' => 'bg-blue-50 text-blue-700',
                        'cancelled' => 'bg-red-50 text-red-500',
                        'rejected'  => 'bg-gray-100 text-gray-500',
                        default     => 'bg-gray-100 text-gray-500',
                    };
                @endphp
                <div class="px-4 py-4">

                    {{-- Top row: student avatar + name/ID + status badge --}}
                    <div class="flex items-center gap-3">
                        @if($appointment->student?->studentProfile?->profile_picture)
                            <img src="{{ asset('storage/' . $appointment->student->studentProfile->profile_picture) }}"
                                 alt="{{ $appointment->student->name }}"
                                 class="w-10 h-10 rounded-full object-cover shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold shrink-0">
                                {{ strtoupper(substr($appointment->student?->name ?? 'S', 0, 2)) }}
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $appointment->student?->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">ID: {{ $appointment->student?->studentProfile?->student_id ?? '—' }}</p>
                        </div>
                        <span class="inline-flex shrink-0 px-2.5 py-1 rounded-lg text-xs font-semibold uppercase tracking-wide {{ $statusStyle }}">
                            {{ $appointment->status }}
                        </span>
                    </div>

                    {{-- Middle row: counselor + concern --}}
                    <div class="mt-3 flex items-center gap-2 flex-wrap">
                        {{-- Counselor --}}
                        <div class="flex items-center gap-1.5">
                            @if($appointment->counselor?->counselorProfile?->profile_picture)
                                <img src="{{ asset('storage/' . $appointment->counselor->counselorProfile->profile_picture) }}"
                                     alt="{{ $appointment->counselor->name }}"
                                     class="w-5 h-5 rounded-full object-cover shrink-0">
                            @else
                                <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($appointment->counselor?->name ?? 'C', 0, 1)) }}
                                </div>
                            @endif
                            <span class="text-xs text-gray-500 truncate max-w-[120px]">{{ $appointment->counselor?->name ?? '—' }}</span>
                        </div>
                        <span class="text-gray-200 text-xs">•</span>
                        <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold {{ $concernStyle }}">
                            {{ $appointment->concern_type }}
                        </span>
                    </div>

                    {{-- Bottom row: date/time + view button --}}
                    <div class="mt-3 flex items-center justify-between">
                        <div class="flex items-center gap-1.5 text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}</span>
                            <span class="text-gray-300">·</span>
                            <span>{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}</span>
                        </div>
                        <a href="{{ route('admin.appointments.show', $appointment) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-50 hover:bg-blue-50 text-gray-500 hover:text-blue-600 text-xs font-medium transition-colors border border-gray-100 hover:border-blue-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            View
                        </a>
                    </div>

                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center gap-2">
                        <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-400 font-medium">No appointments found</p>
                        <p class="text-xs text-gray-300">Try adjusting your filters or search query.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- ═══════════════════════════════════════════
             DESKTOP: Full table  (visible from md up)
             ═══════════════════════════════════════════ --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full min-w-[700px]">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 sm:px-6 py-3">Student Name</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Assigned Counselor</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Concern Type</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Date & Time</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Status</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-gray-50/60 transition-colors">

                            {{-- Student --}}
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($appointment->student?->studentProfile?->profile_picture)
                                        <img src="{{ asset('storage/' . $appointment->student->studentProfile->profile_picture) }}"
                                             alt="{{ $appointment->student->name }}"
                                             class="w-8 h-8 rounded-full object-cover shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold shrink-0">
                                            {{ strtoupper(substr($appointment->student?->name ?? 'S', 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $appointment->student?->name ?? '—' }}</p>
                                        <p class="text-xs text-gray-400">ID: {{ $appointment->student?->studentProfile?->student_id ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Counselor --}}
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    @if($appointment->counselor?->counselorProfile?->profile_picture)
                                        <img src="{{ asset('storage/' . $appointment->counselor->counselorProfile->profile_picture) }}"
                                             alt="{{ $appointment->counselor->name }}"
                                             class="w-6 h-6 rounded-full object-cover shrink-0">
                                    @else
                                        <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-xs font-bold shrink-0">
                                            {{ strtoupper(substr($appointment->counselor?->name ?? 'C', 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="text-sm text-gray-700 truncate">{{ $appointment->counselor?->name ?? '—' }}</span>
                                </div>
                            </td>

                            {{-- Concern Type --}}
                            <td class="px-4 py-4">
                                @php
                                    $concernStyle = match($appointment->concern_type) {
                                        'Mental Health' => 'bg-purple-50 text-purple-700',
                                        'Academic'      => 'bg-blue-50 text-blue-700',
                                        'Career'        => 'bg-orange-50 text-orange-700',
                                        'Personal'      => 'bg-pink-50 text-pink-700',
                                        default         => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold {{ $concernStyle }}">
                                    {{ $appointment->concern_type }}
                                </span>
                            </td>

                            {{-- Date & Time --}}
                            <td class="px-4 py-4">
                                <p class="text-sm text-gray-700 font-medium">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}</p>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4">
                                @php
                                    $statusStyle = match($appointment->status) {
                                        'pending'   => 'bg-yellow-50 text-yellow-700',
                                        'approved'  => 'bg-green-50 text-green-700',
                                        'completed' => 'bg-blue-50 text-blue-700',
                                        'cancelled' => 'bg-red-50 text-red-500',
                                        'rejected'  => 'bg-gray-100 text-gray-500',
                                        default     => 'bg-gray-100 text-gray-500',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold uppercase tracking-wide {{ $statusStyle }}">
                                    {{ $appointment->status }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-4">
                                <a href="{{ route('admin.appointments.show', $appointment) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-50 hover:bg-blue-50 text-gray-500 hover:text-blue-600 text-xs font-medium transition-colors border border-gray-100 hover:border-blue-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    View
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-sm text-gray-400 font-medium">No appointments found</p>
                                    <p class="text-xs text-gray-300">Try adjusting your filters or search query.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($appointments->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-gray-400">
                    Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ number_format($appointments->total()) }} entries
                </p>
                <div class="flex items-center gap-1">
                    @if($appointments->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </span>
                    @else
                        <a href="{{ $appointments->previousPageUrl() }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </a>
                    @endif
                    @foreach($appointments->getUrlRange(max(1, $appointments->currentPage()-2), min($appointments->lastPage(), $appointments->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-sm font-medium transition-colors
                                  {{ $page == $appointments->currentPage() ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    @if($appointments->hasMorePages())
                        <a href="{{ $appointments->nextPageUrl() }}"
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

    {{-- ── Stats Cards: 1 col mobile → 3 col sm+ ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">

        {{-- Session Volume --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between mb-3">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Session Volume</p>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
            <p class="text-xs text-gray-400 mt-1">total appointments</p>
            <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600 rounded-full" style="width: {{ $stats['total'] > 0 ? min(100, ($stats['completed'] / $stats['total']) * 100) : 0 }}%"></div>
            </div>
        </div>

        {{-- Pending Approvals --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between mb-3">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Pending Approvals</p>
                @if($stats['pending'] > 0)
                    <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                @endif
            </div>
            <p class="text-3xl font-bold {{ $stats['pending'] > 0 ? 'text-yellow-600' : 'text-gray-900' }}">
                {{ $stats['pending'] }}
            </p>
            <p class="text-xs text-gray-400 mt-1">requires action</p>
            @if($stats['pending'] > 0)
                <a href="{{ route('admin.appointments.index', ['status' => 'pending']) }}"
                   class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                    Review now
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            @else
                <p class="text-xs text-green-500 mt-1 font-medium">All caught up!</p>
            @endif
        </div>

        {{-- Completion Rate --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between mb-3">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Completion Rate</p>
                <div class="flex gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-3.5 h-3.5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
            </div>
            @php
                $rate = $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0;
            @endphp
            <p class="text-3xl font-bold text-gray-900">{{ $rate }}<span class="text-lg font-medium text-gray-400">%</span></p>
            <p class="text-xs text-gray-400 mt-1">of {{ number_format($stats['approved'] + $stats['completed']) }} processed</p>
        </div>

    </div>

@endsection